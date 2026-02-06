<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Projects</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Edit Project</h1>
        </div>
    </div>

    <form action="<?= site_url('projects/update/' . $project['id']) ?>" method="post">
        <?= csrf_field() ?>

        <label class="muted">Project code</label>
        <input type="text" name="code" value="<?= old('code', $project['code']) ?>" required
               style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

        <label class="muted">Name</label>
        <input type="text" name="name" value="<?= old('name', $project['name']) ?>" required
               style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

        <label class="muted">Description</label>
        <textarea name="description" rows="3"
                  style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"><?= old('description', $project['description']) ?></textarea>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:0.75rem;">
            <div>
                <label class="muted">Start date</label>
                <input type="date" name="start_date" value="<?= old('start_date', $project['start_date']) ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            </div>
            <div>
                <label class="muted">End date</label>
                <input type="date" name="end_date" value="<?= old('end_date', $project['end_date']) ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:0.75rem;">
            <a href="<?= site_url('projects') ?>"
               style="padding:0.55rem 1.1rem;border-radius:999px;border:1px solid rgba(148,163,184,0.6);color:#e5e7eb;text-decoration:none;font-size:0.9rem;">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                Update Project
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

