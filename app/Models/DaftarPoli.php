<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarPoli extends Model
{
    use SoftDeletes;

    protected $table = 'daftar_poli';

    protected $fillable = [
        'keluhan',
        'antrian',
        'pasien_id',
        'jadwal_periksa_id',
    ];

    protected $hidden = [];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'id');
    }

    public function jadwal_appointment()
    {
        return $this->belongsTo(JadwalPeriksa::class, 'jadwal_periksa_id', 'id');
    }

    public function poli_periksa()
    {
        return $this->hasMany(Periksa::class, 'daftar_poli_id', 'id');
    }

    public function sudahPeriksa()
    {
        // Periksa apakah ada pemeriksaan terkait dengan list_clinics_id ini
        return $this->poli_periksa()->exists(); // Menggunakan exists() untuk cek ada data atau tidak
    }

    // use HasFactory;
}
