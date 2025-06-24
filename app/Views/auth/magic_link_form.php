<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Login via Email | BiblioGo</title>
<style>
  body {
    background: linear-gradient(135deg, #e0f7fa, #f3e5f5);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    display: flex;
    flex-direction: column;
  }

  .main-content {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
  }

  .login-box {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    max-width: 440px;
    width: 100%;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    animation: fadeIn 0.7s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .brand-logo {
    text-align: center;
    margin-bottom: 1rem;
  }

  .brand-logo h1 {
    font-weight: 700;
    font-size: 28px;
    color: #0d6efd;
    margin-bottom: 0;
  }

  .brand-logo h1 span {
    color: #ffc107;
  }

  .brand-desc {
    font-size: 0.9rem;
    color: #888;
    margin-bottom: 1.5rem;
  }

  .form-title {
    font-size: 1.2rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .btn-primary {
    background-color: #0d6efd;
    border: none;
    transition: 0.3s;
  }

  .btn-primary:hover {
    background-color: #0b5ed7;
  }

  .back-link {
    text-align: center;
    margin-top: 1rem;
    font-size: 0.9rem;
  }

  .back-link a {
    text-decoration: none;
    color: #6c757d;
  }

  .footer {
    text-align: center;
    font-size: 0.8rem;
    color: #666;
    padding: 1rem;
    background-color: #0d6efd;
    color: #fff;
  }

  .footer small {
    display: block;
    margin-top: 5px;
    font-size: 0.75rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- MAIN CONTENT -->
<div class="main-content">
  <div class="login-box">
    <div class="brand-logo">
      <h1>📚 Biblio<span>Go</span></h1>
      <div class="brand-desc">Sistem Informasi Perpustakaan</div>
    </div>

    <div class="form-title">Login via Email</div>

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

    <form action="<?= url_to('magic-link') ?>" method="post">
      <?= csrf_field() ?>

      <div class="mb-3">
        <label for="email" class="form-label">Alamat Email</label>
        <input type="email" class="form-control" name="email" placeholder="email@example.com"
          value="<?= old('email', auth()->user()->email ?? null) ?>" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary">Kirim Tautan Login</button>
      </div>
    </form>

    <div class="back-link mt-3">
      <a href="<?= base_url('login') ?>">← Kembali ke Login</a>
    </div>
  </div>
</div>

<!-- FOOTER TERPISAH -->


<?= $this->endSection() ?>
