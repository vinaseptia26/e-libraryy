<?php 
$sidebarNavs = [
  '🏠 Home',
  ['name' => 'Dashboard', 'link' => '/admin/dashboard', 'icon' => 'bi bi-speedometer2'],
  '🔁 Transaksi',
  ['name' => 'Peminjaman', 'link' => '/admin/loans', 'icon' => 'bi bi-arrow-left-right'],
  ['name' => 'Pengembalian', 'link' => '/admin/returns', 'icon' => 'bi bi-journal-check'],
  ['name' => 'Denda', 'link' => '/admin/fines', 'icon' => 'bi bi-cash-coin'],
  '📂 Master Data',
  ['name' => 'Anggota', 'link' => '/admin/members', 'icon' => 'bi bi-people'],
  ['name' => 'Buku', 'link' => '/admin/books', 'icon' => 'bi bi-book'],
  ['name' => 'Kategori', 'link' => '/admin/categories', 'icon' => 'bi bi-tags'],
  ['name' => 'Rak', 'link' => '/admin/racks', 'icon' => 'bi bi-columns-gap'],
];
?>

<style>
  .left-sidebar {
    width: 240px;
    background-color: #ffffff;
    color: #333;
    min-height: 100vh;
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.08);
    border-top-right-radius: 16px;
    border-bottom-right-radius: 16px;
    overflow-y: auto;
    position: fixed;
    z-index: 1000;
    transition: all 0.3s ease;
  }

  .brand-logo {
    padding: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #eee;
    background-color: #f8f9fa;
  }

  .brand-logo h2 {
    font-size: 24px;
    font-weight: 800;
    margin: 0;
  }

  .brand-logo span:first-child {
    color: #0d6efd;
  }

  .brand-logo span:last-child {
    color: #ffc107;
  }

  .sidebar-nav {
    padding: 1rem 0;
  }

  .nav-small-cap {
    padding: 0.6rem 1.5rem;
    font-size: 0.75rem;
    color: #6c757d;
    font-weight: 600;
    text-transform: uppercase;
  }

  .sidebar-item a {
    display: flex;
    align-items: center;
    padding: 0.65rem 1.5rem;
    color: #333;
    text-decoration: none;
    transition: 0.2s ease-in-out;
    border-left: 3px solid transparent;
    font-size: 15px;
  }

  .sidebar-item a:hover {
    background-color: #f0f8ff;
    color: #0d6efd;
    padding-left: 1.8rem;
    border-left: 3px solid #0d6efd;
  }

  .sidebar-item i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
  }

  .sidebar-subitem {
    font-size: 14px;
    margin-left: 1.75rem;
    color: #555;
    display: flex;
    align-items: center;
    gap: 0.4rem;
  }

  .collapse {
    margin-left: 0.25rem;
  }

  .sidebar-nav::-webkit-scrollbar {
    width: 6px;
  }

  .sidebar-nav::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius: 10px;
  }
</style>

<aside class="left-sidebar">
  <div class="brand-logo">
    <a href="<?= base_url(); ?>" class="text-decoration-none">
      <h2>📚<span>Biblio</span><span>Go</span></h2>
    </a>
  </div>

  <nav class="sidebar-nav">
    <ul class="pt-2">
      <?php foreach ($sidebarNavs as $nav): ?>
        <?php if (is_string($nav)): ?>
          <li class="nav-small-cap"><?= $nav ?></li>
        <?php elseif (isset($nav['submenu'])): ?>
          <li class="sidebar-item">
            <a class="sidebar-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#menu-<?= strtolower(str_replace(' ', '-', $nav['name'])) ?>" role="button" aria-expanded="false">
              <div>
                <i class="<?= $nav['icon'] ?>"></i> <?= $nav['name'] ?>
              </div>
              <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="menu-<?= strtolower(str_replace(' ', '-', $nav['name'])) ?>">
              <ul class="list-unstyled ps-3 pt-1">
                <?php foreach ($nav['submenu'] as $sub): ?>
                  <li>
                    <a class="sidebar-link sidebar-subitem" href="<?= base_url($sub['link']) ?>">
                      <i class="bi bi-dot"></i> <?= $sub['name'] ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </li>
        <?php else: ?>
          <li class="sidebar-item">
            <a href="<?= base_url($nav['link']) ?>" class="sidebar-link">
              <i class="<?= $nav['icon'] ?>"></i> <?= $nav['name'] ?>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </nav>
</aside>
