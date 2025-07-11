<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guest;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf; 

class LaporanController extends Controller
{
    public function exportMingguan(Request $request)
    {
        $type = $request->query('type');
        $startDate = Carbon::parse($request->query('start_date'));
        $endDate = Carbon::parse($request->query('end_date'));

        // Ambil data tamu berdasarkan rentang tanggal
        $guests = Guest::with('purpose') // Load relasi 'purpose' jika ada
                       ->whereBetween('timestamp', [$startDate->startOfDay(), $endDate->endOfDay()])
                       ->orderBy('timestamp', 'asc') // Urutkan berdasarkan waktu absen
                       ->get();

        // Judul laporan
        $title = 'Laporan Absensi Mingguan';

        // Data yang akan dilewatkan ke fungsi export
        $data = [
            'title' => $title,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'guests' => $guests,
        ];

        if ($type === 'excel') {
            return $this->exportExcel($data);
        } elseif ($type === 'pdf') {
            return $this->exportPdf($data);
        }

        return redirect()->back()->with('error', 'Tipe ekspor tidak valid.');
    }

    /**
     * Export data ke format Excel.
     * @param array $data Mengandung 'title', 'startDate', 'endDate', 'guests'
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportExcel(array $data)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Ambil data dari array $data
        $title = $data['title'];
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $guests = $data['guests'];

        // --- Header dan Info Laporan di Excel ---
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', $title);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->mergeCells('A2:D2');
        $sheet->setCellValue('A2', 'Periode: ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y'));
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A4', 'Tanggal Export: ' . Carbon::now()->format('d F Y'));
        $sheet->getStyle('A4')->getFont()->setSize(9);


        // --- Header Tabel Excel ---
        $headerRow = 6; // Mulai header tabel dari baris ke-6
        $sheet->setCellValue('A' . $headerRow, 'No.');
        $sheet->setCellValue('B' . $headerRow, 'Nama');
        $sheet->setCellValue('C' . $headerRow, 'Tujuan Kunjungan');
        $sheet->setCellValue('D' . $headerRow, 'Waktu Absen');

        // Styling Header Tabel
        $sheet->getStyle('A' . $headerRow . ':D' . $headerRow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $headerRow . ':D' . $headerRow)->getFill()
              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
              ->getStartColor()->setARGB('FFF2F2F2'); // Warna latar belakang abu-abu muda
        $sheet->getStyle('A' . $headerRow . ':D' . $headerRow)->getBorders()
              ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        // --- Data Tabel Excel ---
        $row = $headerRow + 1;
        if ($guests->isEmpty()) {
            $sheet->mergeCells('A' . $row . ':D' . $row);
            $sheet->setCellValue('A' . $row, 'Tidak ada data absensi untuk periode ini.');
            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $row . ':D' . $row)->getBorders()
                ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $row++;
        } else {
            foreach ($guests as $index => $guest) {
                $sheet->setCellValue('A' . $row, $index + 1);
                $sheet->setCellValue('B' . $row, $guest->name);
                // Pastikan 'purpose' ada sebelum mengakses 'purpose_name'
                $sheet->setCellValue('C' . $row, $guest->purpose->purpose_name ?? $guest->other_purpose_description ?? 'N/A');
                $sheet->setCellValue('D' . $row, Carbon::parse($guest->timestamp)->format('d/m/Y H:i'));

                // Border untuk setiap baris data
                $sheet->getStyle('A' . $row . ':D' . $row)->getBorders()
                    ->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                $row++;
            }
        }

        // Auto-size kolom agar sesuai dengan konten
        foreach (range('A', 'D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // --- Proses Download Excel ---
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan_Absensi_Mingguan_' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.xlsx';

        // Laravel's way to download file (recommended)
        $tempFile = tempnam(sys_get_temp_dir(), $fileName); // Buat file sementara
        $writer->save($tempFile); // Simpan ke file sementara

        return response()->download($tempFile, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true); // Hapus file sementara setelah dikirim
    }

    /**
     * Export data ke format PDF.
     * @param array $data Mengandung 'title', 'startDate', 'endDate', 'guests'
     * @return \Illuminate\Http\Response
     */
    private function exportPdf(array $data)
    {
        // Load view Blade untuk PDF dengan data yang disesuaikan
        // Pastikan path view ini sesuai dengan lokasi file Blade kamu
        $pdf = Pdf::loadView('admin.laporan.mingguan_pdf', $data);

        $fileName = 'Laporan_Absensi_Mingguan_' . $data['startDate']->format('Ymd') . '-' . $data['endDate']->format('Ymd') . '.pdf';

        // Mengunduh file PDF
        return $pdf->download($fileName);
    }
}