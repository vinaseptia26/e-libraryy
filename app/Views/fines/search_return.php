<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
  <title>Cari Data Peminjaman</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
  <a href="<?= base_url('admin/fines'); ?>" class="btn btn-outline-primary mb-4">
    <i class="bi bi-arrow-left"></i> Kembali
  </a>

  <?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>

  <div class="card shadow-sm">
    <div class="card-body">
      <div class="row g-4">
        <!-- Scan QR via Kamera -->
        <div class="col-12 col-md-6">
          <h5 class="fw-bold mb-3">Scan QR Peminjaman / Anggota (Kamera)</h5>
          <div id="reader" class="border border-2 border-primary rounded p-2 mb-3" style="max-width: 100%; min-height: 400px;"></div>
          <button class="btn btn-primary" style="display: none;" id="resumeBtn" onclick="html5QrcodeScanner.resume(); this.style.display = 'none';">
            <i class="bi bi-camera-video"></i> Scan Ulang
          </button>
        </div>

        <!-- Cari Manual atau Gambar -->
        <div class="col-12 col-md-6">
          <h5 class="fw-bold mb-3">Cari Manual atau Upload Gambar QR</h5>

          <!-- Manual -->
          <div class="mb-3">
            <label for="search" class="form-label">Cari berdasarkan UID, nama, email, atau judul buku</label>
            <input type="text" class="form-control" id="search" name="search" placeholder="Contoh: 'Vina', 'xibox@gmail.com', 'Judul Buku'">
          </div>
          <button class="btn btn-primary mb-3" onclick="getReturns(document.querySelector('#search').value)">
            <i class="bi bi-search"></i> Cari Manual
          </button>

          <hr class="my-4">

          <!-- Upload Gambar QR -->
          <h6 class="fw-bold">Atau Pilih Gambar QR</h6>
          <input type="file" accept="image/*" class="form-control mb-2" id="qrImageInput">
          <div id="imageScanResult" class="text-muted small"></div>
        </div>
      </div>

      <!-- Hasil pencarian -->
      <div class="row mt-5">
        <div class="col-12">
          <div id="returnsResult" class="p-3 border rounded bg-light">
            <p class="text-center text-muted mb-0">Data peminjaman akan tampil di sini setelah scan atau pencarian.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- html5-qrcode dan jsQR -->
<script src="<?= base_url("assets/libs/html5-qrcode/html5-qrcode.min.js") ?>"></script>
<script src="https://unpkg.com/jsqr/dist/jsQR.js"></script>

<script>
  function getReturns(param) {
    if (!param) {
      alert("Masukkan kata kunci pencarian terlebih dahulu!");
      return;
    }

    $.ajax({
      url: "<?= base_url('admin/fines/returns/search'); ?>",
      type: 'GET',
      data: { 'param': param },
      success: function(response) {
        $('#returnsResult').html(response);
        $('html, body').animate({
          scrollTop: $("#returnsResult").offset().top
        }, 500);
      },
      error: function(xhr) {
        console.error(xhr);
        $('#returnsResult').html("<p class='text-danger'>Terjadi kesalahan saat memuat data.</p>");
      }
    });
  }

  // Inisialisasi html5-qrcode kamera
  const html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    {
      formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
    },
    {
      fps: 30,
      qrbox: { width: 250, height: 250 }
    },
    false
  );

  function onScanSuccess(decodedText, decodedResult) {
    console.log(`Scanned: ${decodedText}`);
    html5QrcodeScanner.pause(true);
    document.querySelector('#resumeBtn').style.display = 'block';

    // Simpan hasil QR
    $.ajax({
      url: "<?= base_url('admin/fines/save-scan'); ?>",
      type: "POST",
      data: { code: decodedText },
      success: function(res) {
        console.log("QR disimpan:", res);
      },
      error: function(err) {
        console.error("Gagal simpan QR:", err);
      }
    });

    getReturns(decodedText);
  }

  function onScanFailure(error) {
    // Biarkan error di-skip
  }

  html5QrcodeScanner.render(onScanSuccess, onScanFailure);

  // Tambahkan styling tombol scanner
  setTimeout(() => {
    const buttons = document.querySelectorAll('#reader button');
    buttons.forEach(btn => btn.classList.add('btn', 'btn-primary', 'mb-2'));
  }, 3000);

  // === [ Scan QR dari Gambar ] ===
  document.getElementById('qrImageInput').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
      const img = new Image();
      img.onload = function () {
        const canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, img.width, img.height);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const code = jsQR(imageData.data, canvas.width, canvas.height);

        if (code) {
          document.getElementById('imageScanResult').innerHTML = `<span class="text-success">QR terbaca: ${code.data}</span>`;
          getReturns(code.data);

          // Simpan hasil QR dari gambar
          $.ajax({
            url: "<?= base_url('admin/fines/save-scan'); ?>",
            type: "POST",
            data: { code: code.data },
            success: function(res) {
              console.log("QR disimpan:", res);
            },
            error: function(err) {
              console.error("Gagal simpan QR:", err);
            }
          });

        } else {
          document.getElementById('imageScanResult').innerHTML = `<span class="text-danger">Gagal membaca QR dari gambar.</span>`;
        }
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  });
</script>
<?= $this->endSection() ?>
