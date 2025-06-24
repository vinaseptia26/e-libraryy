<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Konfirmasi Pengembalian</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
  body {
    background: #f4f7fa;
  }

  .card {
    border-radius: 1rem;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  }

  .card-title {
    font-weight: 700;
    font-size: 1.8rem;
    color: #2c3e50;
  }

  label.form-label {
    font-weight: 600;
    color: #34495e;
  }

  input[disabled] {
    background-color: #e9ecef !important;
    border: 1.5px solid #ced4da !important;
    color: #495057 !important;
    font-weight: 500;
  }

  .btn-primary {
    background: linear-gradient(135deg, #0062E6, #33AEFF);
    border: none;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: background 0.3s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(135deg, #0056b3, #228be6);
  }

  .alert-danger {
    background: #ffebe6;
    border: 1.5px solid #ff6f61;
    color: #b03018;
    font-weight: 600;
    border-radius: 0.8rem;
  }

  .alert-danger h5 {
    font-weight: 700;
  }

  .late-indicator {
    color: #e74c3c;
    font-weight: 700;
    font-size: 1.1rem;
  }

  .btn i {
    margin-right: 0.5rem;
    font-size: 1.2rem;
  }

  @media (max-width: 575.98px) {
    .card-title {
      font-size: 1.4rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
use App\Models\FinesPerDayModel;
use CodeIgniter\I18n\Time;

$now = Time::now(locale: 'id');

$loanCreateDate = Time::parse($loan['loan_date'], locale: 'id');
$loanDueDate = Time::parse($loan['due_date'], locale: 'id');

$isLate = $now->isAfter($loanDueDate);
$daysLate = $now->today()->difference($loanDueDate)->getDays();
?>

<a href="<?= base_url('admin/returns/new/search'); ?>" class="btn btn-outline-secondary mb-4">
  <i class="bi bi-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<form action="<?= base_url('admin/returns'); ?>" method="post" novalidate>
  <?= csrf_field(); ?>
  <input type="hidden" name="loan_uid" value="<?= $loan['uid']; ?>">
  <input type="hidden" name="date" value="<?= Time::now(locale: 'id'); ?>">

  <div class="card p-4">
    <h2 class="card-title mb-4">Konfirmasi Pengembalian</h2>

    <div class="row gy-3">
      <!-- Data Peminjam -->
      <div class="col-md-6">
        <label for="member_name" class="form-label">Nama Peminjam</label>
        <input type="text" id="member_name" class="form-control" value="<?= "{$loan['first_name']} {$loan['last_name']}"; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="member_email" class="form-label">Email</label>
        <input type="email" id="member_email" class="form-control" value="<?= $loan['email']; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="member_phone" class="form-label">Nomor Telepon</label>
        <input type="text" id="member_phone" class="form-control" value="<?= $loan['phone']; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="member_address" class="form-label">Alamat</label>
        <input type="text" id="member_address" class="form-control" value="<?= $loan['address']; ?>" disabled>
      </div>

      <!-- Data Buku -->
      <div class="col-md-6">
        <label for="book_title" class="form-label">Judul Buku</label>
        <input type="text" id="book_title" class="form-control" value="<?= "{$loan['title']} ({$loan['year']})"; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="book_author" class="form-label">Pengarang & Penerbit</label>
        <input type="text" id="book_author" class="form-control" value="<?= "{$loan['author']}; {$loan['publisher']}"; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="book_category" class="form-label">Kategori</label>
        <input type="text" id="book_category" class="form-control" value="<?= $loan['category']; ?>" disabled>
      </div>
      <div class="col-md-6">
        <label for="quantity" class="form-label">Jumlah</label>
        <input type="number" id="quantity" class="form-control" value="<?= $loan['quantity']; ?>" disabled>
      </div>
    </div>

    <hr class="my-4">

    <div class="row gy-3">
      <div class="col-md-4">
        <label for="loan_date" class="form-label">Tanggal Pinjam</label>
        <input type="text" id="loan_date" class="form-control" value="<?= $loanCreateDate->toLocalizedString('dd/MM/y HH:mm'); ?>" disabled>
      </div>
      <div class="col-md-4">
        <label for="due_date" class="form-label">Tenggat Pengembalian</label>
        <input type="text" id="due_date" class="form-control" value="<?= $loanDueDate->toLocalizedString('dd/MM/y HH:mm'); ?>" disabled>
      </div>
      <div class="col-md-4">
        <label for="late" class="form-label">Terlambat</label>
        <input
          type="text"
          id="late"
          class="form-control <?= $isLate ? 'late-indicator' : ''; ?>"
          value="<?= $isLate ? abs($daysLate) . ' Hari' : '-'; ?>"
          disabled
        >
      </div>
    </div>

    <?php if ($isLate) : 
      $finePerDay = FinesPerDayModel::getAmount();
      $totalFine = abs($daysLate) * $loan['quantity'] * $finePerDay;
    ?>
      <div class="alert alert-danger mt-4" role="alert">
        <h5 class="alert-heading mb-3"><i class="bi bi-exclamation-triangle-fill"></i> Denda Terlambat</h5>
        <p><strong>Keterlambatan:</strong> <?= abs($daysLate); ?> hari</p>
        <p><strong>Jumlah Buku:</strong> <?= $loan['quantity']; ?></p>
        <p><strong>Denda per hari:</strong> Rp<?= number_format($finePerDay, 0, ',', '.'); ?></p>
        <hr>
        <h4 class="mb-0">Total denda: Rp<?= number_format($totalFine, 0, ',', '.'); ?></h4>
      </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary btn-lg w-100 mt-4" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pengembalian?')">
      <i class="bi bi-check2-circle"></i> Konfirmasi Pengembalian
    </button>
  </div>
</form>

<?= $this->endSection() ?>
