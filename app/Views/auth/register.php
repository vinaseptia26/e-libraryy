<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Daftar Pengguna | BiblioGo</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to right, #f0f3ff, #fefefe);
    font-family: 'Segoe UI', sans-serif;
  }

  .register-container {
    display: flex;
    min-height: 100vh;
    flex-wrap: wrap;
  }

  .register-form-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 2rem;
    background-color: #fff;
  }

  .register-image {
    flex: 1;
    background: url('<?= base_url('assets/images/perpustakaan.jpg') ?>') center center no-repeat;
    background-size: cover;
    min-height: 400px;
  }

  .register-card {
    width: 100%;
    max-width: 460px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,0.07);
    padding: 2.5rem;
  }

  .register-brand {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0d6efd;
  }

  .register-brand span {
    color: #0d47a1;
  }

  .register-brand small {
    display: block;
    font-size: 0.9rem;
    color: #999;
  }

  .form-group {
    position: relative;
  }

  .form-group i.bi {
    position: absolute;
    top: 12px;
    left: 12px;
    color: #6c757d;
  }

  .form-control {
    padding-left: 2.5rem;
    border-radius: 10px;
  }

  .btn-primary {
    border-radius: 10px;
    font-weight: 600;
    background-color: #0d6efd;
    transition: 0.3s;
  }

  .btn-primary:hover {
    background-color: #0b5ed7;
    box-shadow: 0 0 10px rgba(13, 110, 253, 0.3);
  }

  .alert {
    border-radius: 10px;
  }

  .back-link {
    position: absolute;
    top: 20px;
    left: 20px;
  }

  @media (max-width: 768px) {
    .register-image {
      display: none;
    }

    .register-form-wrapper {
      flex: 1 0 100%;
      padding: 2rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('back'); ?>
<a href="<?= base_url(); ?>" class="btn btn-outline-primary back-link">
  <i class="bi bi-house-door"></i> Kembali ke Beranda
</a>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="register-container">

  <!-- Form -->
  <div class="register-form-wrapper animate__animated animate__fadeInLeft">
    <div class="register-card text-center">

      <!-- Logo -->
      <div class="register-brand mb-4">
        📚 <span>Biblio</span><span style="color:#ffc107;">Go</span>
        <small>Sistem Informasi Perpustakaan</small>
      </div>

      <!-- Judul -->
      <h5 class="mb-4">Registrasi Pengguna</h5>

      <!-- Error Handling -->
      <?php if (session('error')) : ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
      <?php elseif (session('errors')) : ?>
        <div class="alert alert-danger">
          <?php if (is_array(session('errors'))) : ?>
            <?php foreach (session('errors') as $error) : ?>
              <?= $error ?><br>
            <?php endforeach ?>
          <?php else : ?>
            <?= session('errors') ?>
          <?php endif ?>
        </div>
      <?php endif ?>

      <!-- Form Register -->
      <form action="<?= url_to('register') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group mb-3 text-start">
          <i class="bi bi-envelope-fill"></i>
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old('email') ?>" required />
        </div>

        <div class="form-group mb-3 text-start">
          <i class="bi bi-person-fill"></i>
          <input type="text" class="form-control" name="username" placeholder="Username" value="<?= old('username') ?>" required />
        </div>

        <div class="form-group mb-3 text-start">
          <i class="bi bi-lock-fill"></i>
          <input type="password" class="form-control" name="password" placeholder="Password" required />
        </div>

        <div class="form-group mb-4 text-start">
          <i class="bi bi-lock-fill"></i>
          <input type="password" class="form-control" name="password_confirm" placeholder="Konfirmasi Password" required />
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Daftar</button>
        </div>

        <p class="small mt-3">
          Sudah punya akun? <a href="<?= url_to('login') ?>">Login di sini</a>
        </p>
      </form>
    </div>
  </div>

  <!-- Gambar -->
  <div class="register-image"></div>
</div>
<?= $this->endSection() ?>
