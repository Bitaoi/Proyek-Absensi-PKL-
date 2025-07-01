<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    protected $table = 'guests'; // ✅ tambahkan ini
    protected $primaryKey = 'guest_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'phone_number',
        'address',
        'purpose_id',
        'other_purpose_description',
        'kecamatan_id',
        'kelurahan_id',
    ];

    // ✅ Relasi opsional
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class, 'purpose_id');
    }
}
