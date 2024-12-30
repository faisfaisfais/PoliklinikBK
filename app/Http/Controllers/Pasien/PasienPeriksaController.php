<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use App\Models\Poli;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasienPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID pasien yang sedang login
        $pasienId = auth('pasien')->id();

        // Ambil data DaftarPoli berdasarkan ID pasien yang sedang login
        $pasien_periksa = DaftarPoli::with(['jadwal_appointment'])
            ->where('pasien_id', $pasienId)  // Filter berdasarkan ID pasien
            ->get();

        return view('pages.pasien.pasien_periksa.index', [
            'pasien_periksa' => $pasien_periksa,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data poli yang ada
        $listPoli = Poli::all();

        return view('pages.pasien.pasien_periksa.create', compact('listPoli'));
    }

    public function getJadwalByPoli($poliId)
    {
        // Ambil semua dokter berdasarkan poliId
        $dokter = Dokter::where('poli_id', $poliId)->get();

        // Ambil jadwal dengan status ACTIVE berdasarkan doctor_id yang sudah ditemukan
        $jadwal_periksa = JadwalPeriksa::whereIn('dokter_id', $dokter->pluck('id'))
            ->where('status', 'Aktif')
            ->get();

        // Format data untuk ditampilkan di frontend
        $dataJadwal = $jadwal_periksa->map(function ($jadwal) {
            $dokter_jadwal = $jadwal->jadwal_dokter;  // Ambil relasi dokter
            return [
                'id' => $jadwal->id,
                'dokter' => $dokter_jadwal ? $dokter_jadwal->namaDokter : 'Unknown Doctor',
                'hari' => $jadwal->hari,
                'jamMulai' => $jadwal->jamMulai,
                'jamSelesai' => $jadwal->jamSelesai,
            ];
        });

        return response()->json($dataJadwal);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Set timezone ke Jakarta
        $timezone = 'Asia/Jakarta';
        $now = Carbon::now($timezone);  // Mendapatkan waktu sekarang di Jakarta

        // Validasi input
        $request->validate([
            'jadwal_periksa_id' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:255',
        ]);

        // Ambil jadwal berdasarkan ID
        $jadwalPeriksa = JadwalPeriksa::findOrFail($request->jadwal_periksa_id);

        // Daftar konversi hari Indonesia ke Inggris
        $daysInEnglish = [
            'Senin' => 'Monday',
            'Selasa' => 'Tuesday',
            'Rabu' => 'Wednesday',
            'Kamis' => 'Thursday',
            'Jumat' => 'Friday',
            'Sabtu' => 'Saturday',
            'Minggu' => 'Sunday',
        ];

        // Pastikan booking hanya bisa dilakukan 1 hari sebelumnya
        $scheduleDayEnglish = $daysInEnglish[$jadwalPeriksa->hari] ?? null;
        if (!$scheduleDayEnglish) {
            return redirect()->back()->withErrors('Hari pada jadwal tidak valid.');
        }

        // Gunakan Carbon untuk menggabungkan hari dan waktu jadwal
        $scheduleDay = Carbon::parse($scheduleDayEnglish)->setTimezone($timezone);  // Pastikan timezone disesuaikan
        $jadwalMulai = $scheduleDay->copy()->setTimeFromTimeString($jadwalPeriksa->jamMulai);

        // Waktu maksimal booking (1 hari sebelumnya)
        $bookingDeadline = $jadwalMulai->subDay();

        // Validasi apakah sudah melewati batas booking
        if ($now->greaterThanOrEqualTo($bookingDeadline)) {
            return redirect()->back()->withErrors('Booking hanya dapat dilakukan maksimal 1 hari sebelum jadwal.');
        }

        // Menggunakan startOfDay dan endOfDay untuk membandingkan tanggal saja
        $startOfDay = $scheduleDay->startOfDay(); // Jam 00:00:00
        $endOfDay = $scheduleDay->endOfDay(); // Jam 23:59:59

        // Cek antrian terbesar berdasarkan appointment_schedule_id pada hari yang sama
        $latestQueue = DaftarPoli::where('jadwal_periksa_id', $jadwalPeriksa->id)
            ->orderBy('antrian', 'desc') // Urutkan berdasarkan antrian terbesar
            ->first();

        // Tentukan antrian
        if ($latestQueue) {
            // Mengecek jika sudah lebih dari 1 minggu dari entri terakhir, reset antrian ke 1
            $lastCreated = Carbon::parse($latestQueue->created_at)->setTimezone($timezone);

            // Jika sudah lebih dari 1 minggu, reset antrian
            if ($lastCreated->diffInWeeks($now) >= 1) {
                $antrian = 1; // Reset antrian
            } else {
                // Tambahkan antrian terakhir dengan 1
                $antrian = $latestQueue->antrian + 1;
            }
        } else {
            // Jika tidak ada data sebelumnya, mulai dengan antrian 1
            $antrian = 1;
        }

        // Simpan data ke DaftarPoli
        $daftarPoli = DaftarPoli::create([
            'keluhan' => $request->keluhan,
            'antrian' => $antrian,
            'pasien_id' => auth('pasien')->id(), // Ambil ID pasien yang login
            'jadwal_periksa_id' => $jadwalPeriksa->id,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pasien_periksa.index')->with('success', 'Booking berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil ID pasien yang sedang login
        $pasienId = auth('pasien')->id();

        // Ambil data DaftarPoli berdasarkan ID pasien yang sedang login
        $pasien_periksa = DaftarPoli::with([
            'jadwal_appointment',        
            'poli_periksa',        
            'poli_periksa.periksa_obat', 
        ])
            ->where('id', $id)
            ->where('pasien_id', $pasienId) // Pastikan hanya data milik pasien yang login
            ->firstOrFail();

        return view('pages.pasien.pasien_periksa.detail', compact('pasien_periksa',));
    }
}