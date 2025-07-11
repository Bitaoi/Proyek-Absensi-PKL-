<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Purpose;

class GuestController extends Controller
{
    public function create()
    {
        $kecamatan = Kecamatan::all();
        $purposes = Purpose::all();
        return view('guest.form', compact('kecamatan', 'purposes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'purpose_id' => 'required|exists:purposes,purpose_id',
            'kecamatan_id' => 'nullable|exists:kecamatan,kecamatan_id',
            'kelurahan_id' => 'nullable|exists:kelurahan,kelurahan_id',
            'other_purpose_description' => 'nullable|string',
        ]);

        Guest::create($request->all());

        return redirect()->route('guest.form')->with('success', 'Data berhasil disimpan!');
    }


    public function getKelurahan($kecamatan_id)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatan_id)
            ->select('kelurahan_id', 'kelurahan_name') // ✅ nama kolom sesuai database
            ->get();

        return response()->json($kelurahan);
    }


}
