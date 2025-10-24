<?php
/** @var array $teachers */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Create Course<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Create Course</h3>
        <div>
            <button type="button" class="btn btn-info me-2" data-bs-toggle="collapse" data-bs-target="#uploadInfo" aria-expanded="false">
                <i class="fas fa-upload me-1"></i> Materials Upload
            </button>
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
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
            <form method="post" action="<?= base_url('admin/courses') ?>">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="course" class="form-label">Course</label>
                    <input type="text" class="form-control" id="course" name="course" value="<?= esc(old('course')) ?>" required minlength="3" maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="teacher_id" class="form-label">Assign Teacher</label>
                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                        <option value="" disabled <?= old('teacher_id') ? '' : 'selected' ?>>Select a teacher</option>
                        <?php foreach ($teachers as $t): ?>
                            <option value="<?= (int)$t['id'] ?>" <?= old('teacher_id') == $t['id'] ? 'selected' : '' ?>>
                                <?= esc($t['name'] . ' (' . $t['email'] . ')') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description (optional)</label>
                    <textarea class="form-control" id="description" name="description" rows="4" maxlength="1000" placeholder="Brief description of the course..."><?= esc(old('description')) ?></textarea>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Note:</strong> After creating the course, you'll be redirected to the course details page where you can immediately upload materials for your students.
                </div>

                <div class="collapse" id="uploadInfo">
                    <div class="card border-info mb-3">
                        <div class="card-body text-center">
                            <i class="fas fa-upload fa-2x text-info mb-2"></i>
                            <h6 class="text-info">Materials Upload Available</h6>
                            <p class="small text-muted mb-2">After saving this course, you can upload:</p>
                            <div class="row text-center">
                                <div class="col-6">
                                    <i class="fas fa-file-pdf text-danger"></i>
                                    <small class="d-block">PDF Files</small>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-file-powerpoint text-warning"></i>
                                    <small class="d-block">Presentations</small>
                                </div>
                            </div>
                            <div class="row text-center mt-2">
                                <div class="col-6">
                                    <i class="fas fa-file-word text-primary"></i>
                                    <small class="d-block">Documents</small>
                                </div>
                                <div class="col-6">
                                    <i class="fas fa-file-archive text-secondary"></i>
                                    <small class="d-block">ZIP Files</small>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-info mt-2" data-bs-toggle="collapse" data-bs-target="#uploadInfo">
                                <i class="fas fa-times me-1"></i> Close
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="submit" value="1" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <a href="<?= base_url('admin/courses') ?>" class="btn btn-light">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
