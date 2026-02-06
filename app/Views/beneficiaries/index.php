<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Beneficiaries</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Registered Beneficiaries</h1>
        </div>
        <a href="<?= site_url('beneficiaries/create') ?>" class="btn-primary">New Beneficiary</a>
    </div>

    <?php if (session('message')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#a7f3d0;">
            <?= esc(session('message')) ?>
        </p>
    <?php endif; ?>

    <?php if (! empty($beneficiaries)) : ?>
        <ul class="list">
            <?php foreach ($beneficiaries as $b) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($b['full_name']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            ID: <?= esc($b['beneficiary_uid']) ?>
                            <?php if (! empty($b['household_code'])) : ?>
                                · Household: <?= esc($b['household_code']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div style="display:flex;gap:0.5rem;align-items:center;">
                        <?php if (! empty($b['gender']) || ! empty($b['age'])) : ?>
                            <span class="chip">
                                <?= esc(trim(($b['gender'] ?? '') . ' ' . ($b['age'] ? '(' . $b['age'] . ')' : ''))) ?>
                            </span>
                        <?php endif; ?>
                        <a href="<?= site_url('case-management/' . $b['id']) ?>" class="chip">Case</a>
                        <div class="icon-bar">
                            <a href="<?= site_url('beneficiaries/edit/' . $b['id']) ?>" class="icon-btn" title="Edit">✎</a>
                            <a href="<?= site_url('beneficiaries/delete/' . $b['id']) ?>" class="icon-btn danger" title="Delete"
                               onclick="return confirm('Delete this beneficiary?');">🗑</a>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="muted">No beneficiaries registered yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

