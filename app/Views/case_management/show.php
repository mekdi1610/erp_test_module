<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Case</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Case for <?= esc($beneficiary['full_name'] ?? 'Beneficiary') ?></h1>
        </div>
    </div>

    <?php if (session('message')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#a7f3d0;">
            <?= esc(session('message')) ?>
        </p>
    <?php endif; ?>

    <!-- Simple summary -->
    <p class="muted" style="margin-bottom:1.25rem;">
        Beneficiary ID: <?= esc($beneficiary['beneficiary_uid'] ?? $beneficiary['id']) ?> ·
        <?= esc($beneficiary['gender'] ?? '') ?>
        <?php if (! empty($beneficiary['age'])) : ?>
            (<?= esc($beneficiary['age']) ?> yrs)
        <?php endif; ?>
    </p>

    <!-- Tab navigation -->
    <div style="display:flex;gap:0.5rem;margin-bottom:1rem;flex-wrap:wrap;">
        <button type="button" class="icon-btn tab-btn" data-tab="progress">Progress</button>
        <button type="button" class="icon-btn tab-btn" data-tab="notes">Case Notes</button>
        <button type="button" class="icon-btn tab-btn" data-tab="referrals">Referrals</button>
        <button type="button" class="icon-btn tab-btn" data-tab="services">Services & Enrollments</button>
    </div>

    <!-- Progress tab -->
    <div class="case-tab" data-tab-content="progress">
        <form action="<?= site_url('case-management/' . $beneficiary['id'] . '/progress') ?>" method="post"
              style="margin-bottom:1rem;">
            <?= csrf_field() ?>
            <input type="date" name="progress_date" value="<?= date('Y-m-d') ?>"
                   style="width:100%;margin-top:0.25rem;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <select name="domain"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="general">General</option>
                <option value="education">Education</option>
                <option value="health">Health</option>
                <option value="livelihood">Livelihood</option>
                <option value="nutrition">Nutrition</option>
                <option value="income">Income</option>
            </select>

            <input type="number" name="score" placeholder="Score (optional)"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <input type="text" name="status_summary" placeholder="Short summary"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <textarea name="notes" rows="2" placeholder="Detailed notes"
                      style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"></textarea>

            <button type="submit" class="btn-primary">Add Progress</button>
        </form>

        <ul class="list">
            <?php foreach ($progress as $p) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($p['progress_date']) ?> · <?= esc($p['domain'] ?? 'general') ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?= esc($p['status_summary'] ?? '') ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <?php if (! empty($p['score'])) : ?>
                            <span class="chip">Score: <?= esc($p['score']) ?></span>
                        <?php endif; ?>
                        <a href="<?= site_url('case-management/progress/delete/' . $p['id']) ?>"
                           class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this progress entry?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Case notes tab -->
    <div class="case-tab" data-tab-content="notes" style="display:none;">
        <form action="<?= site_url('case-management/' . $beneficiary['id'] . '/case-note') ?>" method="post"
              style="margin-bottom:1rem;">
            <?= csrf_field() ?>

            <select name="note_type"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="social_followup">Social worker follow-up</option>
                <option value="counseling">Counseling</option>
                <option value="referral">Referral note</option>
                <option value="general">General</option>
            </select>

            <input type="text" name="created_by" placeholder="Recorded by (optional)"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <textarea name="content" rows="3" placeholder="Case note"
                      style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"></textarea>

            <input type="date" name="next_follow_up_date"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"
                   placeholder="Next follow-up date (optional)">

            <select name="risk_level"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="">Risk level (optional)</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>

            <select name="status"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>

            <button type="submit" class="btn-primary">Add Note</button>
        </form>

        <ul class="list">
            <?php foreach ($caseNotes as $n) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($n['note_type']) ?> · <?= esc($n['status']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?= esc($n['content']) ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <?php if (! empty($n['risk_level'])) : ?>
                            <span class="chip">Risk: <?= esc($n['risk_level']) ?></span>
                        <?php endif; ?>
                        <a href="<?= site_url('case-management/case-note/delete/' . $n['id']) ?>"
                           class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this case note?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Referrals tab -->
    <div class="case-tab" data-tab-content="referrals" style="display:none;">
        <form action="<?= site_url('case-management/' . $beneficiary['id'] . '/referral') ?>" method="post"
              style="margin-bottom:1rem;">
            <?= csrf_field() ?>

            <select name="referral_type"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="health">Health services</option>
                <option value="psychosocial">Psychosocial support</option>
                <option value="legal">Legal services</option>
            </select>

            <input type="text" name="referred_to" placeholder="Referred to (facility/organization)"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <input type="date" name="referral_date" value="<?= date('Y-m-d') ?>"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <input type="date" name="next_follow_up_date"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"
                   placeholder="Next follow-up date (optional)">

            <textarea name="outcome" rows="2" placeholder="Outcome / notes (optional)"
                      style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"></textarea>

            <input type="text" name="created_by" placeholder="Recorded by (optional)"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <label style="display:flex;align-items:center;gap:0.35rem;font-size:0.85rem;color:#e5e7eb;">
                <input type="checkbox" name="high_risk" value="1">
                Mark as high-risk
            </label>

            <select name="status"
                    style="width:100%;margin-top:0.5rem;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <button type="submit" class="btn-primary">Add Referral</button>
        </form>

        <ul class="list">
            <?php foreach ($referrals as $r) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($r['referral_type']) ?> · <?= esc($r['status']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?= esc($r['referred_to'] ?? '') ?> · <?= esc($r['referral_date'] ?? '') ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <?php if ((int) ($r['high_risk'] ?? 0) === 1) : ?>
                            <span class="chip">High risk</span>
                        <?php endif; ?>
                        <a href="<?= site_url('case-management/referral/delete/' . $r['id']) ?>"
                           class="icon-btn danger" title="Delete"
                           onclick="return confirm('Delete this referral?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Services & enrollments tab -->
    <div class="case-tab" data-tab-content="services" style="display:none;">
        <form action="<?= site_url('case-management/' . $beneficiary['id'] . '/enrollment') ?>" method="post"
              style="margin-bottom:1rem;">
            <?= csrf_field() ?>

            <select name="project_id"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="">Project (optional)</option>
                <?php foreach ($projects as $p) : ?>
                    <option value="<?= esc($p['id']) ?>">
                        <?= esc($p['code']) ?> · <?= esc($p['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="intervention_id"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="">Program / Intervention (optional)</option>
                <?php foreach ($interventions as $i) : ?>
                    <option value="<?= esc($i['id']) ?>">
                        <?= esc($i['name']) ?> (<?= esc($i['service_type']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="service_type"
                    style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                <option value="">Service type</option>
                <option value="Cash assistance">Cash assistance</option>
                <option value="Food aid">Food aid</option>
                <option value="Income Generating Activities (IGA)">Income Generating Activities (IGA)</option>
                <option value="Training">Training</option>
                <option value="Education">Education</option>
                <option value="Health services">Health services</option>
            </select>

            <input type="date" name="service_date" value="<?= date('Y-m-d') ?>"
                   style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

            <textarea name="notes" rows="2" placeholder="Notes (optional)"
                      style="width:100%;margin-bottom:0.5rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"></textarea>

            <button type="submit" class="btn-primary">Add Enrollment</button>
        </form>

        <ul class="list">
            <?php foreach ($enrollments as $e) : ?>
                <li class="list-item">
                    <div>
                        <div class="list-item-label">
                            <?= esc($e['service_type']) ?> on <?= esc($e['service_date']) ?>
                        </div>
                        <div class="muted" style="font-size:0.8rem;">
                            <?php if (! empty($e['project_code'])) : ?>
                                Project: <?= esc($e['project_code']) ?> · <?= esc($e['project_name']) ?> ·
                            <?php endif; ?>
                            <?php if (! empty($e['intervention_name'])) : ?>
                                Intervention: <?= esc($e['intervention_name']) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="icon-bar">
                        <a href="<?= site_url('case-management/enrollment/delete/' . $e['id']) ?>"
                           class="icon-btn danger" title="Remove"
                           onclick="return confirm('Remove this enrollment?');">🗑</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<script>
    (function () {
        const tabButtons = document.querySelectorAll('[data-tab]');
        const tabContents = document.querySelectorAll('.case-tab');

        function activateTab(name) {
            tabButtons.forEach(btn => {
                btn.classList.toggle('active', btn.getAttribute('data-tab') === name);
            });
            tabContents.forEach(el => {
                el.style.display = el.getAttribute('data-tab-content') === name ? '' : 'none';
            });
        }

        tabButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                activateTab(btn.getAttribute('data-tab'));
            });
        });

        activateTab('progress');
    })();
</script>

<?= $this->endSection() ?>

