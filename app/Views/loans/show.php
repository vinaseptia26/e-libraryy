<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Detail Peminjaman</title>
<style>
  #qr-code {
    background-image: url(<?= base_url(LOANS_QR_CODE_URI . $loan['loan_qr_code']); ?>);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    width: 100%;
    max-width: 300px;
    height: 300px;
    margin: 0 auto;
  }

  .card-icon h2 {
    font-size: 2rem;
    color: #0d6efd;
  }

  .card h4, .card h5 {
    margin-bottom: 0.25rem;
  }

  .card .badge h5 {
    margin: 0;
  }

  .data-table td {
    padding: 0.3rem 0.6rem;
    vertical-align: top;
  }

  .btn-outline-primary:hover {
    background-color: #0d6efd;
    color: white;
  }

  .card-body h5.card-title {
    font-size: 1.25rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php
use CodeIgniter\I18n\Time;

$now = Time::now(locale: 'id');
$loanDate = Time::parse($loan['loan_date'], locale: 'id');
$dueDate = Time::parse($loan['due_date'], locale: 'id');

$isLate = $now->isAfter($dueDate);
$isDueDate = $now->today()->difference($dueDate)->getDays() == 0;

$memberData = [
  'Nama Lengkap'  => [$loan['first_name'] . ' ' . $loan['last_name']],
  'Email'         => $loan['email'],
  'Nomor telepon' => $loan['phone'],
  'Alamat'        => $loan['address'],
];

$bookData = [
  'Judul buku'    => [$loan['title']],
  'Pengarang'     => $loan['author'],
  'Penerbit'      => $loan['publisher'],
  'Rak'           => $loan['rack']
];
?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card shadow-sm rounded-4 border-0 mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between mb-4">
      <a href="<?= base_url('admin/loans'); ?>" class="btn btn-outline-primary">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
      <div class="d-flex gap-2">
        <form action="<?= base_url("admin/loans/{$loan['uid']}"); ?>" method="post" onsubmit="return confirm('Yakin ingin membatalkan peminjaman ini?');">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger">
            <i class="bi bi-x-lg"></i> Batalkan
          </button>
        </form>
        <a href="<?= base_url("admin/returns/new?loan-uid={$loan['uid']}"); ?>" class="btn btn-primary">
          <i class="bi bi-check-circle-fill"></i> Selesaikan Pengembalian
        </a>
      </div>
    </div>

    <h5 class="card-title fw-bold text-primary mb-4">
      <i class="bi bi-file-text-fill me-2"></i>Detail Peminjaman
    </h5>

    <div class="row mb-4">
      <div class="col-md-6">
        <div class="card shadow-sm rounded-3 mb-3">
          <div class="card-body">
            <h5 class="text-secondary fw-bold mb-3">Data Anggota</h5>
            <table class="data-table w-100">
              <?php foreach ($memberData as $key => $val): ?>
                <tr>
                  <td class="fw-semibold"><?= $key ?></td>
                  <td style="width:10px;">:</td>
                  <td><?= is_array($val) ? $val[0] : $val; ?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm rounded-3 mb-3">
          <div class="card-body">
            <h5 class="text-secondary fw-bold mb-3">Data Buku</h5>
            <table class="data-table w-100">
              <?php foreach ($bookData as $key => $val): ?>
                <tr>
                  <td class="fw-semibold"><?= $key ?></td>
                  <td style="width:10px;">:</td>
                  <td><?= is_array($val) ? $val[0] : $val; ?></td>
                </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-4">
      <?php
        $infoCards = [
          ['icon' => 'bi-book', 'label' => 'Jumlah Buku Dipinjam', 'value' => $loan['quantity']],
          ['icon' => $isLate ? 'bi-exclamation-triangle-fill' : ($isDueDate ? 'bi-hourglass-split' : 'bi-check-circle-fill'),
            'label' => 'Status', 'value' => $isLate ? 'Terlambat' : ($isDueDate ? 'Jatuh Tempo' : 'Normal'),
            'badge' => $isLate ? 'danger' : ($isDueDate ? 'warning text-dark' : 'success')],
          ['icon' => 'bi-calendar-event', 'label' => 'Deadline', 'value' => $now->difference($dueDate)->getDays() . ' Hari lagi'],
          ['icon' => 'bi-calendar-check', 'label' => 'Waktu Pinjam', 'value' => $loanDate->toLocalizedString('d MMMM y, HH:mm')],
          ['icon' => 'bi-calendar-x', 'label' => 'Batas Pengembalian', 'value' => $dueDate->toLocalizedString('d MMMM y')],
        ];
      ?>
      <?php foreach ($infoCards as $info): ?>
        <div class="col-md-6 col-xl-4">
          <div class="card shadow-sm rounded-3 h-100 card-icon">
            <div class="card-body">
              <h2><i class="bi <?= $info['icon']; ?>"></i></h2>
              <h5><?= $info['label']; ?></h5>
              <?php if (isset($info['badge'])): ?>
                <span class="badge bg-<?= $info['badge']; ?> px-3 py-2 fw-semibold"><?= $info['value']; ?></span>
              <?php else: ?>
                <h4 class="fw-bold"><?= $info['value']; ?></h4>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 mb-4">
    <div class="card shadow-sm rounded-3 h-100">
      <div class="card-body text-center">
        <p class="text-muted small mb-2">UID: <span class="fw-semibold"><?= $loan['uid']; ?></span></p>
        <div id="qr-code" class="mb-3"></div>
        <?php if (!file_exists(LOANS_QR_CODE_PATH . $loan['qr_code']) || empty($loan['qr_code'])) : ?>
          <a href="<?= base_url("admin/loans/{$loan['uid']}?update-qr-code=true"); ?>" class="btn btn-outline-primary">
            Generate QR Code
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
