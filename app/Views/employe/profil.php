<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="/employe"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="/employe/demande"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="/employe/mes-demandes"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
      <li><a href="/employe/profil" class="active"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
</aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
<div>
  <div class="topbar-title">Mon Profil</div>
  <div class="topbar-breadcrumb">Accueil > Mon Profil</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="data-card">
  <div class="data-card-head"><h3>Modifier mes informations</h3></div>
  <form action="/employe/profil/update" method="post" style="padding:1rem;">
    <?= csrf_field() ?>
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Prénom</label>
        <input type="text" name="prenom" class="f-input" value="<?= set_value('prenom', esc($employe['prenom'])) ?>">
      </div>
      <div class="f-group">
        <label class="f-label">Nom</label>
        <input type="text" name="nom" class="f-input" value="<?= set_value('nom', esc($employe['nom'])) ?>">
      </div>
    </div>
    <div class="f-group" style="margin-bottom:1rem">
      <label class="f-label">Email</label>
      <input type="email" name="email" class="f-input" value="<?= set_value('email', esc($employe['email'])) ?>">
    </div>

    <h4 style="margin-top:2rem;margin-bottom:1rem;">Mot de passe</h4>
    <div class="f-group" style="margin-bottom:1rem">
      <label class="f-label">Mot de passe actuel</label>
      <input type="password" name="password_actuel" class="f-input">
    </div>
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Nouveau (optionnel)</label>
        <input type="password" name="password_nouveau" class="f-input">
      </div>
      <div class="f-group">
        <label class="f-label">Confirmer</label>
        <input type="password" name="password_confirmer" class="f-input">
      </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn-forest"><i class="bi bi-save"></i> Enregistrer</button>
    </div>
  </form>
</div>
<?= $this->endSection() ?>
