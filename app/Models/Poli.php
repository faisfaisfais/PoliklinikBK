<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poli extends Model
{
    use SoftDeletes;

    protected $table = 'poli';

    protected $fillable = [
        'namaPoli', 'deskripsi',
    ];

    protected $hidden = [

    ];

    public function dokter_poli()
    {
        return $this->hasMany(Dokter::class, 'poli_id', 'id');
    }

    // use HasFactory;
}
