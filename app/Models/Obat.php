<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obat extends Model
{
    use SoftDeletes;

    protected $table = 'obat';

    protected $fillable = [
        'namaObat',
        'kemasan',
        'harga',
    ];

    protected $hidden = [];

    public function obat_periksa()
    {
        return $this->belongsToMany(Periksa::class, 'detail_periksa', 'obat_id', 'periksa_id')->withTimestamps();
    }

    // use HasFactory;
}
