<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $primaryKey = 'kelurahan_id';
    public $timestamps = false;

    protected $fillable = ['kecamatan_id', 'kelurahan_name'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
