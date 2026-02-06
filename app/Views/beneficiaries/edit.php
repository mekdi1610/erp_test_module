<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <div>
            <div class="badge">Beneficiaries</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Edit Beneficiary</h1>
        </div>
    </div>

    <?php $h = $household ?? []; $bl = $baseline ?? []; ?>

    <form action="<?= site_url('beneficiaries/update/' . $beneficiary['id']) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;">
            <!-- Beneficiary profile -->
            <div>
                <h2 style="font-size:1rem;margin-bottom:0.5rem;">Beneficiary Profile</h2>

                <label class="muted">Full name</label>
                <input type="text" name="full_name" value="<?= old('full_name', $beneficiary['full_name']) ?>" required
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Age</label>
                <input type="number" name="age" value="<?= old('age', $beneficiary['age']) ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Gender</label>
                <select name="gender"
                        style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
                    <option value="">Select</option>
                    <option value="Male" <?= old('gender', $beneficiary['gender']) === 'Male' ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= old('gender', $beneficiary['gender']) === 'Female' ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= old('gender', $beneficiary['gender']) === 'Other' ? 'selected' : '' ?>>Other</option>
                </select>

                <label class="muted">Address</label>
                <textarea name="address" rows="2"
                          style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"><?= old('address', $beneficiary['address']) ?></textarea>

                <label class="muted">Identification type</label>
                <input type="text" name="identification_type" value="<?= old('identification_type', $beneficiary['identification_type']) ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Identification number</label>
                <input type="text" name="identification_number" value="<?= old('identification_number', $beneficiary['identification_number']) ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Photo</label>
                <?php if (! empty($beneficiary['photo_path'])) : ?>
                    <div style="margin:0.25rem 0 0.75rem;">
                        <img src="<?= base_url($beneficiary['photo_path']) ?>" alt="Photo"
                             style="width:80px;height:80px;object-fit:cover;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);display:block;margin-bottom:0.25rem;">
                        <span class="muted" style="font-size:0.75rem;">Current photo</span>
                    </div>
                <?php endif; ?>
                <input type="file" name="photo" accept="image/*"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;">
            </div>

            <!-- Household data -->
            <div>
                <h2 style="font-size:1rem;margin-bottom:0.5rem;">Household Information</h2>

                <label class="muted">Household address</label>
                <textarea name="household_address" rows="2"
                          style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;"><?= old('household_address', $h['address'] ?? '') ?></textarea>

                <label class="muted">Family size</label>
                <input type="number" name="household_family_size" value="<?= old('household_family_size', $h['family_size'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Vulnerability status</label>
                <input type="text" name="household_vulnerability_status" value="<?= old('household_vulnerability_status', $h['vulnerability_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Income level</label>
                <input type="text" name="household_income_level" value="<?= old('household_income_level', $h['income_level'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            </div>

            <!-- Baseline & socioeconomic information -->
            <div>
                <h2 style="font-size:1rem;margin-bottom:0.5rem;">Baseline & Socioeconomic</h2>

                <label class="muted">Education status</label>
                <input type="text" name="education_status" value="<?= old('education_status', $bl['education_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Health status</label>
                <input type="text" name="health_status" value="<?= old('health_status', $bl['health_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Livelihood status</label>
                <input type="text" name="livelihood_status" value="<?= old('livelihood_status', $bl['livelihood_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Nutrition status</label>
                <input type="text" name="nutrition_status" value="<?= old('nutrition_status', $bl['nutrition_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Income status</label>
                <input type="text" name="income_status" value="<?= old('income_status', $bl['income_status'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

                <label class="muted">Baseline date</label>
                <input type="date" name="baseline_date" value="<?= old('baseline_date', $bl['baseline_date'] ?? '') ?>"
                       style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">
            </div>
        </div>

        <div style="margin-top:1.5rem;display:flex;justify-content:flex-end;gap:0.75rem;">
            <a href="<?= site_url('beneficiaries') ?>"
               style="padding:0.55rem 1.1rem;border-radius:999px;border:1px solid rgba(148,163,184,0.6);color:#e5e7eb;text-decoration:none;font-size:0.9rem;">
                Cancel
            </a>
            <button type="submit" class="btn-primary">
                Update Beneficiary
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

