<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Attendance</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Record Attendance</h1>
        </div>
    </div>

    <p class="muted" style="margin-bottom:0.75rem;">
        Event: <?= esc($event['name'] ?? 'Unknown') ?> · <?= esc($event['event_date'] ?? '') ?>
    </p>

    <form action="<?= site_url('attendance/record/' . $event['id']) ?>" method="post">
        <?= csrf_field() ?>

        <ul class="list">
            <?php
            $existingByBeneficiary = [];
            foreach ($existing as $row) {
                $existingByBeneficiary[$row['beneficiary_id']] = $row;
            }
            ?>
            <?php foreach ($beneficiaries as $b) : ?>
                <?php $current = $existingByBeneficiary[$b['id']] ?? null; ?>
                <li class="list-item">
                    <span class="list-item-label"><?= esc($b['full_name']) ?></span>
                    <select name="beneficiaries[<?= esc($b['id']) ?>]"
                            style="min-width:140px;padding:0.25rem 0.5rem;border-radius:999px;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                        <option value="" <?= $current ? '' : 'selected' ?>>—</option>
                        <option value="attended" <?= ($current['status'] ?? '') === 'attended' ? 'selected' : '' ?>>Attended</option>
                        <option value="absent" <?= ($current['status'] ?? '') === 'absent' ? 'selected' : '' ?>>Absent</option>
                        <option value="late" <?= ($current['status'] ?? '') === 'late' ? 'selected' : '' ?>>Late</option>
                    </select>
                </li>
            <?php endforeach; ?>
        </ul>

        <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:0.75rem;">
            <a href="<?= site_url('attendance') ?>"
               style="padding:0.55rem 1.1rem;border-radius:999px;border:1px solid rgba(148,163,184,0.6);color:#e5e7eb;text-decoration:none;font-size:0.9rem;">
                Back
            </a>
            <button type="submit" class="btn-primary">
                Save Attendance
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

