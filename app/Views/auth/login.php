<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Connexion') ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
    <!-- Inclusion de Bootstrap Icons pour les icônes du template -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="auth-page geo-bg">
<div class="auth-split">

  <!-- Panneau gauche -->
  <div class="auth-left">
    <div>
      <p class="auth-left-brand">TechMada RH<span>Gestion des congés</span></p>
      <p class="auth-left-text" style="margin-top:2rem">
        <strong>Bienvenue sur votre espace RH.</strong>
        Gérez vos demandes de congés, consultez votre solde et suivez l'état de vos demandes en temps réel.
      </p>
    </div>
    
    <!-- Section Comptes de démonstration (Template statique) -->
    <div class="auth-roles">
      <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.25);margin-bottom:4px">Comptes de démonstration</div>
      <div class="role-pill">
        <i class="bi bi-shield-check"></i>
        <div><div class="role-pill-name">Administrateur</div><div class="role-pill-cred">admin@techmada.mg · admin123</div></div>
      </div>
      <div class="role-pill">
        <i class="bi bi-person-check"></i>
        <div><div class="role-pill-name">Responsable RH</div><div class="role-pill-cred">rh@techmada.mg · rh123</div></div>
      </div>
      <div class="role-pill">
        <i class="bi bi-person"></i>
        <div><div class="role-pill-name">Employé</div><div class="role-pill-cred">jean@techmada.mg · emp123</div></div>
      </div>
    </div>
  </div>

  <!-- Panneau droit -->
  <div class="auth-right">
    <p class="auth-title">Connexion</p>
    <p class="auth-sub">Entrez vos identifiants pour accéder à votre espace.</p>

    <!-- Gestion des erreurs (Flashdata CI4) -->
    <?php if (! empty($error)) : ?>
      <div class="flash flash-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= esc($error) ?>
      </div>
    <?php endif; ?>

    <!-- Début du Formulaire adapté -->
    <form action="/auth/login" method="post">
<?= csrf_field() ?>
      
      <!-- Champ Email -->
      <div class="f-group">
        <label class="f-label">Adresse email</label>
        <input type="email" name="email" class="f-input" placeholder="vous@techmada.mg" value="<?= esc($email ?? '') ?>">
        <?php if (isset($validation) && $validation->getError('email')) : ?>
            <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                <?= esc((string) $validation->getError('email')) ?>
            </small>
        <?php endif; ?>
      </div>

      <!-- Champ Mot de passe -->
      <div class="f-group">
        <label class="f-label">Mot de passe</label>
        <!-- On garde le name="mot_de_passe" du layout original, sans le bouton toggle du template fourni -->
        <input type="password" name="mot_de_passe" class="f-input" placeholder="••••••••" value="<?= esc($password ?? '') ?>">
         <?php if (isset($validation) && $validation->getError('mot_de_passe')) : ?>
            <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                <?= esc((string) $validation->getError('mot_de_passe')) ?>
            </small>
        <?php endif; ?>
      </div>

      <!-- Bouton Submit -->
      <button type="submit" class="btn-primary" style="margin-top:.5rem">
        Se connecter <i class="bi bi-arrow-right-short"></i>
      </button>
    </form>

  </div>

</div>
</div>

</body>
</html>