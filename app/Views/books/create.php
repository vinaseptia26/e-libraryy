<?php
// Tambah Buku - Dengan Tampilan Lebih Menarik dan Ikon
?>
<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Tambah Buku</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<style>
  body {
    background: #f4f6f9;
  }
  .preview-container {
    position: relative;
    border-radius: .75rem;
    overflow: hidden;
    height: 300px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    transition: border-color .3s;
  }
  .preview-container:hover {
    border-color: #0d6efd;
  }
  .preview-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .3s ease;
  }
  .preview-container:hover img {
    transform: scale(1.05);
  }
  .preview-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.1rem;
    font-weight: 500;
    background: rgba(255,255,255,0.4);
    opacity: 0;
    transition: opacity .3s;
  }
  .preview-container:hover .preview-overlay {
    opacity: 1;
  }
  .form-label {
    font-weight: 600;
  }
  .btn-save {
    padding: .6rem 2rem;
    font-size: 1rem;
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.2);
  }
  .card {
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.05);
  }
  .card h3 {
    font-weight: 700;
    color: #343a40;
  }
  .form-control:focus,
  .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25);
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <a href="<?= base_url('admin/books'); ?>" class="btn btn-outline-secondary mb-4">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>

  <div class="card shadow-sm rounded-3">
    <div class="card-body p-4">
      <h3 class="mb-4" data-aos="fade-right">📘 Tambah Buku Baru</h3>
      <form action="<?= base_url('admin/books'); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="row gy-4">
          <!-- Cover -->
          <div class="col-lg-4" data-aos="fade-up">
            <label for="cover" class="preview-container">
              <img id="bookCoverPreview" src="<?= base_url(BOOK_COVER_URI . DEFAULT_BOOK_COVER); ?>" alt="Cover Preview">
              <div class="preview-overlay">
                <i class="bi bi-image" style="font-size: 1.5rem;"></i>&nbsp; Pilih sampul
              </div>
            </label>
            <input class="form-control d-none <?= $validation->hasError('cover') ? 'is-invalid' : '' ?>" type="file" id="cover" name="cover" onchange="previewImage()">
            <?php if ($validation->hasError('cover')): ?>
              <div class="invalid-feedback d-block"><?= $validation->getError('cover');?></div>
            <?php endif; ?>
          </div>

          <!-- Input Fields -->
          <div class="col-lg-8">
            <div class="row gy-3">
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <label for="title" class="form-label"><i class="bi bi-book me-1"></i>Judul Buku</label>
                <input type="text" id="title" name="title" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['title'] ?? ''); ?>" required>
                <div class="invalid-feedback"><?= $validation->getError('title'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
                <label for="author" class="form-label"><i class="bi bi-person-lines-fill me-1"></i>Pengarang</label>
                <input type="text" id="author" name="author" class="form-control <?= $validation->hasError('author') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['author'] ?? ''); ?>" required>
                <div class="invalid-feedback"><?= $validation->getError('author'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <label for="publisher" class="form-label"><i class="bi bi-buildings me-1"></i>Penerbit</label>
                <input type="text" id="publisher" name="publisher" class="form-control <?= $validation->hasError('publisher') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['publisher'] ?? ''); ?>" required>
                <div class="invalid-feedback"><?= $validation->getError('publisher'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="250">
                <label for="isbn" class="form-label"><i class="bi bi-upc-scan me-1"></i>ISBN</label>
                <input type="number" id="isbn" name="isbn" class="form-control <?= $validation->hasError('isbn') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['isbn'] ?? ''); ?>" required>
                <div class="form-text">10–13 digit angka.</div>
                <div class="invalid-feedback"><?= $validation->getError('isbn'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <label for="year" class="form-label"><i class="bi bi-calendar3 me-1"></i>Tahun Terbit</label>
                <input type="number" id="year" name="year" class="form-control <?= $validation->hasError('year') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['year'] ?? ''); ?>" required>
                <div class="invalid-feedback"><?= $validation->getError('year'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="350">
                <label for="rack" class="form-label"><i class="bi bi-grid-1x2-fill me-1"></i>Rak</label>
                <select id="rack" name="rack" class="form-select <?= $validation->hasError('rack') ? 'is-invalid' : '' ?>" required>
                  <option value="" disabled selected>-- Pilih Rak --</option>
                  <?php foreach ($racks as $rack): ?>
                    <option value="<?= $rack['id']; ?>" <?= (old('rack') ?? '') == $rack['id'] ? 'selected' : '' ?>>
                      <?= esc($rack['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= $validation->getError('rack'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <label for="category" class="form-label"><i class="bi bi-tags-fill me-1"></i>Kategori</label>
                <select id="category" name="category" class="form-select <?= $validation->hasError('category') ? 'is-invalid' : '' ?>" required>
                  <option value="" disabled selected>-- Pilih Kategori --</option>
                  <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id']; ?>" <?= (old('category') ?? '') == $cat['id'] ? 'selected' : '' ?>>
                      <?= esc($cat['name']); ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback"><?= $validation->getError('category'); ?></div>
              </div>
              <div class="col-md-6" data-aos="fade-up" data-aos-delay="450">
                <label for="stock" class="form-label"><i class="bi bi-stack me-1"></i>Jumlah Stok</label>
                <input type="number" id="stock" name="stock" class="form-control <?= $validation->hasError('stock') ? 'is-invalid' : '' ?>" value="<?= esc($oldInput['stock'] ?? ''); ?>" required>
                <div class="invalid-feedback"><?= $validation->getError('stock'); ?></div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="col-12 text-end" data-aos="fade-up" data-aos-delay="500">
            <button type="submit" class="btn btn-primary btn-save">
              <i class="bi bi-save me-2"></i> Simpan Buku
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
  document.querySelector('.preview-container').addEventListener('click', () => {
    document.getElementById('cover').click();
  });
  function previewImage() {
    const inp = document.getElementById('cover');
    if (inp.files && inp.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        document.getElementById('bookCoverPreview').src = e.target.result;
      };
      reader.readAsDataURL(inp.files[0]);
    }
  }
</script>
<?= $this->endSection() ?>
