<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Data Pengembalian</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
  body {
    background-color: #f9fbfd;
  }

  .card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  }

  .main-title {
    font-size: 1.8rem;
    font-weight: bold;
    color: #0d6efd;
    text-transform: uppercase;
    display: flex;
    align-items: center;
  }

  .main-title i {
    font-size: 1.5rem;
    margin-right: 0.6rem;
  }

  .table-hover tbody tr:hover {
    background-color: #eef4fb;
  }

  .table th, .table td {
    vertical-align: middle;
  }

  .badge {
    font-size: 0.75rem;
    padding: 0.4em 0.65em;
    border-radius: 1rem;
  }

  .btn i {
    margin-right: 6px;
  }

  .input-group .form-control {
    border-radius: 10px 0 0 10px;
  }

  .input-group .btn {
    border-radius: 0 10px 10px 0;
  }

  .alert {
    animation: fadeIn 0.4s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .status-badge {
    font-size: 0.8rem;
    padding: 6px 12px;
  }

  .table td small {
    font-size: 0.75rem;
    color: #6c757d;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php use CodeIgniter\I18n\Time; ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<div class="card mb-4">
  <div class="card-body">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
      <h1 class="main-title">
  <i class="bi bi-arrow-repeat"></i>
  Data Pengembalian
</h1>
      <div class="d-flex gap-2">
        <form class="input-group" action="" method="get">
          <input type="text" class="form-control" name="search" placeholder="Cari pengembalian..." value="<?= $search ?? ''; ?>">
          <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
        <a href="<?= base_url('admin/returns/new/search'); ?>" class="btn btn-primary">
          <i class="bi bi-plus-circle"></i> Tambah
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle text-nowrap">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Peminjam</th>
            <th>Judul Buku</th>
            <th>Jumlah</th>
            <th>Pinjam</th>
            <th>Tenggat</th>
            <th>Kembali</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1 + ($itemPerPage * ($currentPage - 1));
          $now = Time::now('Asia/Jakarta', 'id');
          ?>
          <?php if (empty($loans)) : ?>
            <tr>
              <td colspan="9" class="text-center text-muted"><i>Tidak ada data pengembalian</i></td>
            </tr>
          <?php else : ?>
            <?php foreach ($loans as $loan) :
              $loanCreateDate = Time::parse($loan['loan_date'], 'Asia/Jakarta', 'id');
              $loanDueDate = Time::parse($loan['due_date'], 'Asia/Jakarta', 'id');
              $loanReturnDate = Time::parse($loan['return_date'], 'Asia/Jakarta', 'id');

              $isFined = $loan['fine_id'] !== null;
              $isFinePaid = $isFined ? (($loan['amount_paid'] ?? 0) >= $loan['fine_amount']) : true;
              $isLate = $loanReturnDate->isAfter($loanDueDate);
            ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td>
                  <a href="<?= base_url("admin/members/{$loan['member_uid']}"); ?>" class="fw-semibold text-decoration-none text-dark">
                    <?= "{$loan['first_name']} {$loan['last_name']}"; ?>
                  </a>
                </td>
                <td>
                  <a href="<?= base_url("admin/books/{$loan['slug']}"); ?>" class="text-decoration-none">
                    <div class="fw-semibold"><?= "{$loan['title']} ({$loan['year']})"; ?></div>
                    <small>Author: <?= $loan['author']; ?></small>
                  </a>
                </td>
                <td class="text-center"><?= $loan['quantity']; ?></td>
                <td>
                  <?= $loanCreateDate->toLocalizedString('dd/MM/y'); ?><br>
                  <small><?= $loanCreateDate->toLocalizedString('HH:mm:ss'); ?></small>
                </td>
                <td><?= $loanDueDate->toLocalizedString('dd/MM/y'); ?></td>
                <td class="<?= $isLate ? 'text-danger' : 'text-dark'; ?>">
                  <?= $loanReturnDate->toLocalizedString('dd/MM/y'); ?><br>
                  <small><?= $loanReturnDate->toLocalizedString('HH:mm:ss'); ?></small>
                </td>
                <td class="text-center">
                  <?php if ($isFinePaid) : ?>
                    <span class="badge bg-success status-badge"><?= $isFined ? 'Lunas' : 'Selesai'; ?></span>
                  <?php else : ?>
                    <span class="badge bg-danger status-badge">Menunggak</span>
                  <?php endif; ?>
                </td>
                <td class="text-center">
                  <a href="<?= base_url("admin/returns/{$loan['uid']}"); ?>" class="btn btn-outline-info btn-sm">
                    <i class="bi bi-eye-fill"></i> Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-3">
      <?= $pager->links('returns', 'my_pager'); ?>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
