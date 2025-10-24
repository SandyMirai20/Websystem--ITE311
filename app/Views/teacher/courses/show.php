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
                        <a href="<?= base_url('teacher/courses') ?>">
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
        <a href="<?= base_url('teacher/course/' . $course['id'] . '/upload') ?>" class="btn btn-primary">
            <i class="fas fa-upload me-1"></i> Upload Material
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
                            <p><strong>Created:</strong> <?= date('M d, Y', strtotime($course['created_at'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <?php if ($course['updated_at'] && $course['updated_at'] != $course['created_at']): ?>
                                <p><strong>Updated:</strong> <?= date('M d, Y', strtotime($course['updated_at'])) ?></p>
                            <?php endif; ?>
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
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-0">No materials uploaded yet.</p>
                            <small class="text-muted">Upload your first material to get started.</small>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <i class="fas fa-file text-secondary me-2"></i>
                                                <?= esc($material['file_name']) ?>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('M j, Y', strtotime($material['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="<?= base_url('materials/download/' . $material['id']) ?>" target="_blank">
                                                        <i class="fas fa-download me-1"></i> Download
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#" onclick="confirmDelete(<?= $material['id'] ?>)">
                                                        <i class="fas fa-trash me-1"></i> Delete
                                                    </a>
                                                </li>
                                            </ul>
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

<script>
function confirmDelete(materialId) {
    if (confirm('Are you sure you want to delete this material? This action cannot be undone.')) {
        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('materials/delete/') ?>' + materialId;

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '<?= csrf_token() ?>';
        csrfInput.value = '<?= csrf_hash() ?>';
        form.appendChild(csrfInput);

        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection(); ?>
