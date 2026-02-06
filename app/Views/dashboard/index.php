<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">User</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">My Dashboard</h1>
        </div>
    </div>

    <p class="muted">
        Welcome, <?= esc(session('name') ?? '') ?>.
    </p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-top:1rem;">
        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">Beneficiaries</div>
            <p class="muted">Total registered: <?= esc($beneficiaryCount) ?></p>
            <a href="<?= site_url('beneficiaries') ?>" class="btn-primary">Register / view</a>
        </div>

        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">Recent notes</div>
            <ul class="list">
                <?php foreach ($myNotes as $n) : ?>
                    <li class="list-item">
                        <div class="list-item-label">
                            <?= esc($n['note_type']) ?> · <?= esc($n['status']) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">Recent referrals</div>
            <ul class="list">
                <?php foreach ($myReferrals as $r) : ?>
                    <li class="list-item">
                        <div class="list-item-label">
                            <?= esc($r['referral_type']) ?> · <?= esc($r['status']) ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

