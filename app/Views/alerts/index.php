<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Alerts</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Alerts & High-Risk Cases</h1>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;">
        <div>
            <h2 style="font-size:1rem;margin-bottom:0.5rem;">Overdue Follow-ups (Case Notes)</h2>
            <?php if (! empty($overdueNotes)) : ?>
                <ul class="list">
                    <?php foreach ($overdueNotes as $n) : ?>
                        <?php $b = $beneficiariesById[$n['beneficiary_id']] ?? null; ?>
                        <li class="list-item">
                            <div>
                                <div class="list-item-label">
                                    Beneficiary: <?= esc($b['beneficiary_uid'] ?? $n['beneficiary_id']) ?> · <?= esc($n['note_type']) ?>
                                </div>
                                <div class="muted" style="font-size:0.8rem;">
                                    Next follow-up: <?= esc($n['next_follow_up_date']) ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="muted">No overdue follow-ups from case notes.</p>
            <?php endif; ?>
        </div>

        <div>
            <h2 style="font-size:1rem;margin-bottom:0.5rem;">Overdue Follow-ups (Referrals)</h2>
            <?php if (! empty($overdueReferrals)) : ?>
                <ul class="list">
                    <?php foreach ($overdueReferrals as $r) : ?>
                        <?php $b = $beneficiariesById[$r['beneficiary_id']] ?? null; ?>
                        <li class="list-item">
                            <div>
                                <div class="list-item-label">
                                    Beneficiary: <?= esc($b['beneficiary_uid'] ?? $r['beneficiary_id']) ?> · <?= esc($r['referral_type']) ?>
                                </div>
                                <div class="muted" style="font-size:0.8rem;">
                                    Next follow-up: <?= esc($r['next_follow_up_date']) ?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="muted">No overdue follow-ups from referrals.</p>
            <?php endif; ?>
        </div>

        <div>
            <h2 style="font-size:1rem;margin-bottom:0.5rem;">High-Risk Case Notes</h2>
            <?php if (! empty($highRiskNotes)) : ?>
                <ul class="list">
                    <?php foreach ($highRiskNotes as $n) : ?>
                        <?php $b = $beneficiariesById[$n['beneficiary_id']] ?? null; ?>
                        <li class="list-item">
                            <div>
                                <div class="list-item-label">
                                    Beneficiary: <?= esc($b['beneficiary_uid'] ?? $n['beneficiary_id']) ?>
                                </div>
                                <div class="muted" style="font-size:0.8rem;">
                                    <?= esc($n['content']) ?>
                                </div>
                            </div>
                            <span class="chip">High risk</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="muted">No high-risk case notes.</p>
            <?php endif; ?>
        </div>

        <div>
            <h2 style="font-size:1rem;margin-bottom:0.5rem;">High-Risk Referrals</h2>
            <?php if (! empty($highRiskReferrals)) : ?>
                <ul class="list">
                    <?php foreach ($highRiskReferrals as $r) : ?>
                        <?php $b = $beneficiariesById[$r['beneficiary_id']] ?? null; ?>
                        <li class="list-item">
                            <div>
                                <div class="list-item-label">
                                    Beneficiary: <?= esc($b['beneficiary_uid'] ?? $r['beneficiary_id']) ?> · <?= esc($r['referral_type']) ?>
                                </div>
                                <div class="muted" style="font-size:0.8rem;">
                                    <?= esc($r['referred_to'] ?? '') ?> · <?= esc($r['referral_date'] ?? '') ?>
                                </div>
                            </div>
                            <span class="chip">High risk</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p class="muted">No high-risk referrals.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

