<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periksa extends Model
{
    use SoftDeletes;

    protected $table = 'periksa';

    protected $fillable = [
        'tanggalPeriksa', 'catatan', 'harga',
        'daftar_poli_id',
    ];

    protected $hidden = [

    ];

    public function daftar_poli()
    {
        return $this->belongsTo(DaftarPoli::class, 'daftar_poli_id', 'id');
    }

    public function poli_pasien()
    {
        return $this->belongsToMany(Pasien::class, 'daftar_poli', 'periksa_id', 'pasien_id');
    }

    public function periksa_obat()
    {
        return $this->belongsToMany(Obat::class, 'detail_periksa', 'periksa_id', 'obat_id')->withTimestamps();
    }

    public function periksa_dokter()
    {
        return $this->hasOneThrough(
            Dokter::class,               // Model target akhir
            JadwalPeriksa::class,  // Model perantara
            'id',                        // Foreign key di AppointmentSchedule
            'id',                        // Foreign key di Doctor
            'daftar_poli_id',           // Foreign key di Examination
            'dokter_id'                 // Foreign key di AppointmentSchedule
        );
    }

    // use HasFactory;
}
