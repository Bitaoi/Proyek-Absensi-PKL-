<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model ini.
     *
     * @var string
     */
    protected $table = 'activity_logs';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah kolom-kolom yang bisa Anda isi menggunakan metode `create()` atau `fill()`.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'model_type',
        'model_id',
        'old_data',
        'new_data',
        'ip_address',
        'user_agent',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     * Misalnya, kolom 'old_data' dan 'new_data' yang disimpan sebagai JSON.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'old_data' => 'array', // Mengubah string JSON menjadi array PHP
        'new_data' => 'array', // Mengubah string JSON menjadi array PHP
        'created_at' => 'datetime', // Mengubah ke objek Carbon
        'updated_at' => 'datetime', // Mengubah ke objek Carbon
    ];

    /**
     * Mendefinisikan relasi "belongs to" dengan model User.
     * Sebuah log aktivitas dimiliki oleh seorang pengguna.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Secara default akan mencari foreign key 'user_id' dan primary key 'id' di tabel 'users'
    }
}

