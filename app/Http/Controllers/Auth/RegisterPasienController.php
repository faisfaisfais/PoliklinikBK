<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterPasienController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/pasien'; // Sesuaikan rute setelah registrasi berhasil

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nik' => ['required', 'digits:16', 'unique:pasien,nik'], // NIK harus unik dan 16 digit
            'namaPasien' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'noHP' => ['required', 'string', 'max:15'],
        ]);
    }

    /**
     * Create a new pasien instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Pasien
     */
    protected function create(array $data)
    {
        // Ambil tahun dan bulan saat ini
        $yearMonth = Carbon::now()->format('Ym'); // format: 202411

        // Ambil jumlah pasien yang terdaftar untuk bulan tersebut
        $pasienCount = Pasien::where('nomorRM', 'like', $yearMonth . '%')->count();

        // Generate No RM dengan format tahun-bulan-urutan
        $nomorRMBaru = $yearMonth . '-' . str_pad($pasienCount + 1, 3, '0', STR_PAD_LEFT);

        return Pasien::create([
            'nik' => $data['nik'],
            'namaPasien' => $data['namaPasien'],
            'alamat' => $data['alamat'],
            'noHP' => $data['noHP'],
            'nomorRM' => $nomorRMBaru,
        ]);
    }

    /**
     * Show the registration form for patients.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.pasien-register');
    }
}