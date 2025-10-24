<?php
/** @var array $course */
?>
<?= $this->extend('templates/header'); ?>
<?= $this->section('title') ?>View Course<?= $this->endSection() ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Course Details</h3>
        <div>
            <a href="<?= base_url('admin/courses') ?>" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back to Courses
            </a>
            <a href="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-primary">
                <i class="fas fa-upload me-1"></i> Upload Material
            </a>
        </div>
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

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                        <?= esc($course['course']) ?>
                    </h5>

                    <?php if ($course['description']): ?>
                        <div class="mb-3">
                            <h6>Description</h6>
                            <p class="text-muted mb-0">
                                <?= nl2br(esc($course['description'])) ?>
                            </p>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <h6>Teacher</h6>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-user-tie me-1"></i>
                                    <?= esc($course['teacher_name'] ?? 'N/A') ?>
                                </p>
                                <?php if ($course['teacher_email']): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-envelope me-1"></i>
                                        <?= esc($course['teacher_email']) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <h6>Created</h6>
                                <p class="text-muted mb-0">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= date('M j, Y', strtotime($course['created_at'])) ?>
                                </p>
                                <?php if ($course['updated_at'] && $course['updated_at'] != $course['created_at']): ?>
                                    <small class="text-muted">
                                        <i class="fas fa-edit me-1"></i>
                                        Updated: <?= date('M j, Y', strtotime($course['updated_at'])) ?>
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="fas fa-file-alt text-primary me-1"></i>
                        Course Materials
                    </h6>
                </div>
                <div class="card-body">
                    <?php
                    // Get materials for this course
                    $materialModel = new \App\Models\MaterialModel();
                    $materials = $materialModel->getMaterialsByCourse($course['id']);
                    ?>

                    <?php if (empty($materials)): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-file-upload fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted mb-2">No materials uploaded yet</h6>
                            <p class="text-muted small mb-3">Upload course materials like PDFs, presentations, and documents for your students.</p>
                            <a href="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Upload Your First Material
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($materials as $material): ?>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <i class="fas fa-file text-secondary me-1"></i>
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
