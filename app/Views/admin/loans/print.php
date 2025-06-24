<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Laporan Peminjaman Buku</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      font-size: 13px;
      margin: 40px;
      color: #333;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #007BFF;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .header img {
      width: 60px;
      height: auto;
      margin-bottom: 5px;
    }

    .header h1 {
      margin: 0;
      font-size: 20px;
    }

    .header p {
      margin: 2px 0;
      font-size: 12px;
      color: #555;
    }

    h2 {
      text-align: center;
      margin: 20px 0 10px;
      font-size: 18px;
      color: #007BFF;
    }

    .date {
      text-align: right;
      margin-bottom: 10px;
      font-size: 12px;
      color: #555;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }

    th {
      background-color: #007BFF;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status-returned {
      background-color: #d4edda;
      color: #155724;
    }

    .status-borrowed {
      background-color: #fff3cd;
      color: #856404;
    }

    .footer {
      margin-top: 50px;
      text-align: right;
      font-size: 13px;
    }

    .signature {
      margin-top: 80px;
      text-align: right;
      font-size: 13px;
    }

    @media print {
      @page {
        size: landscape;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body onload="window.print()">

  <div class="header">
    <img src="<?= base_url('assets/img/logo.png') ?>" alt="Logo">
    <h1>BiblioGo - Sistem Informasi Perpustakaan</h1>
    <p>Email: info@bibliogo.id | Telp: (0262) 123456</p>
  </div>

  <h2>Laporan Peminjaman Buku</h2>
  <div class="date">Tanggal Cetak: <?= date('d/m/Y H:i') ?></div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Peminjam</th>
        <th>Judul Buku</th>
        <th>Jumlah</th>
        <th>Tanggal Pinjam</th>
        <th>Tenggat</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($loans as $loan): 
        $status = $loan['status'] ?? 'borrowed';
        $class = $status === 'returned' ? 'status-returned' : 'status-borrowed';
      ?>
      <tr class="<?= $class ?>">
        <td><?= $no++ ?></td>
        <td><?= ($loan['first_name'] ?? '-') . ' ' . ($loan['last_name'] ?? '-') ?></td>
        <td><?= $loan['title'] ?? '-' ?></td>
        <td><?= $loan['quantity'] ?? 0 ?></td>
        <td><?= date('d/m/Y', strtotime($loan['loan_date'] ?? '')) ?></td>
        <td><?= date('d/m/Y', strtotime($loan['due_date'] ?? '')) ?></td>
        <td><?= $status === 'returned' ? 'Dikembalikan' : 'Dipinjam' ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
    Dicetak oleh: <strong>Admin Perpustakaan</strong>
  </div>

  <div class="signature">
    Garut, <?= date('d F Y') ?><br>
    <strong>__________________________</strong><br>
    <small>Tanda Tangan Petugas</small>
  </div>

</body>
</html>
