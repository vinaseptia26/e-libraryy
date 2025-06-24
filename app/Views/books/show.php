<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Detail Buku</title>
<style>
  #book-cover {
    background-image: url(<?= base_url((!empty($book['book_cover']) && file_exists(BOOK_COVER_URI . $book['book_cover'])) ? BOOK_COVER_URI . $book['book_cover'] : BOOK_COVER_URI . DEFAULT_BOOK_COVER); ?>);
    background-size: cover;
    background-position: center;
    border-radius: 1rem;
    width: 100%;
    height: 380px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }

  .book-info h5 {
    margin-bottom: 0.5rem;
    color: #555;
  }

  .info-card {
    border-radius: 1rem;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: center;
  }

  .info-card h2 {
    font-size: 2rem;
    color: #0d6efd;
  }

  .info-card h3 {
    font-size: 1.5rem;
    font-weight: bold;
    margin-top: 0.5rem;
    color: #333;
  }

  .btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card shadow-sm rounded-4 mb-4">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <a href="<?= base_url('admin/books'); ?>" class="btn btn-outline-primary btn-icon">
        <i class="ti ti-arrow-left"></i> Kembali
      </a>
      <div class="d-flex gap-2">
        <a href="<?= base_url("admin/books/{$book['slug']}/edit"); ?>" class="btn btn-warning btn-icon">
          <i class="ti ti-edit"></i> Edit
        </a>
        <form action="<?= base_url("admin/books/{$book['slug']}"); ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
          <?= csrf_field(); ?>
          <input type="hidden" name="_method" value="DELETE">
          <button type="submit" class="btn btn-danger btn-icon">
            <i class="ti ti-trash"></i> Hapus
          </button>
        </form>
      </div>
    </div>

    <h4 class="fw-semibold mb-4">📖 Detail Buku</h4>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div id="book-cover" class="bg-light"></div>
      </div>
      <div class="col-md-8">
        <div class="book-info">
          <h2 class="fw-bold"><?= esc($book['title']); ?></h2>
          <h5><strong>Tahun:</strong> <?= esc($book['year']); ?></h5>
          <h5><strong>Pengarang:</strong> <?= esc($book['author']); ?></h5>
          <h5><strong>Penerbit:</strong> <?= esc($book['publisher']); ?></h5>
          <h5><strong>Kategori:</strong> <?= esc($book['category']); ?></h5>
          <h5><strong>Rak:</strong> <?= esc($book['rack']); ?>, <strong>Lantai:</strong> <?= esc($book['floor']); ?></h5>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Statistik -->
<div class="row g-4">
  <div class="col-lg-4 col-md-6">
    <div class="card info-card">
      <div class="card-body">
        <h2><i class="ti ti-database"></i></h2>
        <h3>Total: <?= esc($book['quantity']); ?></h3>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-6">
    <div class="card info-card">
      <div class="card-body">
        <h2><i class="ti ti-arrows-exchange"></i></h2>
        <h3>Dipinjam: <?= esc($loanCount); ?></h3>
      </div>
    </div>
  </div>
  <div class="col-lg-4 col-md-12">
    <div class="card info-card">
      <div class="card-body">
        <h2><i class="ti ti-book-2"></i></h2>
        <h3>Tersedia: <?= esc($bookStock); ?></h3>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
