<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Peminjaman - BiblioGo</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      margin: 30px;
    }

    .kop {
      text-align: center;
      border-bottom: 2px solid #000;
      margin-bottom: 15px;
      padding-bottom: 10px;
    }

    .kop img {
      width: 60px;
      float: left;
      margin-right: 10px;
    }

    .kop h1 {
      font-size: 20px;
      margin: 0;
    }

    .kop p {
      font-size: 11px;
      margin: 2px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    table th, table td {
      border: 1px solid #555;
      padding: 6px;
      text-align: center;
    }

    table th {
      background-color: #f0f0f0;
    }

    .ttd {
      margin-top: 60px;
      width: 100%;
      text-align: right;
    }

    .ttd p {
      margin: 0;
    }
  </style>
</head>
<body>

  <div class="kop">
    <!-- Logo BiblioGo (opsional: bisa ditaruh di folder public/logo.png) -->
    <!-- <img src="<?= base_url('logo_bibliogo.png'); ?>" alt="Logo BiblioGo"> -->
    <h1>BiblioGo - Sistem Informasi Perpustakaan</h1>
    <p>Jl. Buku Cerdas No. 88, Garut | Email: info@bibliogo.id</p>
    <p><b>Laporan Data Peminjaman Buku</b></p>
  </div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Peminjam</th>
        <th>Judul Buku</th>
        <th>Jumlah</th>
        <th>Tanggal Pinjam</th>
        <th>Tenggat</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($loans as $loan): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= "{$loan['first_name']} {$loan['last_name']}" ?></td>
          <td style="text-align:left;">
            <?= "{$loan['title']} ({$loan['year']})" ?><br>
            <small><i>Penulis: <?= $loan['author'] ?></i></small>
          </td>
          <td><?= $loan['quantity'] ?></td>
          <td><?= date('d/m/Y', strtotime($loan['loan_date'])) ?></td>
          <td><?= date('d/m/Y', strtotime($loan['due_date'])) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="ttd">
    <p>Garut, <?= date('d F Y') ?></p>
    <br><br><br>
    <p><b><u>Kepala Perpustakaan</u></b></p>
    <p style="margin-top: 3px;">__________________________</p>
  </div>

</body>
</html>
