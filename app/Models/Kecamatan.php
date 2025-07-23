<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $primaryKey = 'kecamatan_id';
    public $timestamps = false;

    protected $fillable = ['kecamatan_name'];
}
