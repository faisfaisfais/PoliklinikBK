<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Gunakan Authenticatable
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'pasien';

    protected $fillable = [
        'nik', 'namaPasien', 'alamat',
        'noHP', 'nomorRM',
    ];

    protected $hidden = [

    ];

    public function pasien_periksa()
    {
        return $this->belongsToMany(Periksa::class, 'daftar_poli', 'pasien_id', 'periksa_id');
    }

    public function pasien_poli()
    {
        return $this->hasMany(DaftarPoli::class, 'pasien_id', 'id');
    }

    // use HasFactory;
}
