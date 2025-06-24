<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Laporan Data Anggota</title>
  <style>
    @page {
      margin: 20px 30px;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #000;
    }

    .header {
      text-align: center;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
      margin-bottom: 20px;
    }

    .header img {
      width: 60px;
      height: auto;
    }

    .header h1 {
      margin: 0;
      font-size: 18pt;
    }

    .header p {
      margin: 4px 0;
      font-size: 10pt;
    }

    .title {
      text-align: center;
      font-weight: bold;
      margin-top: 10px;
      font-size: 14pt;
      text-transform: uppercase;
    }

    table {
      border-collapse: collapse;
      width: 100%;
      margin-top: 10px;
    }

    table, th, td {
      border: 1px solid #000;
    }

    th {
      background-color: #f2f2f2;
      padding: 8px;
      text-align: center;
    }

    td {
      padding: 6px;
      vertical-align: top;
    }

    .footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      text-align: right;
      font-size: 9pt;
      color: #555;
      border-top: 1px solid #aaa;
      padding-top: 5px;
    }

    .page-number:after {
      content: counter(page);
    }

    .date {
      font-size: 10pt;
      float: left;
    }
  </style>
</head>
<body>

  <div class="header">
    <!-- Optional Logo -->
    <!-- <img src="<?= base_url('path-to-logo.png'); ?>" alt="Logo"> -->
    <h1>Perpustakaan Digital</h1>
    <p>Jl. Pendidikan No. 123, Garut - Jawa Barat</p>
    <p>Telepon: (0262) 123456 | Email: info@perpusdigital.ac.id</p>
  </div>

  <div class="title">Laporan Data Anggota</div>

  <table>
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Jenis Kelamin</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($members as $m): ?>
        <tr>
          <td style="text-align:center;"><?= $no++; ?></td>
          <td><?= esc($m['first_name'] . ' ' . $m['last_name']); ?></td>
          <td><?= esc($m['email']); ?></td>
          <td><?= esc($m['phone']); ?></td>
          <td><?= esc($m['address']); ?></td>
          <td style="text-align:center;"><?= esc($m['gender']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="footer">
    <div class="date">Dicetak pada: <?= date('d-m-Y H:i'); ?></div>
    <div class="page-number">Halaman: </div>
  </div>

</body>
</html>
