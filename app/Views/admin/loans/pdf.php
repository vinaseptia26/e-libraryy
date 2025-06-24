<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Peminjaman Buku</title>
  <style>
    * { box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      font-size: 12px;
      color: #000;
      padding: 30px;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
    }

    .header h1 {
      font-size: 20px;
      margin: 0;
    }

    .header p {
      font-size: 12px;
      margin: 4px 0;
    }

    .date {
      text-align: right;
      margin-bottom: 10px;
      font-size: 12px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #000;
      padding: 8px;
      text-align: center;
      vertical-align: middle;
    }

    th {
      background-color: #eaeaea;
      font-weight: bold;
    }

    tr:nth-child(even) {
      background-color: #f9f9f9;
    }

    .status-returned {
      background-color: #d4edda;
      color: #155724;
    }

    .status-late {
      background-color: #f8d7da;
      color: #721c24;
    }

    .status-borrowed {
      background-color: #fff3cd;
      color: #856404;
    }

    .footer {
      margin-top: 40px;
      width: 100%;
      display: flex;
      justify-content: flex-end;
    }

    .footer .ttd {
      text-align: center;
      width: 200px;
    }

    .footer .ttd p {
      margin-top: 80px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>Perpustakaan BiblioGo</h1>
    <p>Jl. Contoh No. 123, Kota Buku, Indonesia</p>
    <p>Telp: (021) 123456 | Email: info@bibliogo.id</p>
  </div>

  <div class="date">
    Dicetak pada: <?= date('d/m/Y H:i') ?>
  </div>

  <h3 style="text-align:center; margin-bottom: 10px;">Laporan Peminjaman Buku</h3>

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
      <?php if (!empty($loans)): ?>
        <?php $no = 1; foreach ($loans as $loan): 
          $statusText = ($loan['status'] ?? '') === 'returned' ? 'Dikembalikan' : ((strtotime($loan['due_date'] ?? '') < time()) ? 'Terlambat' : 'Dipinjam');
          $statusClass = ($loan['status'] ?? '') === 'returned' ? 'status-returned' : ((strtotime($loan['due_date'] ?? '') < time()) ? 'status-late' : 'status-borrowed');
        ?>
        <tr class="<?= $statusClass ?>">
          <td><?= $no++ ?></td>
          <td><?= esc(($loan['first_name'] ?? '-') . ' ' . ($loan['last_name'] ?? '-')) ?></td>
          <td><?= esc($loan['title'] ?? '-') ?></td>
          <td><?= esc($loan['quantity'] ?? 0) ?></td>
          <td><?= date('d/m/Y', strtotime($loan['loan_date'] ?? 'now')) ?></td>
          <td><?= date('d/m/Y', strtotime($loan['due_date'] ?? 'now')) ?></td>
          <td><?= $statusText ?></td>
        </tr>
        <?php endforeach ?>
      <?php else: ?>
        <tr>
          <td colspan="7"><i>Tidak ada data peminjaman.</i></td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="footer">
    <div class="ttd">
      <p>Petugas Perpustakaan</p>
      <p>(_______________________)</p>
    </div>
  </div>

</body>
</html>
