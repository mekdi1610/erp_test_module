<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Interventions</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">New Intervention</h1>
        </div>
    </div>

    <form action="<?= site_url('interventions/store') ?>" method="post">
        <?= csrf_field() ?>

        <label class="muted">Name</label>
        <input type="text" name="name" value="<?= old('name') ?>" required
               style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

        <label class="muted">Linked project</label>
        <select name="project_id"
                style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            <option value="">None</option>
            <?php foreach ($projects as $p) : ?>
                <option value="<?= esc($p['id']) ?>" <?= old('project_id') == $p['id'] ? 'selected' : '' ?>>
                    <?= esc($p['code']) ?> · <?= esc($p['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="muted">Service type</label>
        <select name="service_type"
                style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            <option value="">Select</option>
            <?php
            $types = [
                'Cash assistance',
                'Food aid',
                'Income Generating Activities (IGA)',
                'Training',
                'Education',
                'Health services',
            ];
            foreach ($types as $type) : ?>
                <option value="<?= esc($type) ?>" <?= old('service_type') === $type ? 'selected' : '' ?>>
                    <?= esc($type) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="muted">Description</label>
        <textarea name="description" rows="3"
                  style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"><?= old('description') ?></textarea>

        <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:0.75rem;">
            <a href="<?= site_url('interventions') ?>"
               style="padding:0.55rem 1.1rem;border-radius:999px;border:1px solid rgba(148,163,184,0.6);color:#e5e7eb;text-decoration:none;font-size:0.9rem;">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                Save Intervention
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

