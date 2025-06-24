<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  
  <!-- ✅ Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <!-- ✅ Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- ✅ Custom Head -->
  <?= $this->include('layouts/head') ?>
  <?= $this->renderSection('head') ?>

  <style>
    body {
      margin: 0;
      padding: 0;
    }

    .dashboard-card {
      transition: all 0.3s ease-in-out;
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.08);
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }

    .dashboard-icon {
      font-size: 2.5rem;
      color: #fff;
      padding: 10px;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .icon-books { background-color: #4e73df; }
    .icon-stock { background-color: #1cc88a; }
    .icon-racks { background-color: #36b9cc; }
    .icon-category { background-color: #f6c23e; }
    .icon-member { background-color: #e74a3b; }
    .icon-loan { background-color: #858796; }

    .report-title {
      font-weight: bold;
      font-size: 1.2rem;
    }

    .report-number {
      font-size: 2rem;
      font-weight: bold;
      color: #4e73df;
    }

    .chart-box {
      border-radius: 15px;
      background: #fff;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
    }

    .stat-percentage {
      font-weight: bold;
      font-size: 1rem;
    }

    .card i {
      opacity: 0.8;
    }

    @media (max-width: 576px) {
      .card h3 {
        font-size: 1.5rem;
      }
      .card i {
        font-size: 2rem;
      }
    }

    .glass-card {
      background: rgba(255, 255, 255, 0.25);
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.18);
      transition: all 0.3s ease;
    }

    .glass-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
    }

    .report-icon {
      font-size: 2.8rem;
      margin-bottom: 0.6rem;
      opacity: 0.9;
    }

    .report-title {
      font-size: 0.95rem;
      font-weight: 600;
      margin-bottom: 0.2rem;
      color: #333;
    }

    .report-number {
      font-size: 2rem;
      font-weight: bold;
      color: #111;
    }

    #dashboardCarousel img {
      max-height: 250px;
      object-fit: contain;
      width: 100%;
      border-radius: 10px;
    }

    /* ✅ Fix untuk header ketutupan */
    .body-wrapper {
      padding-top: 80px; /* Tinggi header, sesuaikan jika perlu */
    }

    @media (max-width: 768px) {
      .body-wrapper {
        padding-top: 100px;
      }
    }
  </style>
</head>

<body>
  <!-- Wrapper utama -->
  <div class="page-wrapper" id="main-wrapper"
    data-layout="vertical"
    data-navbarbg="skin6"
    data-sidebartype="full"
    data-sidebar-position="fixed"
    data-header-position="fixed"
  >

    <!-- Sidebar -->
    <?= $this->include('layouts/sidebar') ?>

    <!-- Konten utama -->
    <div class="body-wrapper d-flex flex-column min-vh-100">
      
      <!-- Header -->
      <?= $this->include('layouts/header') ?>

      <!-- Main Content -->
      <main class="flex-grow-1 container-fluid py-3">
        <?= $this->renderSection('content') ?>
      </main>

      <!-- Footer -->
      <footer class="mt-auto">
        <?= $this->include('layouts/footer') ?>
      </footer>
    </div>
  </div>

  <!-- JS Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script tambahan -->
  <?= $this->include('imports/scripts/basic_scripts') ?>
  <?= $this->include('imports/scripts/admin') ?>
  <?= $this->renderSection('scripts') ?>
</body>

</html>
