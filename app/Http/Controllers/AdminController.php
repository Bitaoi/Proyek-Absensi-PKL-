<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\ActivityLog;
use DateTime;
use DateInterval;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ... (fungsi index dan laporanBulanan tetap sama) ...
    public function index(Request $request)
    {
        $today = new DateTime();
        $absensiToday = Guest::whereDate('timestamp', $today->format('Y-m-d'))->count();

        $guestsQuery = Guest::with('purpose');
        $guestsQuery->whereDate('timestamp', $today->format('Y-m-d'));

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $guestsQuery->where(function($query) use ($searchTerm) {
                $query->where('name', 'like', '%' . $searchTerm . '%')
                      ->orWhereDate('timestamp', $searchTerm);
            });
        }

        $guests = $guestsQuery->latest('timestamp')->paginate(10);
        return view('admin.dashboard', compact('absensiToday', 'guests'));
    }

    /**
     * PERUBAHAN UTAMA DI SINI
     * Menampilkan laporan absensi mingguan berdasarkan tanggal yang dipilih.
     */
    public function laporanMingguan(Request $request)
    {
        // 1. Tentukan tanggal acuan. Ambil dari URL, jika tidak ada, gunakan tanggal hari ini.
        $referenceDate = new DateTime($request->input('date', 'now'));

        // 2. Hitung tanggal awal (Senin) dan akhir (Minggu) dari minggu acuan.
        $startDate = (clone $referenceDate)->modify('monday this week');
        $endDate = (clone $referenceDate)->modify('sunday this week');

        // 3. Hitung tanggal untuk tombol navigasi "Minggu Sebelumnya" dan "Minggu Berikutnya".
        $previousWeekDate = (clone $referenceDate)->sub(new DateInterval('P1W'))->format('Y-m-d');
        $nextWeekDate = (clone $referenceDate)->add(new DateInterval('P1W'))->format('Y-m-d');

        // 4. Ambil data dari database sesuai rentang tanggal yang sudah dihitung.
        $guestsMingguan = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                ->whereBetween('timestamp', [$startDate->format('Y-m-d').' 00:00:00', $endDate->format('Y-m-d').' 23:59:59'])
                                ->latest('timestamp')
                                ->paginate(15)
                                ->appends($request->query()); // Penting agar filter tanggal tetap ada saat pindah halaman.

        // 5. Kirim semua data yang dibutuhkan ke view.
        return view('admin.laporan_mingguan', compact(
            'guestsMingguan', 
            'startDate', 
            'endDate',
            'previousWeekDate',
            'nextWeekDate'
        ));
    }

    public function laporanBulanan(Request $request)
    {
        $now = new DateTime();
        $month = $request->input('month', $now->format('m'));
        $year = $request->input('year', $now->format('Y'));

        $guestsBulanan = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                ->whereMonth('timestamp', $month)
                                ->whereYear('timestamp', $year)
                                ->latest('timestamp')
                                ->paginate(20);

        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = DateTime::createFromFormat('!m', $i)->format('F');
        }
        
        $currentYear = (int)$now->format('Y');
        $years = range($currentYear - 5, $currentYear + 1);

        return view('admin.laporan_bulanan', compact('guestsBulanan', 'month', 'year', 'months', 'years'));
    }

    public function export(Request $request, $type)
    {
        try {
            $now = new DateTime();
            $month = $request->input('month', $now->format('m'));
            $year = $request->input('year', $now->format('Y'));

            $guestsToExport = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                   ->whereMonth('timestamp', $month)
                                   ->whereYear('timestamp', $year)
                                   ->latest('timestamp')
                                   ->get();

            $fileName = 'laporan_absensi_bulanan_' . $month . '_' . $year;

            if ($type === 'excel') {
                return Excel::download(new GuestsExport($guestsToExport), $fileName . '.xlsx');
            } 
            
            if ($type === 'pdf') {
                $monthName = DateTime::createFromFormat('!m', $month)->format('F');
                $data = [
                    'title' => 'Laporan Absensi Bulanan',
                    'date' => $now->format('d/m/Y'),
                    'monthName' => $monthName,
                    'year' => $year,
                    'guests' => $guestsToExport
                ];
                
                $pdf = Pdf::loadView('admin.laporan.laporanbulanan', $data);
                return $pdf->download($fileName . '.pdf');
            }
        } catch (\Exception $e) {
            return "Gagal membuat file. Error: " . $e->getMessage();
        }

        return redirect()->back()->with('error', 'Format export tidak valid.');
    }

    /**
     * PERUBAHAN UTAMA DI SINI
     * Mengekspor data laporan mingguan berdasarkan tanggal yang dipilih.
     */
    public function exportMingguan(Request $request, $type)
    {
        try {
            // Logika penentuan tanggal disamakan dengan fungsi laporanMingguan()
            $referenceDate = new DateTime($request->input('date', 'now'));
            $startDate = (clone $referenceDate)->modify('monday this week');
            $endDate = (clone $referenceDate)->modify('sunday this week');

            $guestsToExport = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                    ->whereBetween('timestamp', [$startDate->format('Y-m-d').' 00:00:00', $endDate->format('Y-m-d').' 23:59:59'])
                                    ->latest('timestamp')
                                    ->get();
                                    
            $fileName = 'laporan_absensi_mingguan_' . $startDate->format('Y-m-d') . '_-_' . $endDate->format('Y-m-d');

            if ($type === 'excel') {
                return Excel::download(new GuestsExport($guestsToExport), $fileName . '.xlsx');
            } 
            
            if ($type === 'pdf') {
                $data = [
                    'title' => 'Laporan Absensi Mingguan',
                    'date' => (new DateTime())->format('d F Y'),
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'guests' => $guestsToExport
                ];
                $pdf = Pdf::loadView('admin.laporan.laporanmingg', $data); 
                return $pdf->download($fileName . '.pdf');
            }
        } catch (\Exception $e) {
            return "Gagal membuat file. Error: " . $e->getMessage();
        }

        return redirect()->back()->with('error', 'Format export tidak valid.');
    }

    public function aktivitas(Request $request)
    {
        $aktivitasQuery = ActivityLog::with('user')->latest('created_at');

        if ($request->has('search_log')) {
            $searchTerm = $request->input('search_log');
            $aktivitasQuery->where(function($query) use ($searchTerm) {
                $query->where('action', 'like', '%' . $searchTerm . '%')
                      ->orWhere('description', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('user', function ($q) use ($searchTerm) {
                          $q->where('name', 'like', '%' . $searchTerm . '%');
                      });
            });
        }

        $aktivitasLogs = $aktivitasQuery->paginate(15);
        return view('admin.aktivitas', compact('aktivitasLogs'));
    }
}
