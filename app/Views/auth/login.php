<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card" style="max-width:420px;margin:0 auto;">
    <div class="card-header">
        <div>
            <div class="badge">Access</div>
            <h1 class="card-title" style="margin-top: 0.5rem;">Login</h1>
        </div>
    </div>

    <?php if (session('error')) : ?>
        <p class="muted" style="margin-bottom:0.75rem;color:#fecaca;">
            <?= esc(session('error')) ?>
        </p>
    <?php endif; ?>

    <form id="loginForm" action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <label class="muted">Email</label>
        <input id="loginEmail" type="email" name="email" value="<?= old('email') ?>" required
               style="width:100%;margin-top:0.25rem;margin-bottom:0.75rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

        <label class="muted">Password</label>
        <input id="loginPassword" type="password" name="password" required
               style="width:100%;margin-top:0.25rem;margin-bottom:1rem;padding:0.5rem 0.75rem;border-radius:0.5rem;border:1px solid rgba(148,163,184,0.6);background:#020617;color:#e5e7eb;">

        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-bottom:0.75rem;">
            Sign in
        </button>

        <div style="display:flex;gap:0.5rem;justify-content:space-between;flex-wrap:wrap;">
            <button type="button" class="icon-btn tab-btn" id="fillAdmin"
                    style="flex:1;justify-content:center;">
                Admin demo
            </button>
            <button type="button" class="icon-btn tab-btn" id="fillUser"
                    style="flex:1;justify-content:center;">
                Field staff demo
            </button>
        </div>
    </form>
</div>

<script>
    (function () {
        const adminBtn = document.getElementById('fillAdmin');
        const userBtn = document.getElementById('fillUser');
        const emailInput = document.getElementById('loginEmail');
        const passwordInput = document.getElementById('loginPassword');

        if (adminBtn && userBtn && emailInput && passwordInput) {
            adminBtn.addEventListener('click', function () {
                emailInput.value = 'admin@example.com';
                passwordInput.value = 'admin123';
                emailInput.focus();
            });

            userBtn.addEventListener('click', function () {
                emailInput.value = 'field@example.com';
                passwordInput.value = 'user123';
                emailInput.focus();
            });
        }
    })();
</script>

<?= $this->endSection() ?>

