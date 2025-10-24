<?php
/** @var array $course */
/** @var array $materials */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>Course Materials<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('student/enrolled-courses') ?>">
                            <i class="fas fa-arrow-left me-1"></i> My Courses
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= esc($course['course']) ?>
                    </li>
                </ol>
            </nav>
            <h3 class="mb-0">
                <i class="fas fa-graduation-cap text-primary me-2"></i>
                <?= esc($course['course']) ?>
            </h3>
        </div>
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

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle text-primary me-2"></i>
                        Course Information
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Course:</strong> <?= esc($course['course']) ?></p>
                            <p><strong>Teacher:</strong> <?= esc($course['teacher_name'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6">
                            <?php if ($course['teacher_email']): ?>
                                <p><strong>Email:</strong>
                                    <a href="mailto:<?= esc($course['teacher_email']) ?>">
                                        <?= esc($course['teacher_email']) ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <p><strong>Course Created:</strong> <?= date('M d, Y', strtotime($course['created_at'])) ?></p>
                        </div>
                    </div>
                    <?php if (!empty($course['description'])): ?>
                        <div class="mt-3">
                            <strong>Description:</strong>
                            <p class="text-muted mt-2">
                                <?= nl2br(esc($course['description'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-download text-primary me-2"></i>
                        Course Materials
                        <span class="badge bg-primary ms-2">
                            <?= count($materials) ?> files
                        </span>
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (empty($materials)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted mb-2">No materials available yet</h6>
                            <p class="text-muted small mb-3">Your teacher hasn't uploaded any materials for this course yet.</p>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-1"></i>
                                Check back later or contact your teacher for course materials.
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-file-alt me-1"></i>
                                    <?= count($materials) ?> materials available for download
                                </small>
                                <span class="badge bg-success">
                                    <i class="fas fa-download me-1"></i>
                                    Ready to Download
                                </span>
                            </div>
                        </div>
                        <div class="list-group list-group-flush">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item px-0 border-bottom">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center mb-1">
                                                <?php
                                                $extension = pathinfo($material['file_name'], PATHINFO_EXTENSION);
                                                $fileIcon = 'fas fa-file';
                                                switch(strtolower($extension)) {
                                                    case 'pdf':
                                                        $fileIcon = 'fas fa-file-pdf text-danger';
                                                        break;
                                                    case 'doc':
                                                    case 'docx':
                                                        $fileIcon = 'fas fa-file-word text-primary';
                                                        break;
                                                    case 'ppt':
                                                    case 'pptx':
                                                        $fileIcon = 'fas fa-file-powerpoint text-warning';
                                                        break;
                                                    case 'xls':
                                                    case 'xlsx':
                                                        $fileIcon = 'fas fa-file-excel text-success';
                                                        break;
                                                    case 'zip':
                                                    case 'rar':
                                                        $fileIcon = 'fas fa-file-archive text-secondary';
                                                        break;
                                                }
                                                ?>
                                                <i class="<?= $fileIcon ?> me-2"></i>
                                                <h6 class="mb-0 fw-semibold">
                                                    <?= esc($material['file_name']) ?>
                                                </h6>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    Uploaded: <?= date('M j, Y', strtotime($material['created_at'])) ?>
                                                </small>
                                                <small class="text-muted">
                                                    <i class="fas fa-file me-1"></i>
                                                    <?= strtoupper($extension) ?> • Ready for download
                                                </small>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <a href="<?= base_url('materials/download/' . $material['id']) ?>"
                                               class="btn btn-success btn-sm"
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>
                                                Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
