<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\ActivityLog;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Auth; // <-- Tambahkan ini
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GuestsExport;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // ... (fungsi index, laporanMingguan, laporanBulanan tetap sama) ...
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
    public function laporanMingguan(Request $request)
    {
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = new DateTime($request->start_date);
            $endDate = new DateTime($request->end_date);
        } else {
            $startDate = new DateTime('monday this week');
            $endDate = new DateTime('sunday this week');
        }
        $prevWeekStartDate = (clone $startDate)->sub(new DateInterval('P1W'))->format('Y-m-d');
        $prevWeekEndDate = (clone $endDate)->sub(new DateInterval('P1W'))->format('Y-m-d');
        $nextWeekStartDate = (clone $startDate)->add(new DateInterval('P1W'))->format('Y-m-d');
        $nextWeekEndDate = (clone $endDate)->add(new DateInterval('P1W'))->format('Y-m-d');
        $guestsMingguan = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                ->whereBetween('timestamp', [$startDate->format('Y-m-d').' 00:00:00', $endDate->format('Y-m-d').' 23:59:59'])
                                ->latest('timestamp')
                                ->paginate(15)
                                ->appends($request->query());
        return view('admin.laporan_mingguan', compact(
            'guestsMingguan', 
            'startDate', 
            'endDate',
            'prevWeekStartDate',
            'prevWeekEndDate',
            'nextWeekStartDate',
            'nextWeekEndDate'
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

            // **LOGIKA PENCATATAN AKTIVITAS**
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Export Laporan Bulanan',
                'description' => 'Eskpor Laporan Bulanan (' . $month . '-' . $year . ') ke format ' . strtoupper($type),
                'ip_address' => $request->ip()
            ]);

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

    public function exportMingguan(Request $request, $type)
    {
        try {
            if ($request->has('start_date') && $request->has('end_date')) {
                $startDate = new DateTime($request->start_date);
                $endDate = new DateTime($request->end_date);
            } else {
                $startDate = new DateTime('monday this week');
                $endDate = new DateTime('sunday this week');
            }
            $guestsToExport = Guest::with(['purpose', 'kecamatan', 'kelurahan'])
                                    ->whereBetween('timestamp', [$startDate->format('Y-m-d').' 00:00:00', $endDate->format('Y-m-d').' 23:59:59'])
                                    ->latest('timestamp')
                                    ->get();
                                    
            $fileName = 'laporan_absensi_' . $startDate->format('Y-m-d') . '_-_' . $endDate->format('Y-m-d');

            // **LOGIKA PENCATATAN AKTIVITAS**
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => 'Export Laporan Mingguan',
                'description' => 'Ekspor Laporan periode (' . $startDate->format('Y-m-d') . ' sampai ' . $endDate->format('Y-m-d') . ') ke format ' . strtoupper($type),
                'ip_address' => $request->ip()
            ]);

            if ($type === 'excel') {
                return Excel::download(new GuestsExport($guestsToExport), $fileName . '.xlsx');
            } 
            
            if ($type === 'pdf') {
                $data = [
                    'title' => 'Laporan Absensi Periode Tertentu',
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
