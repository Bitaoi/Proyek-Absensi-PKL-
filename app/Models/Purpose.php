<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    protected $primaryKey = 'purpose_id';
    public $timestamps = false;

    protected $fillable = ['purpose_name'];
}
