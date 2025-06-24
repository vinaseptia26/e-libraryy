<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Edit Buku</title>
<style>
  #bookCoverPreview {
    max-height: 300px;
    object-fit: cover;
    border-radius: 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
  }

  .form-label {
    font-weight: 600;
    color: #333;
  }

  .form-control,
  .form-select {
    border-radius: 0.75rem;
    padding: 0.6rem 1rem;
  }

  .card {
    border-radius: 1rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  }

  .btn-primary {
    padding: 0.6rem 1.5rem;
    font-weight: bold;
    border-radius: 0.75rem;
  }

  .alert {
    border-radius: 0.75rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= previous_url() ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <h4 class="fw-semibold mb-4">📘 Edit Buku</h4>
    <form action="<?= base_url('admin/books/' . $book['slug']); ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>
      <input type="hidden" name="_method" value="PUT">
      <div class="row">
        <!-- Preview Sampul -->
        <div class="col-md-4 mb-3 text-center">
          <?php $coverImageFilePath = BOOK_COVER_URI . $book['book_cover']; ?>
          <img id="bookCoverPreview" src="<?= base_url((!empty($book['book_cover']) && file_exists($coverImageFilePath)) ? $coverImageFilePath : BOOK_COVER_URI . DEFAULT_BOOK_COVER); ?>" alt="Preview Cover" class="img-fluid">
        </div>

        <!-- Upload & Info -->
        <div class="col-md-8">
          <div class="mb-3">
            <label for="cover" class="form-label">Gambar Sampul Buku</label>
            <input class="form-control <?= $validation->hasError('cover') ? 'is-invalid' : '' ?>" type="file" id="cover" name="cover" onchange="previewImage()">
            <div class="invalid-feedback"><?= $validation->getError('cover'); ?></div>
          </div>

          <div class="mb-3">
            <label for="title" class="form-label">Judul Buku</label>
            <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= esc($oldInput['title'] ?? $book['title']); ?>" required>
            <div class="invalid-feedback"><?= $validation->getError('title'); ?></div>
          </div>

          <div class="mb-3">
            <label for="author" class="form-label">Pengarang</label>
            <input type="text" class="form-control <?= $validation->hasError('author') ? 'is-invalid' : '' ?>" id="author" name="author" value="<?= esc($oldInput['author'] ?? $book['author']); ?>" required>
            <div class="invalid-feedback"><?= $validation->getError('author'); ?></div>
          </div>

          <div class="mb-3">
            <label for="publisher" class="form-label">Penerbit</label>
            <input type="text" class="form-control <?= $validation->hasError('publisher') ? 'is-invalid' : '' ?>" id="publisher" name="publisher" value="<?= esc($oldInput['publisher'] ?? $book['publisher']); ?>" required>
            <div class="invalid-feedback"><?= $validation->getError('publisher'); ?></div>
          </div>
        </div>
      </div>

      <!-- Info Tambahan -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="isbn" class="form-label">ISBN</label>
          <input type="number" class="form-control <?= $validation->hasError('isbn') ? 'is-invalid' : '' ?>" id="isbn" name="isbn" minlength="10" maxlength="13" value="<?= esc($oldInput['isbn'] ?? $book['isbn']); ?>" required>
          <div class="form-text">Masukkan ISBN (10–13 digit angka)</div>
          <div class="invalid-feedback"><?= $validation->getError('isbn'); ?></div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="year" class="form-label">Tahun Terbit</label>
          <input type="number" class="form-control <?= $validation->hasError('year') ? 'is-invalid' : '' ?>" id="year" name="year" value="<?= esc($oldInput['year'] ?? $book['year']); ?>" required>
          <div class="invalid-feedback"><?= $validation->getError('year'); ?></div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="rack" class="form-label">Rak</label>
          <select class="form-select <?= $validation->hasError('rack') ? 'is-invalid' : '' ?>" id="rack" name="rack" required>
            <option>--Pilih Rak--</option>
            <?php foreach ($racks as $rack) : ?>
              <option value="<?= $rack['id']; ?>" <?= ($oldInput['rack'] ?? $book['rack_id']) == $rack['id'] ? 'selected' : '' ?>>
                <?= esc($rack['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= $validation->getError('rack'); ?></div>
        </div>

        <div class="col-md-4 mb-3">
          <label for="category" class="form-label">Kategori</label>
          <select class="form-select <?= $validation->hasError('category') ? 'is-invalid' : '' ?>" id="category" name="category" required>
            <option>--Pilih Kategori--</option>
            <?php foreach ($categories as $category) : ?>
              <option value="<?= $category['id']; ?>" <?= ($oldInput['category'] ?? $book['category_id']) == $category['id'] ? 'selected' : '' ?>>
                <?= esc($category['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= $validation->getError('category'); ?></div>
        </div>

        <div class="col-md-4 mb-3">
          <label for="stock" class="form-label">Jumlah Stok</label>
          <input type="number" class="form-control <?= $validation->hasError('stock') ? 'is-invalid' : '' ?>" id="stock" name="stock" value="<?= esc($oldInput['stock'] ?? $book['quantity']); ?>" required>
          <div class="invalid-feedback"><?= $validation->getError('stock'); ?></div>
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">
          <i class="ti ti-device-floppy"></i> Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function previewImage() {
    const fileInput = document.querySelector('#cover');
    const imagePreview = document.querySelector('#bookCoverPreview');
    const reader = new FileReader();

    reader.onload = function(e) {
      imagePreview.src = e.target.result;
    }

    if (fileInput.files.length) {
      reader.readAsDataURL(fileInput.files[0]);
    }
  }
</script>
<?= $this->endSection() ?>
