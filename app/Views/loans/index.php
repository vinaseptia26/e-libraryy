<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Data Peminjaman Buku</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
  body {
    background: linear-gradient(to bottom right, #f8fbff, #e9f0f9);
  }

  .card {
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    border-radius: 1rem;
  }

  .card-title-icon {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 1.6rem;
    font-weight: bold;
  }

  .status-badge {
    font-size: 0.85rem;
    padding: 5px 12px;
    border-radius: 50px;
    cursor: help;
    font-weight: 600;
  }

  .table thead th {
    vertical-align: middle;
    background-color: #f1f5f9;
    font-size: 0.9rem;
    text-transform: uppercase;
  }

  .table-hover tbody tr:hover {
    background-color: #eef3f9;
    transform: scale(1.005);
    transition: all 0.2s ease-in-out;
  }

  .btn-primary, .btn-outline-primary {
    transition: all 0.2s ease-in-out;
  }

  .btn-primary:hover, .btn-outline-primary:hover {
    transform: scale(1.05);
  }

  .input-group input::placeholder {
    color: #aaa;
    font-style: italic;
  }

  .action-buttons .btn {
    margin-bottom: 5px;
  }

  .export-buttons .btn {
    margin-left: 0.5rem;
  }

  @media (max-width: 768px) {
    .export-buttons {
      margin-top: 1rem;
      text-align: center;
    }

    .card-title-icon {
      justify-content: center;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php use CodeIgniter\I18n\Time; ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="card animate__animated animate__fadeIn">
  <div class="card-body p-4">
    <!-- Header -->
    <div class="row mb-4 align-items-center">
      <div class="col-md-6 mb-3 mb-md-0">
        <h4 class="card-title-icon text-primary">
          <i class="bi bi-journal-bookmark-fill"></i> Data Peminjaman Buku
        </h4>
      </div>
      <div class="col-md-6 d-md-flex justify-content-md-end align-items-md-center gap-2">
        <form action="" method="get" class="input-group w-100 w-md-auto">
          <input type="text" name="search" value="<?= $search ?? ''; ?>" class="form-control" placeholder="Cari nama/judul buku...">
          <button class="btn btn-outline-primary" type="submit">
            <i class="bi bi-search"></i> Cari
          </button>
        </form>
        <a href="<?= base_url('admin/loans/new/members/search'); ?>" class="btn btn-primary">
          <i class="bi bi-plus-circle"></i> Tambah Peminjaman
        </a>
      </div>
    </div>

    <!-- Tombol Ekspor -->
    <div class="export-buttons text-end mb-3">
      <a href="<?= base_url('admin/loans/print'); ?>" target="_blank" class="btn btn-outline-secondary">
        <i class="bi bi-printer"></i> Cetak
      </a>
      <a href="<?= base_url('admin/loans/export/excel'); ?>" class="btn btn-outline-success">
        <i class="bi bi-file-earmark-excel"></i> Excel
      </a>
      <a href="<?= base_url('admin/loans/export/pdf'); ?>" class="btn btn-outline-danger">
        <i class="bi bi-file-earmark-pdf"></i> PDF
      </a>
    </div>

    <!-- Tabel Peminjaman -->
    <div class="table-responsive">
      <table class="table table-hover align-middle table-striped text-center rounded-3 overflow-hidden">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Jumlah</th>
            <th>Pinjam</th>
            <th>Tenggat</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 + ($itemPerPage * ($currentPage - 1)); ?>
          <?php $now = Time::now('Asia/Jakarta'); ?>
          <?php if (empty($loans)) : ?>
            <tr>
              <td colspan="8" class="text-center py-4 text-muted"><i>Belum ada data peminjaman.</i></td>
            </tr>
          <?php else : ?>
            <?php foreach ($loans as $loan) :
              $loanDate = Time::parse($loan['loan_date'], 'Asia/Jakarta');
              $dueDate = Time::parse($loan['due_date'], 'Asia/Jakarta');
              $isLate = $now->isAfter($dueDate);
              $isDueToday = $now->toDateString() === $dueDate->toDateString();
              $isReturned = isset($loan['status']) && $loan['status'] === 'returned';
            ?>
              <tr>
                <td><?= $i++; ?></td>
                <td>
                  <a href="<?= base_url("admin/members/{$loan['member_uid']}"); ?>" class="fw-semibold text-primary text-decoration-none">
                    <?= "{$loan['first_name']} {$loan['last_name']}"; ?>
                  </a>
                </td>
                <td class="text-start">
                  <a href="<?= base_url("admin/books/{$loan['slug']}"); ?>" class="text-decoration-none">
                    <div class="fw-bold"><?= "{$loan['title']} ({$loan['year']})"; ?></div>
                    <small class="text-muted">Penulis: <?= $loan['author']; ?></small>
                  </a>
                </td>
                <td><?= $loan['quantity']; ?></td>
                <td>
                  <?= $loanDate->toLocalizedString('dd/MM/yyyy') ?><br>
                  <small class="text-muted"><?= $loanDate->toLocalizedString('HH:mm') ?></small>
                </td>
                <td><b><?= $dueDate->toLocalizedString('dd/MM/yyyy') ?></b></td>
                <td>
                  <?php if ($isReturned) : ?>
                    <span class="badge bg-secondary status-badge">
                      <i class="bi bi-check-circle me-1"></i> Dikembalikan
                    </span>
                  <?php elseif ($isLate) : ?>
                    <span class="badge bg-danger status-badge">
                      <i class="bi bi-exclamation-triangle me-1"></i> Terlambat
                    </span>
                  <?php elseif ($isDueToday) : ?>
                    <span class="badge bg-warning text-dark status-badge">
                      <i class="bi bi-calendar-event me-1"></i> Jatuh Tempo
                    </span>
                  <?php else : ?>
                    <span class="badge bg-success status-badge">
                      <i class="bi bi-clock me-1"></i> Normal
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <div class="action-buttons d-flex flex-column gap-1">
                    <a href="<?= base_url("admin/loans/{$loan['uid']}"); ?>" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-eye-fill"></i> Detail
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      <?= $pager->links('loans', 'my_pager'); ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
