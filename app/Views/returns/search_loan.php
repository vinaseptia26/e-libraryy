<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Pengembalian Baru</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/returns'); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-12 col-md-6">
        <h5 class="card-title fw-semibold">Scan / Upload QR Peminjaman</h5>
        <div id="reader" class="border border-2 border-primary my-3" style="width: 300px; height: 300px; border-radius: 10px;"></div>
        <input type="file" id="qr-upload" accept="image/*" class="form-control mt-2 mb-2">
        <small class="text-muted">📷 Scan atau upload gambar QR Code di sini</small><br>
        <button class="btn btn-secondary mt-3" id="resumeBtn" style="display: none;" onclick="startCameraScan()">Scan Ulang Kamera</button>
      </div>

      <div class="col-12 col-md-6">
        <h5 class="card-title fw-semibold mb-4">Atau cari manual</h5>
        <div class="mb-3">
          <label for="search" class="form-label">Cari UID, nama, email, judul buku</label>
          <input type="text" class="form-control" id="search" placeholder="'Vina', 'email@contoh.com', 'Judul Buku'">
        </div>
        <button class="btn btn-primary" onclick="getLoan(document.querySelector('#search').value)">Cari</button>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mt-4">
        <div id="loanResult">
          <p class="text-center text-muted">📄 Data peminjaman akan muncul di sini</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
  const qrRegionId = "reader";
  const qrCodeScanner = new Html5Qrcode(qrRegionId);

  function getLoan(param) {
    if (!param) return alert("Masukkan data pencarian!");
    jQuery.ajax({
      url: "<?= base_url('admin/returns/new/search'); ?>",
      type: 'get',
      data: { 'param': param },
      beforeSend: function () {
        $('#loanResult').html('<p class="text-center">🔄 Mencari data peminjaman...</p>');
      },
      success: function(response) {
        $('#loanResult').html(response);
        $('html, body').animate({ scrollTop: $("#loanResult").offset().top }, 500);
      },
      error: function(xhr, status, thrown) {
        $('#loanResult').html('<div class="alert alert-danger">❌ Gagal mengambil data.</div>');
      }
    });
  }

  function startCameraScan() {
    qrCodeScanner.start(
      { facingMode: "environment" },
      { fps: 15, qrbox: { width: 250, height: 250 } },
      (decodedText, decodedResult) => {
        alert("✅ QR terbaca: " + decodedText);
        qrCodeScanner.stop();
        document.querySelector('#resumeBtn').style.display = 'block';
        getLoan(decodedText);
      },
      (errorMessage) => {
        console.log("🔍 Gagal scan QR: ", errorMessage);
      }
    ).catch(err => {
      alert("🚫 Tidak bisa membuka kamera: " + err);
    });
  }

  // Jalankan scan kamera saat halaman dibuka
  startCameraScan();

  // Baca QR dari file (upload)
  document.querySelector("#qr-upload").addEventListener("change", function(e) {
    if (e.target.files.length == 0) return;

    const file = e.target.files[0];
    qrCodeScanner.scanFile(file, true)
      .then(decodedText => {
        alert("✅ QR dari gambar terbaca: " + decodedText);
        getLoan(decodedText);
      })
      .catch(err => {
        console.error("❌ Gagal membaca QR dari gambar: ", err);
        alert("Gagal membaca QR. Pastikan gambarnya jelas dan format PNG/JPG.");
      });
  });
</script>
<?= $this->endSection() ?>
