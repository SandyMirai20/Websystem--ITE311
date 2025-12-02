<?= $this->extend('templates/header') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Manage Users</h1>
        <a href="<?= site_url('admin/users/create') ?>" class="btn btn-primary btn-sm">Add User</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= esc($u['id']) ?></td>
                        <td><?= esc($u['name']) ?></td>
                        <td><?= esc($u['email']) ?></td>
                        <td>
                            <form action="<?= site_url('admin/users/'.$u['id'].'/change-role') ?>" method="post" class="d-flex gap-2 align-items-center">
                                <?= csrf_field() ?>
                                <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <?php foreach (['admin','teacher','student'] as $r): ?>
                                        <option value="<?= $r ?>" <?= $u['role']===$r?'selected':'' ?>><?= ucfirst($r) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </form>
                        </td>
                        <td>
                            <?php if ((int)($u['is_active'] ?? 1) === 1): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary" href="<?= site_url('admin/users/'.$u['id'].'/edit') ?>">Edit</a>

                            <?php if ((int)($u['is_active'] ?? 1) === 1): ?>
                                <form action="<?= site_url('admin/users/'.$u['id'].'/deactivate') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-warning">Deactivate</button>
                                </form>
                            <?php else: ?>
                                <form action="<?= site_url('admin/users/'.$u['id'].'/activate') ?>" method="post" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-success">Activate</button>
                                </form>
                            <?php endif; ?>

                            <form action="<?= site_url('admin/users/'.$u['id'].'/delete') ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this user?');">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
