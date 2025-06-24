<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>📝 Edit Anggota</title>

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Premium Custom CSS -->
<style>
  body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(120deg, #f1f8ff, #e3f2fd);
    color: #333;
  }

  .container-custom {
    max-width: 850px;
    margin: auto;
    padding: 2rem 1rem;
  }

  .card {
    border-radius: 1.5rem;
    border: none;
    padding: 2rem;
    background-color: #ffffff;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
  }

  .card-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #0047ab;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 1.2rem;
  }

  .form-label {
    font-weight: 600;
    color: #224abe;
  }

  .form-control,
  textarea {
    border-radius: 0.75rem;
    font-size: 0.95rem;
    transition: border-color 0.3s;
  }

  .form-control:focus,
  textarea:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.2);
  }

  textarea {
    min-height: 120px;
  }

  .btn-primary {
    background: linear-gradient(to right, #0047ab, #007bff);
    border: none;
    font-weight: 600;
    color: #fff;
    box-shadow: 0 6px 16px rgba(0, 71, 171, 0.4);
    border-radius: 0.75rem;
    transition: all 0.3s ease;
  }

  .btn-primary:hover {
    background: linear-gradient(to right, #003c8f, #005dc0);
    box-shadow: 0 8px 20px rgba(0, 71, 171, 0.6);
  }

  .btn-outline-primary {
    border-radius: 0.75rem;
    font-weight: 500;
  }

  .form-check-label {
    margin-left: 4px;
  }

  .invalid-feedback {
    font-size: 0.85rem;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container container-custom">
  <a href="<?= previous_url() ?>" class="btn btn-outline-primary mb-4">
    <i class="bi bi-arrow-left-circle-fill"></i> Kembali
  </a>

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

  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><i class="bi bi-pencil-square"></i> Edit Data Anggota</h5>
      <form action="<?= base_url('admin/members/' . $member['uid']); ?>" method="post">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="PUT">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="first_name" class="form-label"><i class="bi bi-person-fill"></i> Nama Depan</label>
            <input type="text" class="form-control <?= $validation->hasError('first_name') ? 'is-invalid' : '' ?>" id="first_name" name="first_name" value="<?= $oldInput['first_name'] ?? $member['first_name'] ?? '' ?>" placeholder="John" required>
            <div class="invalid-feedback"><?= $validation->getError('first_name') ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="last_name" class="form-label"><i class="bi bi-person"></i> Nama Belakang</label>
            <input type="text" class="form-control <?= $validation->hasError('last_name') ? 'is-invalid' : '' ?>" id="last_name" name="last_name" value="<?= $oldInput['last_name'] ?? $member['last_name'] ?? '' ?>">
            <div class="invalid-feedback"><?= $validation->getError('last_name') ?></div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="email" class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
            <input type="email" class="form-control <?= $validation->hasError('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= $oldInput['email'] ?? $member['email'] ?? '' ?>" placeholder="example@mail.com" required>
            <div class="invalid-feedback"><?= $validation->getError('email') ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label for="phone" class="form-label"><i class="bi bi-telephone-fill"></i> No. Telepon</label>
            <input type="tel" class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>" id="phone" name="phone" value="<?= $oldInput['phone'] ?? $member['phone'] ?? '' ?>" placeholder="+62812..." required>
            <div class="invalid-feedback"><?= $validation->getError('phone') ?></div>
          </div>
        </div>

        <div class="mb-3">
          <label for="address" class="form-label"><i class="bi bi-geo-alt-fill"></i> Alamat</label>
          <textarea class="form-control <?= $validation->hasError('address') ? 'is-invalid' : '' ?>" id="address" name="address" required><?= $oldInput['address'] ?? $member['address'] ?? '' ?></textarea>
          <div class="invalid-feedback"><?= $validation->getError('address') ?></div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="date_of_birth" class="form-label"><i class="bi bi-calendar2-date-fill"></i> Tanggal Lahir</label>
            <input type="date" class="form-control <?= $validation->hasError('date_of_birth') ? 'is-invalid' : '' ?>" id="date_of_birth" name="date_of_birth" value="<?= $oldInput['date_of_birth'] ?? $member['date_of_birth'] ?? '' ?>" required>
            <div class="invalid-feedback"><?= $validation->getError('date_of_birth') ?></div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label"><i class="bi bi-gender-ambiguous"></i> Jenis Kelamin</label>
            <?php $gender = $oldInput['gender'] ?? $member['gender'] ?? ''; ?>
            <div class="mt-2">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="male" name="gender" value="1" <?= ($gender == '1' || $gender == 'Male') ? 'checked' : '' ?> required>
                <label class="form-check-label" for="male"><i class="bi bi-gender-male"></i> Laki-laki</label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="female" name="gender" value="2" <?= ($gender == '2' || $gender == 'Female') ? 'checked' : '' ?> required>
                <label class="form-check-label" for="female"><i class="bi bi-gender-female"></i> Perempuan</label>
              </div>
            </div>
            <div class="invalid-feedback d-block"><?= $validation->getError('gender') ?></div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4 w-100">
          <i class="bi bi-save2-fill"></i> Simpan Perubahan
        </button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
