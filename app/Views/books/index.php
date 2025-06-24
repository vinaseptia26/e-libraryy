<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>📚 Daftar Buku Premium</title>

<!-- Bootstrap, SweetAlert, Icons, Google Fonts -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
  body {
    background: linear-gradient(135deg, #f0f4ff, #dfeaff);
    font-family: 'Poppins', sans-serif;
    color: #333;
  }

  .card {
    border-radius: 20px;
    border: none;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(8px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
    padding: 20px;
  }

  h4 {
    font-weight: 700;
    color: #0047ab;
  }

  .btn-gradient {
    background: linear-gradient(to right, #0047ab, #007bff);
    color: white;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 71, 171, 0.3);
  }

  .btn-gradient:hover {
    background: linear-gradient(to right, #002b72, #0056b3);
    box-shadow: 0 6px 16px rgba(0, 71, 171, 0.5);
  }

  .btn-danger {
    background: linear-gradient(to right, #e74c3c, #c0392b);
    color: white;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-danger:hover {
    background: linear-gradient(to right, #96281b, #c0392b);
    box-shadow: 0 6px 16px rgba(192, 57, 43, 0.4);
  }

  .table thead th {
    background-color: #0047ab;
    color: white;
    text-align: center;
    font-weight: 600;
    font-size: 0.95rem;
  }

  .table tbody td {
    background-color: white;
    text-align: center;
    vertical-align: middle;
    font-size: 0.93rem;
  }

  .table td img {
    height: 90px;
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .book-title {
    font-weight: 600;
    font-size: 1rem;
    color: #0047ab;
    text-decoration: none;
  }

  .book-title:hover {
    color: #002b72;
    text-decoration: underline;
  }

  .pagination .page-link {
    border-radius: 6px;
    color: #0047ab;
  }

  .pagination .page-item.active .page-link {
    background-color: #0047ab;
    color: white;
    border-color: #0047ab;
  }

  .input-group .form-control {
    border-radius: 10px 0 0 10px;
    border: 1px solid #ced4da;
  }

  .input-group .btn {
    border-radius: 0 10px 10px 0;
  }

  .table-hover tbody tr:hover {
    background-color: #eef4ff;
    transition: background-color 0.3s ease;
  }

  @media (max-width: 768px) {
    .table td img {
      height: 70px;
    }
    .book-title {
      font-size: 0.9rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <script>
    Swal.fire({
      toast: true,
      position: 'top-end',
      icon: '<?= session()->getFlashdata('error') ? 'error' : 'success' ?>',
      title: '<?= session()->getFlashdata('msg') ?>',
      showConfirmButton: false,
      timer: 3000
    });
  </script>
<?php endif; ?>

<div class="card p-4 mb-5">
  <div class="card-body">
    <div class="row mb-4 align-items-center">
      <div class="col-md-6">
        <h4 class="fw-bold">
          <?php if (isset($category)) : ?>
            📂 Buku Kategori <span class="text-primary"><?= esc($category); ?></span>
          <?php elseif (isset($rack)) : ?>
            🗂️ Buku Rak <span class="text-primary"><?= esc($rack); ?></span>
          <?php else : ?>
            📚 Daftar Koleksi <span class="text-primary">Buku</span>
          <?php endif; ?>
        </h4>
      </div>
      <div class="col-md-6 mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        <form method="get" class="d-flex flex-grow-1 me-2">
          <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Cari buku..." value="<?= esc($search ?? ''); ?>">
            <button class="btn btn-outline-primary" type="submit">
              <i class="bi bi-search"></i> Cari
            </button>
          </div>
        </form>
        <a href="<?= base_url('admin/books/new'); ?>" class="btn btn-gradient d-flex align-items-center">
          <i class="bi bi-plus-circle me-1"></i> Tambah Buku
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-hover shadow-sm">
        <thead>
          <tr>
            <th>#</th>
            <th>Sampul</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Rak</th>
            <th>Jumlah</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
          <?php if (empty($books)) : ?>
            <tr>
              <td colspan="7" class="text-center text-muted fw-bold">📭 Tidak ada data</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($books as $book) : ?>
            <?php
              $coverPath = BOOK_COVER_URI . $book['book_cover'];
              $imageURL = (!empty($book['book_cover']) && file_exists($coverPath)) ? base_url($coverPath) : base_url(BOOK_COVER_URI . DEFAULT_BOOK_COVER);
            ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><img src="<?= $imageURL ?>" alt="<?= esc($book['title']) ?>"></td>
              <td class="text-start">
                <a href="<?= base_url("admin/books/{$book['slug']}"); ?>" class="book-title">
                  <?= esc("{$book['title']} ({$book['year']})") ?>
                </a><br>
                <small class="text-muted">Penulis: <?= esc($book['author']) ?></small>
              </td>
              <td><?= esc($book['category']) ?></td>
              <td><?= esc($book['rack']) ?></td>
              <td><?= esc($book['quantity']) ?></td>
              <td>
                <a href="<?= base_url("admin/books/{$book['slug']}/edit"); ?>" class="btn btn-gradient w-100 mb-2">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <form class="form-delete" data-title="<?= esc($book['title']) ?>" action="<?= base_url("admin/books/{$book['slug']}"); ?>" method="post">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-danger w-100">
                    <i class="bi bi-trash"></i> Hapus
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
      <?= $pager->links('books', 'my_pager'); ?>
    </div>
  </div>
</div>

<!-- Konfirmasi Hapus Buku -->
<script>
  document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const title = this.dataset.title;
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        html: `"${title}" akan dihapus dari daftar.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  });
</script>

<?= $this->endSection() ?>
