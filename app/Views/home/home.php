<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Beranda | BiblioGo</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Animate.css & AOS (for scroll animations) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

<!-- Custom CSS -->
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(to right, #dbeeff, #ffffff);
    color: #333;
    overflow-x: hidden;
  }

  .hero-section {
    padding: 6rem 1rem 5rem;
    text-align: center;
    background: linear-gradient(135deg, #f1f8ff 0%, #dbeeff 100%);
    position: relative;
    overflow: hidden;
  }

  .hero-title {
    font-size: 3.8rem;
    font-weight: 800;
    color: #0d47a1;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.1);
  }

  .hero-title span {
    color: #0d6efd;
  }

  .hero-description {
    font-size: 1.2rem;
    color: #555;
    max-width: 700px;
    margin: 20px auto;
  }

  .btn-glass {
    backdrop-filter: blur(12px);
    background: rgba(255, 255, 255, 0.25);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #0d47a1;
    border-radius: 12px;
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease-in-out;
  }

  .btn-glass:hover {
    background-color: rgba(13, 110, 253, 0.15);
    color: #0b5ed7;
    transform: scale(1.05);
    box-shadow: 0 0 12px rgba(13, 110, 253, 0.3);
  }

  .image-section img {
    border-radius: 20px;
    transition: 0.4s ease;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
  }

  .image-section img:hover {
    transform: scale(1.03);
  }

  .book-slider {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(8px);
    padding: 5rem 1rem;
    border-top-left-radius: 48px;
    border-top-right-radius: 48px;
    margin-top: -60px;
  }

  .book-card {
    border-radius: 16px;
    overflow: hidden;
    transition: 0.3s ease;
    background-color: #fff;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
  }

  .book-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
  }

  .book-title {
    font-weight: 600;
    font-size: 1rem;
    margin-top: 0.75rem;
    color: #0d47a1;
  }

  @media screen and (max-width: 576px) {
    .hero-title {
      font-size: 2.5rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- HERO SECTION -->
<div class="container hero-section animate__animated animate__fadeInDown">
  <h1 class="hero-title">Selamat datang di <span>BiblioGo</span></h1>
  <p class="hero-description" data-aos="fade-up">
    Temukan ribuan buku menarik dan kembangkan imajinasimu bersama <strong>BiblioGo</strong> —
    sistem perpustakaan pintar yang siap menemani perjalanan belajarmu di mana saja, kapan saja.
  </p>

  <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5 mt-4" data-aos="zoom-in" data-aos-delay="300">
    <a href="<?= base_url('login'); ?>" class="btn btn-glass">
      <i class="bi bi-person-gear me-2"></i> Login Petugas
    </a>
    <a href="<?= base_url('book'); ?>" class="btn btn-glass">
      <i class="bi bi-book me-2"></i> Lihat Daftar Buku
    </a>
  </div>

  <!-- IMAGE -->
  <div class="image-section" data-aos="zoom-in-up" data-aos-delay="400">
    <div class="container px-5">
      <img src="<?= base_url('assets/images/dashboard1.png'); ?>" class="img-fluid" alt="Dashboard BiblioGo" width="720" height="480" loading="lazy">
    </div>
  </div>
</div>

<!-- SLIDER BUKU -->
<div class="container-fluid book-slider" data-aos="fade-up">
  <h3 class="text-center mb-5">📚 Buku Pilihan Minggu Ini</h3>
  <div class="container">
    <div class="row justify-content-center">
      <?php for ($i = 1; $i <= 5; $i++) : ?>
        <div class="col-lg-2 col-md-3 col-6 mb-4">
          <div class="card book-card">
            <img src="<?= base_url("assets/images/buku$i.jpg") ?>" class="card-img-top" alt="Buku <?= $i ?>">
            <div class="card-body text-center p-2">
              <p class="book-title mb-0">Buku Ke-<?= $i ?></p>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 1000,
    once: true
  });
</script>

<?= $this->endSection() ?>
