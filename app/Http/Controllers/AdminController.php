<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Purpose;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\ActivityLog; // Tambahkan ini: Import model ActivityLog
use App\Models\User; // Tambahkan ini: Import model User jika Anda ingin menampilkan nama pengguna
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    /**
     * Menampilkan dashboard admin dengan rekap absensi hari ini dan fungsi pencarian.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Logika untuk ringkasan absensi hari ini (jika ingin ditampilkan)
        $absensiToday = Guest::whereDate('timestamp', Carbon::today())->count();

        // Logika untuk daftar absensi hari ini dan fungsi pencarian
        $guestsQuery = Guest::with('purpose'); // Eager load relasi purpose

        // Filter absensi hanya untuk hari ini secara default
        $guestsQuery->whereDate('timestamp', Carbon::today());

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $guestsQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhereDate('timestamp', $searchTerm); // Pencarian berdasarkan nama atau tanggal
            });
        }

        $guests = $guestsQuery->latest('timestamp')->paginate(10); // Ambil 10 data terbaru per halaman

        // Mengirimkan variabel yang dibutuhkan ke view dashboard
        return view('admin.dashboard', compact('absensiToday', 'guests'));
    }

    /**
     * Menampilkan laporan absensi mingguan.
     * Anda perlu mengimplementasikan logika pengambilan data mingguan di sini.
     *
     * @return \Illuminate\View\View
     */
    public function laporanMingguan()
    {
        // Contoh:
        // $guestsMingguan = Guest::whereBetween('timestamp', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        return view('admin.laporan_mingguan'); // Pastikan Anda memiliki view ini
    }

    /**
     * Menampilkan laporan absensi bulanan dengan filter bulan dan tahun.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function laporanBulanan(Request $request)
    {
        // Mendapatkan bulan dan tahun dari request, default bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Mengambil data absensi untuk bulan dan tahun tertentu
        $guestsBulanan = Guest::with(['purpose', 'kecamatan', 'kelurahan']) // Eager load relasi
                              ->whereMonth('timestamp', $month)
                              ->whereYear('timestamp', $year)
                              ->latest('timestamp')
                              ->paginate(20); // Paginasi untuk laporan

        // Mendapatkan daftar bulan dan tahun untuk filter di view
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->translatedFormat('F'); // Nama bulan
        }
        $years = range(Carbon::now()->year - 5, Carbon::now()->year + 1); // Contoh: 5 tahun ke belakang, 1 tahun ke depan

        // Mengirimkan variabel yang dibutuhkan ke view laporan_bulanan
        return view('admin.laporan_bulanan', compact('guestsBulanan', 'month', 'year', 'months', 'years'));
    }

    /**
     * Mengunduh data rekap absensi dalam format Excel atau PDF.
     *
     * @param Request $request
     * @param string $type Tipe export ('excel' atau 'pdf')
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\RedirectResponse
     */
    public function export(Request $request, $type)
    {
        // Mendapatkan bulan dan tahun dari request untuk filter data export
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        // Mengambil data absensi yang akan diexport
        $guestsToExport = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                               ->whereMonth('timestamp', $month)
                               ->whereYear('timestamp', $year)
                               ->latest('timestamp')
                               ->get(); // Gunakan get() karena tidak perlu paginasi untuk export

        // Logika export berdasarkan tipe
        if ($type === 'excel') {
            return Excel::download(new GuestsExport($guestsToExport), 'laporan_absensi_bulanan_' . $month . '_' . $year . '.xlsx');
        } elseif ($type === 'pdf') {
            $data = [
                'title' => 'Laporan Absensi Bulanan',
                'date' => Carbon::now()->format('d/m/Y'),
                'monthName' => Carbon::create()->month($month)->translatedFormat('F'),
                'year' => $year,
                'guests' => $guestsToExport
            ];
            $pdf = Pdf::loadView('admin.laporan_pdf', $data); // Pastikan Anda memiliki view ini
            return $pdf->download('laporan_absensi_bulanan_' . $month . '_' . $year . '.pdf');
        }

        // Redirect jika tipe export tidak valid
        return redirect()->back()->with('error', 'Format export tidak valid.');
    }

    /**
     * Metode untuk melihat aktivitas admin.
     * Mengambil log aktivitas dari database dan menampilkannya.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function aktivitas(Request $request) // Tambahkan parameter Request
    {
        // Logika untuk filter pencarian log (opsional)
        $aktivitasQuery = ActivityLog::with('user')->latest('created_at'); // Eager load relasi user, urutkan dari terbaru

        if ($request->has('search_log')) {
            $searchTerm = $request->input('search_log');
            $aktivitasQuery->where(function($query) use ($searchTerm) {
                $query->where('action', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function ($q) use ($searchTerm) { // Mencari di nama pengguna
                          $q->where('name', 'like', '%' . $searchTerm . '%');
                      });
            });
        }

        $aktivitasLogs = $aktivitasQuery->paginate(15); // Paginasi log aktivitas

        // Mengirimkan variabel yang dibutuhkan ke view aktivitas
        return view('admin.aktivitas', compact('aktivitasLogs'));
    }
}
