<?php

namespace App\Exports;

use App\Models\Guest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GuestsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $guests;

    public function __construct($guests)
    {
        $this->guests = $guests;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->guests;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Lengkap',
            'Nomor Telepon',
            'Alamat',
            'Kecamatan',
            'Kelurahan',
            'Tujuan Kunjungan',
            'Deskripsi Tujuan Lain',
            'Waktu Absen',
        ];
    }

    /**
     * @param mixed $guest
     * @return array
     */
    public function map($guest): array
    {
        return [
            $guest->guest_id,
            $guest->name,
            $guest->phone_number,
            $guest->address,
            $guest->kecamatan->kecamatan_name ?? '-', // Pastikan relasi kecamatan ada
            $guest->kelurahan->kelurahan_name ?? '-', // Pastikan relasi kelurahan ada
            $guest->purpose->purpose_name ?? $guest->other_purpose_description, // Gunakan tujuan atau deskripsi lain
            $guest->other_purpose_description,
            $guest->timestamp,
        ];
    }
}