<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Login Pengguna | BiblioGo</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to right, #f0f3ff, #fefefe);
    font-family: 'Segoe UI', sans-serif;
  }

  .login-container {
    display: flex;
    min-height: 100vh;
    flex-wrap: wrap;
  }

  .login-image {
    flex: 1;
    background: url('<?= base_url('assets/images/perpustakaan.jpg') ?>') center center no-repeat;
    background-size: cover;
    min-height: 400px;
  }

  .login-form-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 2rem;
    background-color: #fff;
  }

  .login-card {
    width: 100%;
    max-width: 420px;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(0,0,0,0.07);
    padding: 2.5rem;
  }

  .login-brand {
    font-size: 1.8rem;
    font-weight: 800;
    color: #0d6efd;
  }

  .login-brand span {
    color: #0d47a1;
  }

  .login-brand small {
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
    .login-image {
      display: none;
    }

    .login-form-wrapper {
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
<div class="login-container">

  <!-- Gambar -->
  <div class="login-image"></div>

  <!-- Form -->
  <div class="login-form-wrapper animate__animated animate__fadeInRight">
    <div class="login-card text-center">

      <!-- Logo -->
      <div class="login-brand mb-4">
        📚 <span>Biblio</span><span style="color:#ffc107;">Go</span>
        <small>Sistem Informasi Perpustakaan</small>
      </div>

      <!-- Judul -->
      <h5 class="mb-4">Login Petugas</h5>

      <!-- Error Handling -->
      <?php if (session('error') !== null) : ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
      <?php elseif (session('errors') !== null) : ?>
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

      <?php if (session('message') !== null) : ?>
        <div class="alert alert-success"><?= session('message') ?></div>
      <?php endif ?>

      <!-- Form -->
      <form action="<?= url_to('login') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group mb-3 text-start">
          <i class="bi bi-envelope-fill"></i>
          <input type="email" class="form-control" name="email" placeholder="Email" value="<?= old('email') ?>" required />
        </div>

        <div class="form-group mb-3 text-start">
          <i class="bi bi-lock-fill"></i>
          <input type="password" class="form-control" name="password" placeholder="Password" id="password" required />
          <i class="bi bi-eye-slash-fill position-absolute" id="togglePassword" style="top:12px; right:12px; cursor:pointer;"></i>
        </div>

        <?php if (setting('Auth.sessionConfig')['allowRemembering']) : ?>
          <div class="form-check mb-3 text-start">
            <input type="checkbox" name="remember" class="form-check-input" <?= old('remember') ? 'checked' : '' ?>>
            <label class="form-check-label">Ingat saya</label>
          </div>
        <?php endif ?>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
        <?php if (setting('Auth.allowMagicLinkLogins')) : ?>
          <p class="small mt-3">Lupa kata sandi? <a href="<?= url_to('magic-link') ?>">Gunakan Magic Link</a></p>
        <?php endif ?>
        <p class="small mt-2">
  Belum punya akun? <a href="<?= url_to('register') ?>">Daftar di sini</a>
</p>
      </form>
    </div>
  </div>
</div>

<!-- JS toggle password -->
<script>
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');

  togglePassword.addEventListener('click', function () {
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.classList.toggle('bi-eye');
    this.classList.toggle('bi-eye-slash-fill');
  });
</script>
<?= $this->endSection() ?>
