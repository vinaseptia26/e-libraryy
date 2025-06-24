<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Login Anggota | BiblioGo</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-lg border-0 w-100" style="max-width: 800px;">
    <div class="row g-0">
      
      <!-- Gambar sebelah kanan -->
      <div class="col-md-6 d-none d-md-block">
        <img src="<?= base_url('images/login-image.png') ?>" alt="Login Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
      </div>

      <!-- Form Login -->
      <div class="col-md-6 p-5">
        <h4 class="text-center mb-4">Login Anggota</h4>

        <?php if (session()->getFlashdata('error')) : ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <form action="<?= base_url('/members/login') ?>" method="post">
          <?= csrf_field() ?>
          <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Masuk</button>

          <div class="mt-3 text-center">
            <small>Belum punya akun? <a href="<?= base_url('/members/register') ?>">Daftar di sini</a></small>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
