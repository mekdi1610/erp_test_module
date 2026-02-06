<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'My App') ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style {csp-style-nonce}>
    :root {
        --color-base: #1f2937;
        --color-secondary: #00c6b6;
        --color-third: #ffffff;
    }

    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        background-color: var(--color-base);
        color: var(--color-third);
    }

    a {
        color: var(--color-secondary);
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    .app-shell {
        min-height: 100vh;
        display: flex;
        flex-direction: row;
    }

    .app-sidebar {
        width: 230px;
        background: #020617;
        border-right: 1px solid rgba(148, 163, 184, 0.25);
        padding: 1.25rem 1rem;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .app-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .app-logo {
        font-weight: 600;
        font-size: 1.1rem;
        letter-spacing: 0.05em;
    }

    .app-logo span {
        color: var(--color-secondary);
    }

    .app-nav {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        margin-top: 0.5rem;
    }

    .app-nav a {
        font-size: 0.9rem;
        opacity: 0.85;
        padding: 0.4rem 0.75rem;
        border-radius: 0.5rem;
    }

    .app-nav a:hover {
        opacity: 1;
        background-color: rgba(15, 23, 42, 0.9);
    }

    .app-main-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-height: 100vh;
    }

    .app-main {
        flex: 1;
        padding: 2rem 1.5rem;
        overflow-y: auto;
    }

    .card {
        background-color: rgba(31, 41, 55, 0.9);
        border-radius: 0.75rem;
        padding: 1.75rem 1.5rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4);
        border: 1px solid rgba(148, 163, 184, 0.3);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
    }

    .card-title {
        font-size: 1.4rem;
        font-weight: 600;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.1rem 0.5rem;
        border-radius: 999px;
        font-size: 0.7rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        background-color: rgba(16, 185, 129, 0.15);
        color: var(--color-secondary);
        border: 1px solid rgba(45, 212, 191, 0.4);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.55rem 1.1rem;
        border-radius: 999px;
        border: none;
        background: linear-gradient(135deg, var(--color-secondary), #14f0e0);
        color: #020617;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        box-shadow: 0 10px 25px -5px rgba(0, 198, 182, 0.7);
    }

    .btn-primary:hover {
        filter: brightness(1.05);
    }

    .muted {
        color: #9ca3af;
        font-size: 0.9rem;
    }

    .list {
        list-style: none;
        padding: 0;
        margin: 0.75rem 0 0;
    }

    .list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0.4rem;
        border-bottom: 1px solid rgba(55, 65, 81, 0.9);
    }

    .list-item:last-child {
        border-bottom: none;
    }

    .list-item-label {
        font-weight: 500;
    }

    .chip {
        padding: 0.15rem 0.6rem;
        border-radius: 999px;
        background-color: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(148, 163, 184, 0.4);
        font-size: 0.75rem;
        color: #e5e7eb;
    }

    .icon-bar {
        display: flex;
        gap: 0.4rem;
        align-items: center;
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        border: 1px solid rgba(148, 163, 184, 0.6);
        background: transparent;
        color: #e5e7eb;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background-color 150ms ease, color 150ms ease, transform 100ms ease, box-shadow 150ms ease;
    }

    .icon-btn:hover {
        background-color: rgba(148, 163, 184, 0.18);
        transform: translateY(-1px);
    }

    .icon-btn.danger {
        border-color: rgba(248, 113, 113, 0.8);
        color: #fecaca;
    }

    .tab-btn {
        padding: 0.25rem 0.9rem;
        font-size: 0.8rem;
        border-radius: 999px;
    }

    .tab-btn.active {
        background: linear-gradient(135deg, var(--color-secondary), #14f0e0);
        color: #020617;
        border-color: transparent;
        box-shadow: 0 6px 18px -6px rgba(0, 198, 182, 0.7);
        transform: translateY(-1px);
    }

    .app-footer {
        padding: 0.75rem 1.5rem;
        text-align: center;
        font-size: 0.8rem;
        color: #9ca3af;
        border-top: 1px solid rgba(148, 163, 184, 0.25);
        background-color: #111827;
    }
    </style>
</head>

<body>
    <div class="app-shell">
        <aside class="app-sidebar">
            <div class="app-header">
                <div class="app-logo">
                    <span>NGO</span> ERP
                </div>
            </div>

            <nav class="app-nav">
                <?php if (!session()->get('user_id')): ?>
                <a href="<?= site_url('/') ?>">Login</a>
                <?php else: ?>
                <?php if (session()->get('role') === 'admin'): ?>
                <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a>
                <a href="<?= site_url('beneficiaries') ?>">Beneficiaries</a>
                <a href="<?= site_url('projects') ?>">Projects</a>
                <a href="<?= site_url('interventions') ?>">Interventions</a>
                <a href="<?= site_url('attendance') ?>">Events & Training</a>
                <a href="<?= site_url('alerts') ?>">Alerts</a>
                <?php else: ?>
                <a href="<?= site_url('dashboard') ?>">My Dashboard</a>
                <a href="<?= site_url('beneficiaries') ?>">Beneficiaries</a>
                <a href="<?= site_url('attendance') ?>">Events & Attendance</a>
                <a href="<?= site_url('alerts') ?>">Alerts</a>
                <?php endif; ?>
                <a href="<?= site_url('logout') ?>">Logout</a>
                <?php endif; ?>
            </nav>
        </aside>

        <div class="app-main-wrapper">
            <main class="app-main">
                <?= $this->renderSection('content') ?>
            </main>

            <footer class="app-footer">
                <span>Environment: <?= ENVIRONMENT ?></span>
                <span> · </span>
                <span>Page rendered in {elapsed_time}s · {memory_usage} MB</span>
            </footer>
        </div>
    </div>
</body>

</html>