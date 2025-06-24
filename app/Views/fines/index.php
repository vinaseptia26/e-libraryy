<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Data Denda</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<style>
  body {
    background-color: #f9fbfd;
  }

  .card {
    border: none;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
  }

  .card-title {
    font-size: 1.6rem;
    font-weight: 700;
    color: #2d3436;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .alert {
    animation: fadeIn 0.5s ease-in-out;
    border-radius: 0.75rem;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .btn i {
    margin-right: 5px;
  }

  .input-group .form-control {
    border-radius: 0.75rem 0 0 0.75rem;
  }

  .input-group .btn {
    border-radius: 0 0.75rem 0.75rem 0;
  }

  .btn-filter {
    border-radius: 0.6rem;
    font-size: 0.85rem;
    padding: 0.4rem 0.75rem;
  }

  .table th, .table td {
    vertical-align: middle;
  }

  .badge {
    font-size: 0.75rem;
    padding: 0.4em 0.65em;
  }

  .text-muted-small {
    font-size: 0.8rem;
    color: #888;
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

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <h2 class="card-title text-danger">
        <i class="bi bi-cash-coin"></i> Data Denda
      </h2>

      <div class="d-flex flex-wrap gap-2">
        <?php if (auth()->user()->inGroup('superadmin')) : ?>
          <a href="<?= base_url('admin/fines/settings'); ?>" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-gear-fill"></i> Pengaturan Denda
          </a>
        <?php endif; ?>

        <form class="input-group input-group-sm" method="get" action="">
          <input type="hidden" name="paid-off" value="<?= $paidOffFilter ? 'true' : 'false'; ?>">
          <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari denda...">
          <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i></button>
        </form>
      </div>
    </div>

    <!-- Filter -->
    <div class="mb-3 d-flex align-items-center gap-2">
      <span class="text-muted-small">Filter:</span>
      <a href="<?= $paidOffFilter ? base_url('admin/fines?paid-off=false') : '#' ?>" class="btn btn<?= $paidOffFilter ? '-outline' : ''; ?>-warning btn-filter">
        <?php if (!$paidOffFilter): ?><i class="bi bi-check2-circle me-1"></i><?php endif; ?>Belum Lunas
      </a>
      <a href="<?= !$paidOffFilter ? base_url('admin/fines?paid-off=true') : '#' ?>" class="btn btn<?= $paidOffFilter ? '' : '-outline'; ?>-success btn-filter">
        <?php if ($paidOffFilter): ?><i class="bi bi-check2-circle me-1"></i><?php endif; ?>Lunas
      </a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table table-hover table-bordered align-middle text-nowrap">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tgl Kembali</th>
            <th>Telah Dibayar</th>
            <th>Total Denda</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $i = 1 + ($itemPerPage * ($currentPage - 1));
            $now = Time::now(locale: 'id');
          ?>

          <?php if (empty($fines)) : ?>
            <tr>
              <td colspan="7" class="text-center text-muted"><i>Data denda tidak ditemukan</i></td>
            </tr>
          <?php else : ?>
            <?php foreach ($fines as $fine) :
              $loanReturnDate = Time::parse($fine['return_date'], locale: 'id');
              $loanDueDate = Time::parse($fine['due_date'], locale: 'id');
              $daysLate = abs($loanReturnDate->difference($loanDueDate)->getDays());
              $isPaidOff = ($fine['amount_paid'] ?? 0) >= $fine['fine_amount'];
            ?>
              <tr>
                <td class="text-center"><?= $i++; ?></td>
                <td>
                  <a href="<?= base_url("admin/members/{$fine['member_uid']}"); ?>" class="text-decoration-none fw-semibold">
                    <?= "{$fine['first_name']} {$fine['last_name']}"; ?>
                  </a>
                </td>
                <td>
                  <div><strong><?= "{$fine['title']} ({$fine['year']})"; ?></strong></div>
                  <small class="text-muted">Jumlah: <?= $fine['quantity']; ?></small>
                </td>
                <td class="text-danger">
                  <div><strong><?= $loanReturnDate->toLocalizedString('dd/MM/y'); ?></strong></div>
                  <small class="text-muted">Terlambat <?= $daysLate ?> hari</small>
                </td>
                <td>
                  <div class="fw-semibold text-success">Rp<?= number_format($fine['amount_paid'] ?? 0, 0, ',', '.'); ?></div>
                  <?php if ($isPaidOff) : ?>
                    <span class="badge bg-success">Lunas</span>
                  <?php endif; ?>
                </td>
                <td class="fw-semibold">Rp<?= number_format($fine['fine_amount'], 0, ',', '.'); ?></td>
                <td class="text-center">
                  <?php if (!$isPaidOff) : ?>
                    <a href="<?= base_url("admin/fines/pay/{$fine['uid']}"); ?>" class="btn btn-warning btn-sm mb-1 w-100">
                      <i class="bi bi-wallet-fill"></i> Bayar
                    </a>
                  <?php endif; ?>
                  <a href="<?= base_url("admin/returns/{$fine['uid']}"); ?>" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-eye-fill"></i> Detail
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
      <?= $pager->links('fines', 'my_pager'); ?>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
