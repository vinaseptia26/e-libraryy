<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Dashboard</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
  <div id="dashboardCarousel" class="carousel slide mb-4 shadow rounded-4 overflow-hidden" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="<?= base_url('assets/images/background1.jpg'); ?>" class="d-block w-100" alt="Slide 1">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/images/background2.jpg'); ?>" class="d-block w-100" alt="Slide 2">
    </div>
    <div class="carousel-item">
      <img src="<?= base_url('assets/images/background.jpg'); ?>" class="d-block w-100" alt="Slide 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#dashboardCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

  <!-- BOOKS -->
  <div class="row g-4 mb-4">
  <div class="col-md-3 col-sm-6">
    <a href="<?= base_url('admin/books'); ?>" class="text-decoration-none">
      <div class="card text-white bg-primary h-100 shadow dashboard-card">
        <div class="card-body text-center">
          <i class="ti ti-book display-4 mb-3"></i>
          <h6 class="fw-bold">Jumlah Buku</h6>
          <h3><?= count($books); ?></h3>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-sm-6">
    <a href="<?= base_url('admin/books'); ?>" class="text-decoration-none">
      <div class="card text-white bg-success h-100 shadow dashboard-card">
        <div class="card-body text-center">
          <i class="ti ti-database display-4 mb-3"></i>
          <h6 class="fw-bold">Stok Buku</h6>
          <h3><?= $totalBookStock; ?></h3>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-sm-6">
    <a href="<?= base_url('admin/racks'); ?>" class="text-decoration-none">
      <div class="card text-white bg-warning h-100 shadow dashboard-card">
        <div class="card-body text-center">
          <i class="ti ti-columns display-4 mb-3"></i>
          <h6 class="fw-bold">Rak Buku</h6>
          <h3><?= count($racks); ?></h3>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-sm-6">
    <a href="<?= base_url('admin/categories'); ?>" class="text-decoration-none">
      <div class="card text-white bg-danger h-100 shadow dashboard-card">
        <div class="card-body text-center">
          <i class="ti ti-category-2 display-4 mb-3"></i>
          <h6 class="fw-bold">Kategori</h6>
          <h3><?= count($categories); ?></h3>
        </div>
      </div>
    </a>
  </div>
</div>


<!-- REPORT TODAY -->
<div class="card p-4 mb-4 shadow-sm border-0">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0 text-primary">
      <i class="bi bi-bar-chart-fill me-2"></i> Laporan Hari Ini
    </h4>
    <span class="text-muted"><?= $dateNow->toLocalizedString('d MMMM Y'); ?></span>
  </div>

  <div class="row g-3">
    <!-- Anggota Baru -->
    <div class="col-md-3 col-6">
      <div class="glass-card text-center py-4 h-100">
        <i class="bi bi-person-plus report-icon text-primary"></i>
        <div class="report-title">Anggota Baru</div>
        <div class="report-number"><?= count($newMembersToday) ?></div>
      </div>
    </div>

    <!-- Peminjaman -->
    <div class="col-md-3 col-6">
      <div class="glass-card text-center py-4 h-100">
        <i class="bi bi-arrow-down-circle report-icon text-success"></i>
        <div class="report-title">Peminjaman</div>
        <div class="report-number"><?= count($newLoansToday) ?></div>
      </div>
    </div>

    <!-- Pengembalian -->
    <div class="col-md-3 col-6">
      <div class="glass-card text-center py-4 h-100">
        <i class="bi bi-arrow-up-circle report-icon text-info"></i>
        <div class="report-title">Pengembalian</div>
        <div class="report-number"><?= count($newBookReturnsToday) ?></div>
      </div>
    </div>

    <!-- Jatuh Tempo -->
    <div class="col-md-3 col-6">
      <div class="glass-card text-center py-4 h-100">
        <i class="bi bi-exclamation-circle report-icon text-danger"></i>
        <div class="report-title">Jatuh Tempo</div>
        <div class="report-number"><?= count($returnDueToday) ?></div>
      </div>
    </div>
  </div>
</div>


<div class="row">
  <!-- OVERVIEW CHART -->
  <!-- Tambahkan link Bootstrap dan ApexCharts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<div class="row">
  <!-- OVERVIEW CHART -->
  <div class="col-lg-8 d-flex align-items-stretch mb-4">
    <div class="card w-100 shadow-lg border-0 rounded-4">
      <div class="card-body">
        <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
          <div>
            <h5 class="card-title fw-bold text-primary">
              📊 Ikhtisar 7 Hari Terakhir
            </h5>
            <p class="text-muted mb-0">Statistik performa terbaru</p>
          </div>
          <button class="btn btn-outline-primary btn-sm">Lihat Detail</button>
        </div>

        <!-- ✅ FIX: Tambahkan tinggi eksplisit untuk kontainer chart -->
        <div id="chart" class="mt-3" style="height: 300px;"></div>

      </div>
    </div>
  </div>

  <!-- STATISTIC BOXES -->
  <div class="col-lg-4">
    <div class="row g-3">
      <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 bg-success text-white p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-1">Total Pengunjung</h6>
              <h4 class="fw-bold">12.480</h4>
            </div>
            <i class="bi bi-people-fill fs-2"></i>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 bg-warning text-dark p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-1">Pesanan Baru</h6>
              <h4 class="fw-bold">1.240</h4>
            </div>
            <i class="bi bi-bag-check-fill fs-2"></i>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 bg-info text-white p-3">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="mb-1">Pelanggan Baru</h6>
              <h4 class="fw-bold">320</h4>
            </div>
            <i class="bi bi-person-plus-fill fs-2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ApexCharts Sample Data -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    var options = {
      chart: {
        type: 'area',
        height: 300,
        toolbar: { show: false }
      },
      colors: ['#0d6efd'],
      dataLabels: { enabled: false },
      stroke: { curve: 'smooth' },
      series: [{
        name: 'Kunjungan',
        data: [450, 650, 700, 800, 750, 900, 980]
      }],
      xaxis: {
        categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']
      },
      yaxis: {
        labels: {
          formatter: function (val) { return val.toFixed(0); }
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.3,
          stops: [0, 90, 100]
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  });
</script>

      <!-- FINE INCOME -->
     <!-- Total Pendapatan Denda (Modern Design) -->
<div class="col-lg-12 mb-4">
  <div class="card shadow-lg border-0 rounded-4 bg-light">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title fw-bold text-primary">
          <i class="bi bi-cash-coin me-2 text-success"></i> Total Pendapatan Denda
        </h5>
        <span class="badge bg-info-subtle text-info fs-6 fw-semibold">
          <?= $dateNow->toLocalizedString('MMMM Y'); ?>
        </span>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold text-dark mb-2">Rp<?= number_format($fineIncomeThisMonth['value'] ?? 0, 0, ',', '.'); ?></h2>
          <?php
          $thisMonth = $fineIncomeThisMonth['value'];
          $lastMonth = $fineIncomeLastMonth['value'];
          $percentage = (($thisMonth - $lastMonth == 0 || $lastMonth == 0)
            ? 0
            : round(($thisMonth - $lastMonth) / $lastMonth * 100));
          ?>
          <div class="d-flex align-items-center">
            <div class="me-2">
              <span class="rounded-circle d-flex align-items-center justify-content-center 
                <?= $percentage >= 0 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'; ?> px-2 py-1">
                <i class="bi <?= $percentage >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow'; ?>"></i>
              </span>
            </div>
            <div class="fs-5">
              <span class="fw-bold <?= $percentage >= 0 ? 'text-success' : 'text-danger'; ?>">
                <?= ($percentage >= 0 ? '+' : '') . $percentage; ?>%
              </span>
              <span class="text-muted">dari bulan sebelumnya</span>
            </div>
          </div>
        </div>
        <div>
          <div class="rounded-circle bg-success d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-wallet2 fs-3 text-white"></i>
          </div>
        </div>
      </div>

      <!-- Chart Placeholder -->
      <div id="fine" class="mt-4"></div>
    </div>
  </div>
</div>

      <!-- TOTAL ARREARS -->
      <!-- Total Tunggakan (Modern Design) -->
<div class="col-lg-12 mb-4">
  <div class="card shadow-lg border-0 rounded-4 bg-light">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="card-title fw-bold text-danger">
          <i class="bi bi-exclamation-octagon-fill me-2 text-danger"></i> Total Tunggakan
        </h5>
        <span class="badge bg-danger-subtle text-danger fs-6 fw-semibold">
          <?= "{$oldestFineDate->toLocalizedString('d MMM Y')} - {$dateNow->toLocalizedString('d MMM Y')}"; ?>
        </span>
      </div>

      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h2 class="fw-bold text-dark mb-2">Rp<?= number_format($totalArrears, 0, ',', '.'); ?></h2>
          <p class="text-muted mb-0 fs-6">Akumulasi sejak tanggal terlama</p>
        </div>
        <div>
          <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
            <i class="bi bi-exclamation-triangle fs-3 text-white"></i>
          </div>
        </div>
      </div>

      <!-- Chart Placeholder -->
      <div id="arrears" class="mt-4"></div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script>
  $(function() {
    // =====================================
    // Overview
    // =====================================
    const newMembersData = [
      <?php foreach ($newMembersOverview as $value) : ?>
        <?= "'{$value}', "; ?>
      <?php endforeach; ?>
    ].map((value => parseInt(value)));

    const loansData = [
      <?php foreach ($loansOverview as $value) : ?>
        <?= "'{$value}', "; ?>
      <?php endforeach; ?>
    ].map((value => parseInt(value)));

    const returnsData = [
      <?php foreach ($returnsOverview as $value) : ?>
        <?= "'{$value}', "; ?>
      <?php endforeach; ?>
    ].map((value => parseInt(value)));

    const highestValue = Math.max(
      Math.max(...newMembersData),
      Math.max(...loansData),
      Math.max(...returnsData)
    );

    var chart = {
      series: [{
          name: "Anggota baru",
          type: 'bar',
          data: newMembersData
        },
        {
          name: "Transaksi peminjaman",
          type: 'bar',
          data: loansData
        },
        {
          name: "Transaksi pengembalian",
          type: 'bar',
          data: returnsData
        },
      ],
      chart: {
        type: "bar",
        height: 400,
        offsetX: -15,
        toolbar: {
          show: true
        },
        foreColor: "#adb0bb",
        fontFamily: 'inherit',
        sparkline: {
          enabled: false
        },
      },
      plotOptions: {
        bar: {
          columnWidth: '80%',
          dataLabels: {
            position: 'top',
          }
        }
      },
      colors: ["#40dfb0", "#3849b9", "#db50c0"],
      markers: {
        size: 0
      },
      dataLabels: {
        enabled: false,
        offsetY: -17,
        style: {
          colors: ['#666666']
        },
      },
      legend: {
        show: true
      },
      grid: {
        borderColor: "rgba(0,0,0,0.1)",
        strokeDashArray: 3,
        xaxis: {
          lines: {
            show: false,
          },
        },
      },
      xaxis: {
        type: "category",
        categories: [
          <?php foreach ($lastWeekDateStringRange as $value) : ?>
            <?= "'{$value}', "; ?>
          <?php endforeach; ?>
        ],
        labels: {
          style: {
            cssClass: "fill-color"
          },
        },
      },
      yaxis: {
        show: true,
        min: 0,
        max: () => {
          const roundedHighestValue = (Math.ceil(highestValue / 10) * 10);

          if (roundedHighestValue <= 30) {
            return roundedHighestValue + 5;
          } else {
            return roundedHighestValue + 10;
          }
        },
        tickAmount: 5,
        labels: {
          style: {
            cssClass: "fill-color",
          },
        },
      },
      tooltip: {
        theme: "light"
      },
      responsive: [{
        breakpoint: 600,
        options: {
          plotOptions: {
            bar: {
              columnWidth: '100%',
            }
          },
          dataLabels: {
            enabled: false,
          },
        }
      }]
    };
    new ApexCharts(document.querySelector("#chart"), chart).render();

    // =====================================
    // FINES
    // =====================================
    var fines = {
      chart: {
        type: "area",
        height: 60,
        sparkline: {
          enabled: true,
        },
        group: "sparklines",
        fontFamily: "Plus Jakarta Sans', sans-serif",
        foreColor: "#49ca74",
      },
      series: [{
        name: "Denda terkumpul",
        color: "#49ca74",
        data: [<?= $fineIncomeLastMonth['value']; ?>, <?= $fineIncomeThisMonth['value']; ?>],
      }],
      xaxis: {
        type: "category",
        categories: ['<?= $fineIncomeLastMonth['month']; ?>', '<?= $fineIncomeThisMonth['month']; ?>'],
        labels: {
          style: {
            cssClass: "fill-color"
          },
        },
      },
      stroke: {
        curve: "smooth",
        width: 2,
      },
      fill: {
        colors: ["#f3feff"],
        type: "solid",
        opacity: 0.05,
      },
      markers: {
        size: 0,
      },
      tooltip: {
        theme: "dark",
        fixed: {
          enabled: true,
          position: "right",
        },
        x: {
          show: true,
        },
      },
    };
    new ApexCharts(document.querySelector("#fine"), fines).render();

    // =====================================
    // ARREARS
    // =====================================
    var arrears = {
      chart: {
        type: "area",
        height: 60,
        sparkline: {
          enabled: true,
        },
        group: "sparklines",
        fontFamily: "Plus Jakarta Sans', sans-serif",
        foreColor: "#ca495c",
      },
      series: [{
        name: "Total tunggakan (akumulasi)",
        color: "#ca495c",
        data: [
          <?php foreach ($arrears as $arrear) : ?>
            <?= "'{$arrear['arrear']}', "; ?>
          <?php endforeach; ?>
        ],
      }],
      xaxis: {
        type: "category",
        categories: [
          <?php foreach ($arrears as $arrear) : ?>
            <?= "'{$arrear['date']}', "; ?>
          <?php endforeach; ?>
        ],
        labels: {
          style: {
            cssClass: "fill-color"
          },
        },
      },
      stroke: {
        curve: "smooth",
        width: 2,
      },
      fill: {
        colors: ["#f3feff"],
        type: "solid",
        opacity: 0.05,
      },
      markers: {
        size: 0,
      },
      tooltip: {
        theme: "dark",
        fixed: {
          enabled: true,
          position: "right",
        },
        x: {
          show: true,
        },
      },
    };
    new ApexCharts(document.querySelector("#arrears"), arrears).render();
  })
</script>
<?= $this->endSection() ?>