<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>📖 Daftar Buku Premium</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

<style>
  body {
    background: linear-gradient(to right, #eef5ff, #ffffff);
    font-family: 'Segoe UI', sans-serif;
    transition: background 0.4s ease;
  }

  .book-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(12px);
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    position: relative;
  }

  .book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  }

  .book-cover {
    height: 260px;
    background-size: cover;
    background-position: center;
    border-bottom: 1px solid #e0e0e0;
  }

  .book-title {
    font-weight: 600;
    font-size: 1rem;
    color: #1e3a8a;
  }

  .search-box .input-group {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.1);
  }

  .search-box input {
    border: 1px solid #ced4da;
    border-right: none;
    padding: 0.75rem;
  }

  .search-box button {
    background-color: #007bff;
    color: white;
  }

  .page-heading {
    font-weight: 700;
    font-size: 1.75rem;
    color: #0d47a1;
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .alert-warning {
    background-color: #fff3cd;
    border-radius: 12px;
    border: none;
  }

  .rating-stars {
    color: #ffc107;
    font-size: 0.9rem;
  }

  .dark-mode {
    background: #1a1a2e;
    color: #f1f1f1;
  }

  .dark-mode .book-card {
    background: rgba(255, 255, 255, 0.1);
    color: #f1f1f1;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('back'); ?>
<a href="<?= base_url(); ?>" class="btn btn-outline-primary m-3 position-absolute">
  <i class="bi bi-house-door-fill"></i> Home
</a>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="page-heading" data-aos="fade-right"><i class="bi bi-journals"></i> Daftar Buku</h4>
    <button onclick="toggleDarkMode()" class="btn btn-sm btn-outline-dark"><i class="bi bi-moon-stars"></i></button>
  </div>

  <form action="" method="get" class="search-box mb-4" data-aos="zoom-in">
    <div class="input-group">
      <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="🔍 Cari buku berdasarkan judul...">
      <button class="btn" type="submit"><i class="bi bi-search"></i></button>
    </div>
  </form>

  <div class="row">
    <?php if (empty($books)) : ?>
      <div class="col-12">
        <div class="alert alert-warning text-center" role="alert">
          📭 Buku tidak ditemukan. Coba kata kunci lain ya!
        </div>
      </div>
    <?php endif; ?>

    <?php foreach ($books as $book) : ?>
      <?php
      $coverImageFilePath = BOOK_COVER_URI . $book['book_cover'];
      $coverUrl = (!empty($book['book_cover']) && file_exists($coverImageFilePath))
        ? base_url($coverImageFilePath)
        : base_url(BOOK_COVER_URI . DEFAULT_BOOK_COVER);
      ?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-4" data-aos="zoom-in-up">
        <div class="card book-card h-100" title="<?= $book['title']; ?>">
          <a href="<?= base_url("admin/books/{$book['slug']}"); ?>">
            <div class="book-cover" style="background-image: url('<?= $coverUrl ?>');"></div>
          </a>
          <div class="card-body text-center p-3">
            <p class="book-title mb-1">
              <?= substr($book['title'], 0, 64) . ((strlen($book['title']) > 64) ? '...'  : '') . " ({$book['year']})"; ?>
            </p>
            <div class="rating-stars">
              ★★★★☆
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="mt-4 d-flex justify-content-center">
    <?= $pager->links('books', 'my_pager'); ?>
  </div>
</div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 800 });

  function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
  }
</script>
<?= $this->endSection() ?>