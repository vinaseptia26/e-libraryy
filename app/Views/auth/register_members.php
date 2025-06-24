<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Daftar Anggota | BiblioGo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-lg border-0 w-100" style="max-width: 900px;">
    <div class="row g-0">
      
      <!-- Gambar sebelah kanan -->
      <div class="col-md-6 d-none d-md-block">
        <img src="<?= base_url('images/register-image.png') ?>" alt="Register Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
      </div>

      <!-- Form Register -->
      <div class="col-md-6 p-5">
        <h4 class="text-center mb-4">Daftar Anggota</h4>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/members/register') ?>" method="post">
          <?= csrf_field() ?>

          <div class="mb-2">
            <label>Nama Depan</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Nama Belakang</label>
            <input type="text" name="last_name" class="form-control">
          </div>

          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-2">
            <label>Telepon</label>
            <input type="text" name="phone" class="form-control">
          </div>

          <div class="mb-2">
            <label>Alamat</label>
            <textarea name="address" class="form-control"></textarea>
          </div>

          <div class="mb-2">
            <label>Tanggal Lahir</label>
            <input type="date" name="date_of_birth" class="form-control">
          </div>

          <div class="mb-2">
            <label>Jenis Kelamin</label>
            <select name="gender" class="form-control">
              <option value="">-- Pilih --</option>
              <option value="L">Laki-laki</option>
              <option value="P">Perempuan</option>
            </select>
          </div>

          <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirm" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-success w-100">Daftar Sekarang</button>

          <div class="mt-3 text-center">
            <small>Sudah punya akun? <a href="<?= base_url('/members/login') ?>">Login di sini</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
