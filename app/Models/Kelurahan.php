<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan'; // ✅ Tambahkan ini untuk paksa ke nama tabel yang benar
    protected $primaryKey = 'kelurahan_id';
    public $timestamps = false;

    protected $fillable = ['kecamatan_id', 'nama_kelurahan'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
