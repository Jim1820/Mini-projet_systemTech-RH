<!-- app/Views/layouts/main.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'TechMada RH') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
<div class="app-wrap">
    <?= $this->renderSection('sidebar') ?>
    <div class="main">
        <div class="topbar">
            <?= $this->renderSection('topbar') ?>

            <!-- Déconnexion universelle -->
            <div class="topbar-user">
                <span class="topbar-name">
                    <i class="bi bi-person-circle"></i>
                    <?= esc(session()->get('user_name') ?? '') ?>
                </span>
                <a href="/auth/logout" class="btn-logout" onclick="return confirm('Se déconnecter ?')">
                    <i class="bi bi-box-arrow-right"></i>
                    Déconnexion
                </a>
            </div>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="flash flash-success">
                    <i class="bi bi-check-circle-fill"></i>
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="flash flash-error">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </div>

        <div class="footer-app">
            <i class="bi bi-c-circle"></i> <?= date('Y') ?> <span>TechMada RH</span>
        </div>
    </div>
</div>
</body>
</html>