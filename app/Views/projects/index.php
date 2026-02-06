<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Projects</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Projects</h1>
        </div>
        <a href="<?= site_url('projects/create') ?>" class="btn-primary">New Project</a>
    </div>

    <?php if (session('message')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#a7f3d0;">
            <?= esc(session('message')) ?>
        </p>
    <?php endif; ?>

    <?php if (! empty($projects)) : ?>
        <ul class="list">
            <?php foreach ($projects as $p) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($p['code']) ?> · <?= esc($p['name']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?= esc($p['start_date'] ?? '') ?>
                            <?php if (! empty($p['end_date'])) : ?>
                                – <?= esc($p['end_date']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <a href="<?= site_url('projects/edit/' . $p['id']) ?>" class="icon-btn" title="Edit">✎</a>
                        <a href="<?= site_url('projects/delete/' . $p['id']) ?>" class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this project?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="muted">No projects defined yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

