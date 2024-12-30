<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokter extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 'dokter';

    protected $fillable = [
        'namaDokter', 'alamat',
        'noHP', 'poli_id',
        'users_id'
    ];

    protected $hidden = [];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id', 'id');
    }

    public function appointment()
    {
        return $this->hasMany(JadwalPeriksa::class, 'dokter_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
