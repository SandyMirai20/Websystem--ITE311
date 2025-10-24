<?php
/** @var array $course */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Upload Course Material<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Upload Course Material</h3>
        <a href="<?= base_url('admin/courses/show/' . $course['id']) ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Course
        </a>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($errors = session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                <?php foreach ($errors as $e): ?>
                    <li><?= esc($e) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <h5 class="card-title">Course: <?= esc($course['course']) ?></h5>
                <?php if ($course['description']): ?>
                    <p class="text-muted mb-0">Description: <?= esc($course['description']) ?></p>
                <?php endif; ?>
                <small class="text-muted">Teacher: <?= esc($course['teacher_name'] ?? 'N/A') ?></small>
            </div>

            <form method="post" action="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="material_file" class="form-label">Select File</label>
                    <input type="file" class="form-control" id="material_file" name="material_file" required>
                    <div class="form-text">
                        Allowed file types: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, ZIP<br>
                        Maximum file size: 10MB
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-1"></i> Upload Material
                    </button>
                    <a href="<?= base_url('admin/courses/show/' . $course['id']) ?>" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
