<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest; // Asumsi Anda membuat model Guest
use Carbon\Carbon; // Untuk manipulasi tanggal

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Logika untuk tvRingkasanAbsensi
        $absensiToday = Guest::whereDate('timestamp', Carbon::today())->count();
        $absensiWeek = Guest::whereBetween('timestamp', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $absensiMonth = Guest::whereMonth('timestamp', Carbon::now()->month)->count();

        // Logika untuk rvDaftarAbsensi dan etSearch
        $guestsQuery = Guest::with('purpose'); // Eager load relasi purpose

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $guestsQuery->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhereDate('timestamp', $searchTerm); // Contoh sederhana, perlu validasi input tanggal
        }

        $guests = $guestsQuery->latest('timestamp')->paginate(10); // Ambil 10 data terbaru per halaman

        return view('admin.dashboard', compact('absensiToday', 'absensiWeek', 'absensiMonth', 'guests'));
    }

    // Metode untuk laporan mingguan
    public function laporanMingguan()
    {
        // Logika untuk mengambil dan menampilkan laporan mingguan
        return view('admin.laporan_mingguan');
    }

    // Metode untuk laporan bulanan
    public function laporanBulanan()
    {
        // Logika untuk mengambil dan menampilkan laporan bulanan
        return view('admin.laporan_bulanan');
    }

    // Metode untuk export data
    public function export()
    {
        // Logika untuk mengekspor data ke Excel/PDF
        // Anda mungkin perlu library seperti Maatwebsite/Laravel-Excel
        // Contoh: return Excel::download(new GuestsExport, 'guests.xlsx');
    }

    // Metode untuk melihat aktivitas admin (opsional)
    public function aktivitas()
    {
        // Logika untuk menampilkan log aktivitas admin
        return view('admin.aktivitas');
    }
}