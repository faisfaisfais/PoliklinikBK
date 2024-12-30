<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalPeriksa extends Model
{
    use SoftDeletes;

    protected $table = 'jadwal_periksa';

    protected $fillable = [
        'hari',
        'jamMulai',
        'jamSelesai',
        'status',
        'dokter_id',
    ];

    protected $hidden = [];

    public function jadwal_dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }

    public function jadwal()
    {
        return $this->hasMany(DaftarPoli::class, 'jadwal_periksa_id', 'id');
    }

    // use HasFactory;
}
