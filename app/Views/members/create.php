<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>✨ Anggota Baru</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(to right, #e0eafc, #cfdef3);
  }

  .card {
    border: none;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    background-color: #fff;
    transition: all 0.3s ease;
  }

  .card:hover {
    transform: scale(1.01);
  }

  .card-title {
    color: #2c3e50;
    font-weight: 600;
  }

  .form-label {
    color: #2c3e50;
    font-weight: 500;
  }

  .btn-primary {
    background-color: #5c67f2;
    border: none;
  }

  .btn-primary:hover {
    background-color: #3d47c4;
  }

  .btn-outline-primary {
    border-color: #5c67f2;
    color: #5c67f2;
  }

  .btn-outline-primary:hover {
    background-color: #5c67f2;
    color: #fff;
  }

  .input-group-text {
    background-color: #f0f0f0;
    border-radius: 12px 0 0 12px;
    border: none;
  }

  .form-control,
  .form-check-input {
    border-radius: 12px;
  }

  .invalid-feedback {
    font-size: 0.85rem;
  }

  .alert {
    border-radius: 12px;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/members'); ?>" class="btn btn-outline-primary mb-4">
  <i class="bi bi-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card p-4">
  <div class="card-body">
    <h5 class="card-title">📝 Formulir Anggota Baru</h5>
    <form action="<?= base_url('admin/members'); ?>" method="post">
      <?= csrf_field(); ?>

      <div class="row mt-3">
        <div class="col-md-6 mb-3">
          <label for="first_name" class="form-label">Nama Depan</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control <?= $validation->hasError('first_name') ? 'is-invalid' : '' ?>"
              id="first_name" name="first_name" value="<?= $oldInput['first_name'] ?? ''; ?>" placeholder="John" required>
            <div class="invalid-feedback"><?= $validation->getError('first_name'); ?></div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="last_name" class="form-label">Nama Belakang</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-vcard-fill"></i></span>
            <input type="text" class="form-control <?= $validation->hasError('last_name') ? 'is-invalid' : '' ?>"
              id="last_name" name="last_name" value="<?= $oldInput['last_name'] ?? ''; ?>" placeholder="Doe">
            <div class="invalid-feedback"><?= $validation->getError('last_name'); ?></div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="email" class="form-label">Email</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>"
              id="email" name="email" value="<?= $oldInput['email'] ?? ''; ?>" placeholder="email@example.com" required>
            <div class="invalid-feedback"><?= $validation->getError('email'); ?></div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="phone" class="form-label">Nomor Telepon</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
            <input type="tel" class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>"
              id="phone" name="phone" value="<?= $oldInput['phone'] ?? ''; ?>" placeholder="+628123456789" required>
            <div class="invalid-feedback"><?= $validation->getError('phone'); ?></div>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
          <textarea class="form-control <?= $validation->hasError('address') ? 'is-invalid' : '' ?>" id="address" name="address" rows="3" required><?= $oldInput['address'] ?? ''; ?></textarea>
          <div class="invalid-feedback"><?= $validation->getError('address'); ?></div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="date_of_birth" class="form-label">Tanggal Lahir</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-calendar2-date-fill"></i></span>
            <input type="date" class="form-control <?= $validation->hasError('date_of_birth') ? 'is-invalid' : '' ?>"
              id="date_of_birth" name="date_of_birth" value="<?= $oldInput['date_of_birth'] ?? ''; ?>" required>
            <div class="invalid-feedback"><?= $validation->getError('date_of_birth'); ?></div>
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <div class="mt-2 <?= $validation->hasError('gender') ? 'is-invalid' : '' ?>">
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="male" name="gender" value="1" <?= $oldInput['gender'] ?? '' == '1' ? 'checked' : ''; ?>>
              <label class="form-check-label" for="male"><i class="bi bi-gender-male"></i> Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" class="form-check-input" id="female" name="gender" value="2" <?= $oldInput['gender'] ?? '' == '2' ? 'checked' : ''; ?>>
              <label class="form-check-label" for="female"><i class="bi bi-gender-female"></i> Perempuan</label>
            </div>
          </div>
          <div class="invalid-feedback"><?= $validation->getError('gender'); ?></div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary px-4 py-2 mt-3">
        <i class="bi bi-check-circle-fill"></i> Simpan Data
      </button>
    </form>
  </div>
</div>

<?= $this->endSection() ?>
