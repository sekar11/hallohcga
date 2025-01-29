<?php

namespace App\Http\Controllers;

use App\Http\Repository\ComplainRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $complainRepository;

    /**
     * Constructor untuk inject repository
     */
    public function __construct(ComplainRepository $complainRepository)
    {
        $this->complainRepository = $complainRepository;
    }

    public function index(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $complainData = $this->complainRepository->getAllWithUsernameDate();

        if ($startDate && $endDate) {
            $complainData = $complainData->whereBetween('tanggal', [$startDate, $endDate]);
        }

        return view('/report/report_complain', compact('complainData'));
    }

    public function exportExcel(Request $request)
    {

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $complainData = $this->complainRepository->getAllWithUsernameDate($startDate, $endDate);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['NO', 'NRP', 'NAMA', 'DEPARTEMEN', 'TANGGAL COMPLAIN', 'AREA', 'GEDUNG',
        'LOKASI', 'PERMASALAHAN', 'FOTO DEVIASI', 'KATEGORI', 'SKALA', 'TEKNISI/CREW PIC',
        'DUE DATE',
        'TANGGAL PENYELESAIAN', 'LAMA PENYELESAIAN', 'IDENTIFIKASI', 'TINDAKAN PERBAIKAN', 'FOTO PERBAIKAN OLEH CREW','KETERANGAN PERSETUJUAN GA/GL',
        'FOTO HASIL PENGECEKAN OLEH GA/GL'];
        $sheet->fromArray($headers, NULL, 'A1');

        $headerStyle = [
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'D3D3D3'],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('A1:U1')->applyFromArray($headerStyle);

        foreach ($headers as $col => $header) {
            $column = chr(65 + $col);
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $rowNumber = 2;
        foreach ($complainData as $index => $complain) {
            // Menambahkan data text ke Excel
            $sheet->setCellValue('A' . $rowNumber, $index + 1);
            $sheet->setCellValue('B' . $rowNumber, $complain->nrp);
            $sheet->setCellValue('C' . $rowNumber, $complain->nama);
            $sheet->setCellValue('D' . $rowNumber, $complain->departemen);
            $sheet->setCellValue('E' . $rowNumber, $complain->tanggal);
            $sheet->setCellValue('F' . $rowNumber, $complain->area);
            $sheet->setCellValue('G' . $rowNumber, $complain->gedung);
            $sheet->setCellValue('H' . $rowNumber, $complain->lokasi);
            $sheet->setCellValue('I' . $rowNumber, $complain->permasalahan);

            // Menambahkan gambar deviasi jika ada
            if (!empty($complain->foto_deviasi)) {
                $imagePath = storage_path('app/public/' . $complain->foto_deviasi);
                if (file_exists($imagePath)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('J' . $rowNumber);
                    $drawing->setHeight(50);
                    $drawing->setWidth(50);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($sheet);
                }
            }

            $sheet->getColumnDimension('J')->setWidth(15);

            $sheet->setCellValue('K' . $rowNumber, $complain->kategori);
            $sheet->setCellValue('L' . $rowNumber, $complain->skala);
            $sheet->setCellValue('M' . $rowNumber, ucwords(strtolower($complain->crew_pic)));
            $sheet->setCellValue('N' . $rowNumber, $complain->due_date);

            $sheet->setCellValue('O' . $rowNumber, $complain->validasi_crew_on);

            if (!empty($complain->due_date) && !empty($complain->validasi_crew_on)) {
            $dueDate = Carbon::parse($complain->due_date);
            $validasiCrewOn = Carbon::parse($complain->validasi_crew_on);

            $daysDifference = $validasiCrewOn->diffInDays($dueDate);

            if ($daysDifference === 0) {
                $daysDifference = 1;
            }

            $sheet->setCellValue('P' . $rowNumber, $daysDifference . ' hari');
        } else {
            $sheet->setCellValue('P' . $rowNumber, '-');
        }
            $sheet->setCellValue('Q' . $rowNumber, $complain->identification);
            $sheet->setCellValue('R' . $rowNumber, $complain->corrective_action);

            if (!empty($complain->foto_perbaikan)) {
                $imagePath = storage_path('app/public/' . $complain->foto_perbaikan);
                if (file_exists($imagePath)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('S' . $rowNumber);
                    $drawing->setHeight(50);
                    $drawing->setWidth(50);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($sheet);
                }
            }

            $sheet->getColumnDimension('S')->setWidth(15);
            $sheet->setCellValue('T' . $rowNumber, $complain->approval_desc);

            if (!empty($complain->foto_hasil_perbaikan)) {
                $imagePath = storage_path('app/public/' . $complain->foto_hasil_perbaikan);
                if (file_exists($imagePath)) {
                    $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                    $drawing->setPath($imagePath);
                    $drawing->setCoordinates('U' . $rowNumber);
                    $drawing->setHeight(50);
                    $drawing->setWidth(50);
                    $drawing->setOffsetX(10);
                    $drawing->setOffsetY(10);
                    $drawing->setWorksheet($sheet);
                }
            }

            $sheet->getColumnDimension('U')->setWidth(15);

            $sheet->getRowDimension($rowNumber)->setRowHeight(60);

            $rowNumber++;
        }

        $fileName = 'Laporan_Complain.xlsx';
        $filePath = 'exports/' . $fileName;
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/public/' . $filePath));

        return response()->download(storage_path('app/public/' . $filePath))->deleteFileAfterSend();
    }

}
