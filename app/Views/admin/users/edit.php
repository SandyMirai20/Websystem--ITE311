<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<?php /** @var array $user */ $errors = session('errors') ?? []; ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Edit User</h1>
        <a href="<?= site_url('admin/users') ?>" class="btn btn-secondary btn-sm">Back</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form action="<?= site_url('admin/users/'.$user['id'].'/update') ?>" method="post" class="row g-3">
                <?= csrf_field() ?>
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="<?= old('name', $user['name']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">New Password (optional)</label>
                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <?php foreach (['admin','teacher','student'] as $r): ?>
                            <option value="<?= $r ?>" <?= old('role', $user['role'])===$r?'selected':'' ?>><?= ucfirst($r) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>

            <hr>
            <h5>Reset Password</h5>
            <form action="<?= site_url('admin/users/'.$user['id'].'/reset-password') ?>" method="post" class="row g-2">
                <?= csrf_field() ?>
                <div class="col-md-6">
                    <input type="password" name="password" class="form-control" placeholder="New password" required>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-warning">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
