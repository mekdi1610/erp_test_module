<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">CodeIgniter 4</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Welcome</h1>
        </div>
        <a href="<?= site_url('users') ?>" class="btn-primary">View Users</a>
    </div>
    <p class="muted">
        This is your new CodeIgniter 4 project, styled with your custom palette:
        base <code>#1f2937</code>, secondary <code>#00c6b6</code>, third <code>#ffffff</code>.
    </p>
    <p class="muted">
        You can start building features, controllers, and views. The shared layout keeps the look and feel
        consistent across pages.
    </p>
</div>

<?= $this->endSection() ?>
