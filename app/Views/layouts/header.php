<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Header BiblioGo</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    @media (max-width: 768px) {
      #navBtn {
        display: none !important;
      }
    }

    .app-header {
      background-color: #ffffff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.06);
      border-bottom: 1px solid #e2e8f0;
      z-index: 1030;
    }

    .dropdown-menu-animate-up {
      animation: dropdownFade 0.3s ease-in-out;
    }

    @keyframes dropdownFade {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

<!-- Header Start -->
<header class="app-header sticky-top">
  <nav class="navbar navbar-expand-lg navbar-light px-3">
    <!-- Sidebar Toggle (visible on mobile only) -->
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link nav-icon-hover" id="sidebarToggleBtn" href="javascript:void(0)">
          <i class="bi bi-list fs-4 text-primary"></i>
        </a>
      </li>
    </ul>

    <!-- Right Side Buttons & User Menu -->
    <div class="navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav flex-row flex-wrap align-items-center gap-2" id="headerUserNav">
        <!-- Action Buttons -->
        <li class="nav-item d-none d-md-block" id="navBtn">
          <a href="<?= base_url('admin/loans/new/members/search'); ?>" target="_blank" class="btn btn-primary shadow-sm text-nowrap">
            <i class="bi bi-journal-plus me-1"></i> Ajukan Peminjaman
          </a>
        </li>
        <li class="nav-item d-none d-md-block" id="navBtn">
          <a href="<?= base_url('admin/returns/new/search'); ?>" class="btn btn-outline-primary shadow-sm text-nowrap">
            <i class="bi bi-arrow-return-left me-1"></i> Pengembalian Buku
          </a>
        </li>
        <li class="nav-item d-none d-md-block" id="navBtn">
          <a href="<?= base_url('admin/fines/returns/search'); ?>" class="btn btn-outline-warning shadow-sm text-nowrap">
            <i class="bi bi-cash-coin me-1"></i> Bayar Denda
          </a>
        </li>

        <?php if (auth()->user()->inGroup('superadmin')) : ?>
          <li class="nav-item d-none d-md-block" id="navBtn">
            <a href="<?= base_url('admin/fines/settings'); ?>" class="btn btn-outline-danger shadow-sm text-nowrap">
              <i class="bi bi-gear me-1"></i> Pengaturan Denda
            </a>
          </li>
        <?php endif; ?>

        <!-- User Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover position-relative" href="#" id="dropUser" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://ui-avatars.com/api/?name=<?= auth()->user()->username ?>&background=0D8ABC&color=fff" 
                 alt="avatar" 
                 width="35" height="35" 
                 class="rounded-circle border border-primary shadow-sm" />
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up mt-2" aria-labelledby="dropUser" style="min-width: 280px;">
            <div class="p-3">
              <h6 class="mb-1">Profil Pengguna</h6>
              <div class="mb-2 small text-muted">
                Username: <strong><?= auth()->user()->username; ?></strong><br>
                Email: <strong><?= auth()->user()->email; ?></strong><br>
                Level:
                <?php $userGroup = auth()->user()->getGroups()[0]; ?>
                <?php if ($userGroup === 'superadmin') : ?>
                  <span class="badge bg-success text-dark"><?= $userGroup; ?></span>
                <?php elseif ($userGroup === 'admin') : ?>
                  <span class="badge bg-primary"><?= $userGroup; ?></span>
                <?php else : ?>
                  <span class="badge bg-secondary"><?= $userGroup; ?></span>
                <?php endif; ?>
              </div>
              <a href="<?= base_url('logout'); ?>" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
              </a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>
<!-- Header End -->

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
