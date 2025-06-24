<?php use CodeIgniter\I18n\Time; ?>

<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Detail Anggota</title>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background-color: #f4f6fa;
  }

  .card {
    border-radius: 1rem;
    border: none;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease-in-out;
  }

  .card:hover {
    transform: translateY(-3px);
  }

  .btn {
    border-radius: 0.5rem;
  }

  .btn i {
    margin-right: 6px;
  }

  .table-label {
    width: 160px;
    font-weight: 600;
    color: #495057;
  }

  .section-title {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.25rem;
  }

  .stat-card {
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: start;
    gap: 1rem;
  }

  .stat-card i {
    font-size: 2.5rem;
    color: #0d6efd;
  }

  .stat-card h4 {
    font-weight: bold;
    margin-bottom: 0;
  }

  .img-fluid {
    max-height: 300px;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<div class="row">
  <!-- Informasi Anggota -->
  <div class="col-12 col-lg-7 mb-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <a href="<?= base_url('admin/members'); ?>" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
          </a>
          <div class="d-flex gap-2">
            <a href="<?= base_url("admin/members/{$member['uid']}/edit"); ?>" class="btn btn-primary">
              <i class="bi bi-pencil-fill"></i> Edit
            </a>
            <form action="<?= base_url("admin/members/{$member['uid']}"); ?>" method="post" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
              <?= csrf_field(); ?>
              <input type="hidden" name="_method" value="DELETE">
              <button class="btn btn-danger" type="submit">
                <i class="bi bi-trash-fill"></i> Hapus
              </button>
            </form>
          </div>
        </div>

        <div class="section-title">Detail Anggota</div>
        <?php
        $tableData = [
          'Nama Lengkap'  => $member['first_name'] . ' ' . $member['last_name'],
          'Email'         => $member['email'],
          'Nomor Telepon' => $member['phone'],
          'Alamat'        => $member['address'],
          'Tanggal Lahir' => Time::parse($member['date_of_birth'], 'Asia/Jakarta')->toLocalizedString('d MMMM Y'),
          'Jenis Kelamin' => $member['gender'] === 'Male' ? 'Laki-laki' : 'Perempuan',
        ];
        ?>
        <table class="table border-0">
          <?php foreach ($tableData as $key => $value): ?>
            <tr>
              <td class="table-label"><?= $key; ?></td>
              <td>:</td>
              <td><?= esc($value); ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>

    <!-- Statistik Anggota -->
    <div class="row mt-4">
      <?php
      $stats = [
        ['label' => 'Buku Dipinjam', 'value' => $totalBooksLent, 'icon' => 'book'],
        ['label' => 'Transaksi Peminjaman', 'value' => $loanCount, 'icon' => 'arrows-exchange'],
        ['label' => 'Transaksi Pengembalian', 'value' => $returnCount, 'icon' => 'check'],
        ['label' => 'Jumlah Terlambat', 'value' => $lateCount, 'icon' => 'calendar-time'],
        ['label' => 'Denda Belum Dibayar', 'value' => 'Rp' . $unpaidFines, 'icon' => 'report-money'],
        ['label' => 'Denda Sudah Dibayar', 'value' => 'Rp' . $paidFines, 'icon' => 'cash'],
      ];
      ?>
      <?php foreach ($stats as $s): ?>
        <div class="col-12 col-sm-6 col-xl-4 mb-3">
          <div class="card stat-card">
            <div class="card-body d-flex gap-3 align-items-center">
              <i class="ti ti-<?= $s['icon']; ?>"></i>
              <div>
                <h5><?= $s['label']; ?></h5>
                <h4><?= $s['value']; ?></h4>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- QR Code -->
  <div class="col-12 col-lg-5">
    <div class="card h-100">
      <div class="card-body text-center">
        <p class="mb-3 text-secondary">UID: <strong><?= $member['uid']; ?></strong></p>
        <img id="qr-image" src="<?= base_url(MEMBERS_QR_CODE_URI . $member['qr_code']); ?>" alt="QR Code"
             class="img-fluid rounded border border-2 p-2" style="max-height:300px;">
        <button class="btn btn-outline-secondary mt-3" onclick="printQR()">
          <i class="bi bi-printer me-2"></i> Cetak QR
        </button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<!-- Script Cetak QR -->
<script>
function printQR() {
  const img = document.getElementById('qr-image');
  if (!img || !img.src) {
    alert("QR Code belum tersedia.");
    return;
  }

  const qrSrc = img.src.startsWith('http') ? img.src : location.origin + '/' + img.src;

  const win = window.open('', '_blank');
  win.document.write(`
    <html>
      <head>
        <title>Cetak QR Code</title>
        <style>
          body {
            text-align: center;
            font-family: Arial, sans-serif;
            padding: 30px;
          }
          img {
            max-width: 80%;
            height: auto;
            border: 2px solid #000;
            padding: 10px;
            margin-top: 20px;
          }
          h3 {
            margin-bottom: 10px;
          }
        </style>
      </head>
      <body>
        <h3>QR Code Anggota</h3>
        <p><strong>UID:</strong> <?= $member['uid']; ?></p>
        <img src="${qrSrc}" alt="QR Code">
        <script>
          window.onload = function() {
            window.print();
          };
        <\/script>
      </body>
    </html>
  `);
  win.document.close();
}
</script>
