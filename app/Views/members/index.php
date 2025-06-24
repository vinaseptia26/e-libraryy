<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>👑 Data Anggota </title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<meta name="csrf-token" content="<?= csrf_hash(); ?>">

<style>
  body {
    background: linear-gradient(135deg, #e3f2fd, #f1f8ff);
    font-family: 'Poppins', sans-serif;
  }

  .header-title {
    background: linear-gradient(135deg, #4e73df, #224abe);
    color: #fff;
    padding: 1.8rem 2.5rem;
    border-radius: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
  }

  .header-title h2 {
    margin: 0;
    font-size: 2.2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideIn 0.6s ease;
  }

  .table {
    background: #fff;
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: 0 4px 35px rgba(0, 0, 0, 0.1);
  }

  .table th {
    background-color: #0047ab;
    color: white;
    font-weight: 600;
    text-align: center;
    font-size: 0.95rem;
  }

  .table td {
    vertical-align: middle;
    font-size: 0.9rem;
  }

  .table-hover tbody tr:hover {
    background-color: #eef4ff;
    transition: background-color 0.3s ease;
  }

  .btn-action a,
  .btn-action button {
    min-width: 80px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }

  .badge {
    font-size: 0.8rem;
    padding: 0.5em 0.75em;
    border-radius: 12px;
  }

  .badge.bg-info {
    background: linear-gradient(135deg, #90e0ef, #00b4d8);
    color: #023e8a;
  }

  .badge.bg-warning {
    background: linear-gradient(135deg, #ffdd99, #ffb347);
    color: #7a4f01;
  }

  .form-control,
  .btn {
    border-radius: 0.75rem;
  }

  .alert {
    animation: fadeIn 0.5s ease-in-out;
    border-radius: 0.75rem;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  @keyframes slideIn {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
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

<div class="header-title mb-4">
  <h2><i class="bi bi-people-fill"></i> Data Anggota</h2>
  <div class="d-flex gap-2 flex-column flex-md-row">
    <form class="input-group input-group-sm" method="get">
      <input type="text" class="form-control shadow-sm" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari anggota...">
      <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
    </form>
    <a href="<?= base_url('admin/members/new'); ?>" class="btn btn-warning d-flex align-items-center shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Tambah
    </a>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-hover align-middle text-nowrap">
    <thead>
      <tr class="text-center">
        <th>#</th>
        <th>Nama Lengkap</th>
        <th>Email</th>
        <th>Telepon</th>
        <th>Alamat</th>
        <th>Jenis Kelamin</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1 + ($itemPerPage * ($currentPage - 1)); ?>
      <?php if (empty($members)) : ?>
        <tr>
          <td colspan="7" class="text-center text-muted"><i>📭 Tidak ada data anggota</i></td>
        </tr>
      <?php else : ?>
        <?php foreach ($members as $member) : ?>
          <tr>
            <td class="text-center fw-semibold text-primary-emphasis">#<?= $i++; ?></td>
            <td>
              <a href="<?= base_url("admin/members/{$member['uid']}"); ?>" class="fw-semibold text-decoration-none text-dark">
                <?= esc($member['first_name'] . ' ' . $member['last_name']); ?>
              </a>
            </td>
            <td><?= esc($member['email']); ?></td>
            <td><?= esc($member['phone']); ?></td>
            <td><?= esc($member['address']); ?></td>
            <td class="text-center">
              <span class="badge bg-<?= $member['gender'] == 'Laki-laki' ? 'info' : 'warning'; ?>">
                <?= esc($member['gender']); ?>
              </span>
            </td>
            <td class="text-center">
              <div class="btn-action d-flex justify-content-center gap-2">
                <a href="<?= base_url("admin/members/{$member['uid']}/edit"); ?>" class="btn btn-sm btn-outline-primary">
                  <i class="bi bi-pencil-fill"></i> Edit
                </a>
                <button type="button" class="btn btn-sm btn-outline-danger btn-delete-member" data-uid="<?= $member['uid']; ?>">
                  <i class="bi bi-trash-fill"></i> Hapus
                </button>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<div class="mt-3">
  <?= $pager->links('members', 'my_pager'); ?>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('.btn-delete-member').click(function () {
      const uid = $(this).data('uid');
      const csrfToken = $('meta[name="csrf-token"]').attr('content');

      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data anggota ini akan dihapus permanen.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e74c3c',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `<?= base_url('admin/members') ?>/${uid}`,
            method: 'POST',
            data: {
              _method: 'DELETE',
              <?= csrf_token() ?>: csrfToken
            },
            success: function () {
              Swal.fire('Terhapus!', 'Data anggota berhasil dihapus.', 'success').then(() => location.reload());
            },
            error: function () {
              Swal.fire('Gagal', 'Data gagal dihapus.', 'error');
            }
          });
        }
      });
    });
  });
</script>

<?= $this->endSection() ?>