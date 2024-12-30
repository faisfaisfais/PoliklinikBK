<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPeriksa extends Model
{
    use SoftDeletes;

    protected $table = 'detail_periksa';

    protected $fillable = [
        'periksa_id', 'obat_id',
    ];

    protected $hidden = [

    ];

    public function detail_periksa()
    {
        return $this->hasMany(Periksa::class, 'periksa_id', 'id');
    }

    public function obat()
    {
        return $this->hasMany(Obat::class, 'obat_id', 'id');
    }

    // use HasFactory;
}
