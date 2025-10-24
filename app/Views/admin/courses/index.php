<?php
/** @var array $courses */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Manage Courses<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Courses</h3>
        <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> New Course
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Course</th>
                            <th>Teacher</th>
                            <th style="width: 180px;">Created</th>
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $c): ?>
                                <tr>
                                    <td class="text-muted">#<?= esc($c['id']) ?></td>
                                    <td>
                                        <div class="fw-semibold">
                                            <a href="<?= base_url('admin/courses/show/' . $c['id']) ?>" class="text-decoration-none">
                                                <?= esc($c['course']) ?>
                                            </a>
                                        </div>
                                        <div class="small text-muted">
                                            <?php
                                            // Get materials count for this course
                                            $materialModel = new \App\Models\MaterialModel();
                                            $materialsCount = $materialModel->where('course_id', $c['id'])->countAllResults();
                                            ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-file-alt me-1"></i>
                                                <?= $materialsCount ?> Materials
                                            </span>
                                            <?= esc($c['description'] ?? '') ?>
                                        </div>
                                    </td>
                                    <td><?= esc($c['teacher_name'] ?? '—') ?></td>
                                    <td><?= !empty($c['created_at']) ? date('M j, Y g:i A', strtotime($c['created_at'])) : '—' ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/courses/show/' . $c['id']) ?>" class="btn btn-sm btn-outline-primary" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/course/' . $c['id'] . '/upload') ?>" class="btn btn-sm btn-outline-success" title="Upload Materials">
                                                <i class="fas fa-upload"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No courses yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
