<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dokter\JadwalRequest;
use App\Models\Dokter;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil ID dokter yang sedang login
        $dokterId = auth()->user()->dokter->id; // Asumsi: 'dokter' adalah relasi pada model 'User' yang mengarah ke model 'dokter'

        // Ambil jadwal dokter yang sedang login
        $listJadwal = JadwalPeriksa::with(['jadwal_dokter'])  // Menggunakan relasi 'dokter_appointment' jika ada
        ->where('dokter_id', $dokterId)  // Filter berdasarkan ID dokter yang sedang login
            ->get();

        return view('pages.dokter.jadwal.index', [
            'listJadwal' => $listJadwal,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listDokter = Dokter::all();
        return view('pages.dokter.jadwal.create', [
            'listDokter' => $listDokter
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JadwalRequest $request)
    {
        // Ambil data dokter yang sedang login
        $dokter = auth()->user()->dokter;

        // Ambil hari ini dalam bahasa Inggris
        $today = Carbon::now()->locale('en')->format('l'); // Format: Monday, Tuesday, Wednesday, dll.

        // Konversi hari perangkat (dalam bahasa Inggris) menjadi bahasa Indonesia
        $daysInIndonesian = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $todayInIndonesian = $daysInIndonesian[$today];

        // Tentukan hari yang digunakan di form (hari dalam format bahasa Indonesia atau bahasa Inggris)
        $hari = $request->hari;

        // Cek apakah hari yang dipilih sama dengan hari ini dalam bahasa Indonesia atau bahasa Inggris
        if (strtolower($hari) == strtolower($todayInIndonesian) || strtolower($hari) == strtolower($today)) {
            // Jika ada jadwal aktif pada hari yang sama, maka tidak bisa menambahkan jadwal baru
            $overlap = JadwalPeriksa::where('dokter_id', $dokter->id)
                ->where('hari', $hari) // Menggunakan hari yang berupa string
                ->where('status', 'Aktif') // Hanya jadwal aktif
                ->exists();

            // Jika ada jadwal aktif pada hari yang sama, kirim pesan error
            if ($overlap) {
                return back()->withErrors(['hari' => 'Anda tidak bisa menambahkan jadwal pada hari H yang sudah ada jadwal aktif.']);
            }
        }

        // Cek apakah ada jadwal aktif yang bentrok dengan jadwal yang baru **hanya pada hari yang sama**
        $overlap = JadwalPeriksa::where('dokter_id', $dokter->id)
            ->where('hari', $hari) // Menggunakan hari yang berupa string
            ->where('status', 'Aktif') // Hanya jadwal aktif
            ->where(function ($query) use ($request) {
                // Mengecek waktu tumpang tindih
                $query->whereBetween('jamMulai', [$request->jamMulai, $request->jamSelesai])
                    ->orWhereBetween('jamSelesai', [$request->jamMulai, $request->jamSelesai])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('jamMulai', '<=', $request->jamMulai)
                            ->where('jamSelesai', '>=', $request->jamSelesai);
                    });
            })
            ->exists();

        // Jika ada bentrok jadwal pada hari yang sama
        if ($overlap) {
            return back()->withErrors(['jamMulai' => 'Jadwal ini bentrok dengan jadwal lain yang aktif pada hari yang sama.']);
        }

        // Cek jadwal aktif sebelumnya dan nonaktifkan jika ada
        $jadwalAktif = JadwalPeriksa::where('dokter_id', $dokter->id)
        ->where('status', 'Aktif')
            ->first(); // Ambil jadwal aktif pertama

        if ($jadwalAktif) {
            // dd($jadwalAktif); // Debug data jadwal aktif sebelum diubah
            $jadwalAktif->status = 'Tidak Aktif';
            $jadwalAktif->save();
        } else {
            // dd('No active schedule found'); // Debug jika tidak ada jadwal aktif
        }

        // Ambil data dari request dan tambahkan listDokter_id serta set status ACTIVE
        $data = $request->all();
        $data['dokter_id'] = $dokter->id;
        $data['status'] = 'Aktif';

        // Simpan ke database
        JadwalPeriksa::create($data);

        return redirect()->route('jadwal.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $listJadwal = JadwalPeriksa::findOrFail($id);

        return view('pages.dokter.jadwal.edit', [
            'listJadwal' => $listJadwal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JadwalRequest $request, $id)
    {
        $data = $request->all();

        // Temukan jadwal yang sedang diupdate
        $item = JadwalPeriksa::findOrFail($id);

        // Ambil hari ini (hari H) menggunakan Carbon dalam bahasa Inggris
        $today = Carbon::now()->locale('en')->format('l'); // Format: Monday, Tuesday, Wednesday, dll.

        // Konversi hari perangkat (dalam bahasa Inggris) menjadi bahasa Indonesia
        $daysInIndonesian = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $todayInIndonesian = $daysInIndonesian[$today];

        // Logika untuk memeriksa jika hari ini adalah hari yang sama dengan yang ingin diubah
        if (strtolower($data['hari']) == strtolower($todayInIndonesian)) {
            // Jika statusnya adalah Aktif dan diubah di hari yang sama, maka tidak bisa diubah
            if ($data['status'] == 'Aktif' && $item->status != 'Aktif') {
                return back()->withErrors(['status' => 'Jadwal di hari yang sama tidak dapat diubah menjadi aktif.']);
            }
        }

   
        // Jika hari berubah (hari baru), pastikan tidak ada jadwal aktif yang bentrok di hari tersebut
        if ($data['hari'] != $item->hari) {
            // Cek jika ada jadwal aktif di hari baru yang bentrok dengan waktu yang baru
            $jadwalAktif = JadwalPeriksa::where('dokter_id', $item->dokter_id)
                ->where('status', 'Aktif')
                ->where('hari', $data['hari'])  // Hari baru yang dipilih
                ->where(function ($query) use ($data) {
                    // Mengecek apakah jadwal baru tumpang tindih dengan jadwal yang ada
                    $query->whereBetween('jamMulai', [$data['jamMulai'], $data['jamSelesai']])
                    ->orWhereBetween('jamSelesai', [$data['jamMulai'], $data['jamSelesai']])
                    ->orWhere(function ($query) use ($data) {
                        $query->where('jamMulai', '<=', $data['jamMulai'])
                        ->where('jamSelesai', '>=', $data['jamSelesai']);
                    });
                })
                ->exists();

            // Jika ada jadwal aktif yang bentrok, kirim pesan error
            if ($jadwalAktif) {
                return back()->withErrors(['jamMulai' => 'Jadwal ini bentrok dengan jadwal lain pada hari yang sama.']);
            }
        }

        // Jika statusnya ingin diubah menjadi Aktif pada hari yang sama
        if ($data['status'] == 'Aktif' && $data['hari'] == $item->hari) {
            // Cek jadwal aktif lain yang ada di hari yang sama dan waktu yang bentrok
            $jadwalAktif = JadwalPeriksa::where('dokter_id', $item->dokter_id)
                ->where('status', 'Aktif')
                ->where('hari', $data['hari'])  // Pastikan hanya di hari yang sama
                ->where('id', '!=', $item->id)  // Pastikan tidak memeriksa jadwal yang sedang diupdate
                ->where(function ($query) use ($data) {
                    // Mengecek apakah jadwal baru tumpang tindih dengan jadwal yang ada
                    $query->whereBetween('jamMulai', [$data['jamMulai'], $data['jamSelesai']])
                    ->orWhereBetween('jamSelesai', [$data['jamMulai'], $data['jamSelesai']])
                    ->orWhere(function ($query) use ($data) {
                        $query->where('jamMulai', '<=', $data['jamMulai'])
                        ->where('jamSelesai', '>=', $data['jamSelesai']);
                    });
                })
                ->exists();

            // Jika ada jadwal aktif yang bentrok, kirim pesan error
            if ($jadwalAktif) {
                return back()->withErrors(['jamMulai' => 'Jadwal ini bentrok dengan jadwal lain pada hari yang sama.']);
            }

            // Nonaktifkan jadwal aktif lainnya jika ada dan hanya jika hari yang sama
            $jadwalAktifSebelumnya = JadwalPeriksa::where('dokter_id', $item->dokter_id)
                ->where('status', 'Aktif')
                // ->where('hari', $data['hari'])
                ->where('id', '!=', $item->id)  // Pastikan tidak memeriksa jadwal yang sedang diupdate
                ->first();
            if ($jadwalAktifSebelumnya) {
                $jadwalAktifSebelumnya->update(['status' => 'Tidak Aktif']);
            }
        }

        // Update jadwal yang sedang diupdate
        $item->update($data);

        return redirect()->route('jadwal.index');
    }

    /**
     * Remove the specified resource from storage.
     */
}
