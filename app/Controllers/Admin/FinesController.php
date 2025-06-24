<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ScannedCodeModel;
use CodeIgniter\HTTP\ResponseInterface;

class FinesController extends BaseController
{
    public function index()
    {
        return view('admin/fines_search'); // ini halaman view utama kamu (QR & Search)
    }

    public function searchReturns()
    {
        $param = $this->request->getGet('param');

        // Simulasi pencarian data peminjaman berdasarkan param
        // (Gantilah bagian ini dengan query database sesuai kebutuhan kamu)
        $mockResults = [
            'uid001' => ['nama' => 'Vina', 'buku' => 'Laravel Uncover', 'tgl_pinjam' => '2024-06-10'],
            'xibox@gmail.com' => ['nama' => 'Xibox', 'buku' => 'PHP Dasar', 'tgl_pinjam' => '2024-06-05'],
        ];

        if (isset($mockResults[$param])) {
            $data = $mockResults[$param];
            return view('admin/_partial_return_result', ['data' => $data]);
        } else {
            return "<p class='text-danger text-center'>Data tidak ditemukan untuk: <strong>{$param}</strong></p>";
        }
    }

    public function saveScan()
    {
        if ($this->request->isAJAX()) {
            $code = $this->request->getPost('code');

            $model = new ScannedCodeModel();
            $model->insert([
                'code_data' => $code,
                'scanned_at' => date('Y-m-d H:i:s')
            ]);

            return $this->response->setJSON(['status' => 'success', 'message' => 'Scan QR berhasil disimpan']);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Permintaan tidak valid'
        ], ResponseInterface::HTTP_BAD_REQUEST);
    }
}
