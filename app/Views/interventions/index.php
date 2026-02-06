<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Interventions</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Interventions</h1>
        </div>
        <a href="<?= site_url('interventions/create') ?>" class="btn-primary">New Intervention</a>
    </div>

    <?php if (session('message')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#a7f3d0;">
            <?= esc(session('message')) ?>
        </p>
    <?php endif; ?>

    <?php if (! empty($interventions)) : ?>
        <ul class="list">
            <?php foreach ($interventions as $i) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($i['name']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            Type: <?= esc($i['service_type']) ?>
                            <?php if (! empty($i['project_code'])) : ?>
                                · Project: <?= esc($i['project_code']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <a href="<?= site_url('interventions/edit/' . $i['id']) ?>" class="icon-btn" title="Edit">✎</a>
                        <a href="<?= site_url('interventions/delete/' . $i['id']) ?>" class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this intervention?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="muted">No interventions defined yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

