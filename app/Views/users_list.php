<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Users</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">User Directory</h1>
        </div>
    </div>

    <?php if (! empty($users) && is_array($users)) : ?>
        <ul class="list">
            <?php foreach ($users as $user) : ?>
                <li class="list-item">
                    <span class="list-item-label"><?= esc($user['name']) ?></span>
                    <span class="chip"><?= esc($user['email']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="muted">No users found. Add some records to the <code>users</code> table.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

