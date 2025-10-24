<?php
/** @var array $courses */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>My Enrolled Courses<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">My Enrolled Courses</h3>
        <a href="<?= base_url('student/courses') ?>" class="btn btn-outline-primary">
            <i class="fas fa-plus me-1"></i> Browse More Courses
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

    <?php if (empty($courses)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            You are not enrolled in any courses yet.
            <a href="<?= base_url('student/courses') ?>" class="alert-link">Browse available courses</a> to get started.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="card-title fw-bold mb-2">
                                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                                        <?= esc($course['course']) ?>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        <i class="fas fa-user-tie me-1"></i>
                                        <?= esc($course['teacher_name'] ?? 'No Teacher Assigned') ?>
                                    </h6>
                                    <?php if (!empty($course['description'])): ?>
                                        <p class="card-text text-muted small">
                                            <?= esc($course['description']) ?>
                                        </p>
                                    <?php endif; ?>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-light text-dark">
                                            <i class="far fa-calendar-alt me-1"></i>
                                            Enrolled: <?= date('M d, Y', strtotime($course['enrolled_at'])) ?>
                                        </span>
                                        <?php
                                        $materialsCount = $course['materials_count'] ?? 0;
                                        if ($materialsCount > 0): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-file-alt me-1"></i>
                                                <?= $materialsCount ?> Materials
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted">
                                                <i class="fas fa-file-alt me-1"></i>
                                                No Materials Yet
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('student/courses/' . $course['id']) ?>" class="btn btn-primary btn-sm flex-grow-1">
                                    <i class="fas fa-eye me-1"></i> View Materials
                                </a>
                                <?php if ($materialsCount > 0): ?>
                                    <span class="btn btn-sm btn-outline-info" title="Materials Available">
                                        <i class="fas fa-download"></i>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>
