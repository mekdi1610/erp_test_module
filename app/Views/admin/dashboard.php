<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Admin</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Dashboard</h1>
        </div>
    </div>

    <p class="muted">
        Logged in as admin <?= esc(session('name') ?? '') ?>.
    </p>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;margin-top:1rem;">
        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">Beneficiaries</div>
            <p class="muted">Total registered: <?= esc($beneficiaryCount) ?></p>
            <a href="<?= site_url('beneficiaries') ?>" class="btn-primary">View all</a>
        </div>

        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">High-risk cases</div>
            <p class="muted">Current high-risk items: <?= esc($highRiskCount) ?></p>
            <a href="<?= site_url('alerts') ?>" class="btn-primary">View alerts</a>
        </div>

        <div class="card" style="padding:1rem 1rem;">
            <div class="card-title" style="font-size:1rem;">Configuration</div>
            <p class="muted">Manage projects, interventions, and events.</p>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:0.5rem;">
                <a href="<?= site_url('projects') ?>" class="chip">Projects</a>
                <a href="<?= site_url('interventions') ?>" class="chip">Interventions</a>
                <a href="<?= site_url('attendance') ?>" class="chip">Events</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>