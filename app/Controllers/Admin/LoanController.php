<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;
use Dompdf\Options;

class LoanController extends BaseController
{
    protected $loanModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
    }

    public function exportExcel()
    {
        $loans = $this->loanModel->getLoanList();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laporan Peminjaman');

        // Header
        $sheet->fromArray([
            ['No', 'Nama Peminjam', 'Judul Buku', 'Jumlah', 'Tanggal Pinjam', 'Tenggat']
        ], null, 'A1');

        // Data
        $row = 2;
        $no = 1;
        foreach ($loans as $loan) {
            $status = isset($loan['status']) && $loan['status'] === 'returned' ? 'Dikembalikan' : 'Dipinjam';

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $loan['first_name'] . ' ' . $loan['last_name']);
            $sheet->setCellValue('C' . $row, $loan['title']);
            $sheet->setCellValue('D' . $row, $loan['quantity']);
            $sheet->setCellValue('E' . $row, $loan['loan_date']);
            $sheet->setCellValue('F' . $row, $loan['due_date']); 
            $row++;
        }

        // Download
        $filename = 'laporan_peminjaman.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
{
    $data['loans'] = $this->loanModel->getLoanList();

    $dompdf = new Dompdf();
    $dompdf->loadHtml(view('admin/loans/pdf', $data));
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return $this->response
        ->setContentType('application/pdf')
        ->setBody($dompdf->output());
}


    public function print()
    {
        $data['loans'] = $this->loanModel->getLoanList();
        return view('admin/loans/print', $data); // Buat file views/admin/loans/print.php
    }
}
