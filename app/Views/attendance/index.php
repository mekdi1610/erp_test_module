<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Events</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Trainings & Community Events</h1>
        </div>
        <a href="<?= site_url('attendance/events/create') ?>" class="btn-primary">New Event</a>
    </div>

    <?php if (session('message')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#a7f3d0;">
            <?= esc(session('message')) ?>
        </p>
    <?php endif; ?>

    <?php if (! empty($events)) : ?>
        <ul class="list">
            <?php foreach ($events as $e) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($e['name']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?= esc($e['type']) ?> on <?= esc($e['event_date']) ?>
                            <?php if (! empty($e['location'])) : ?>
                                · <?= esc($e['location']) ?>
                            <?php endif; ?>
                            <?php if (! empty($e['project_code'])) : ?>
                                · Project: <?= esc($e['project_code']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <a href="<?= site_url('attendance/record/' . $e['id']) ?>" class="chip">Record</a>
                        <a href="<?= site_url('attendance/events/edit/' . $e['id']) ?>" class="icon-btn" title="Edit">✎</a>
                        <a href="<?= site_url('attendance/events/delete/' . $e['id']) ?>" class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this event and its attendance?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p class="muted">No events defined yet.</p>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

