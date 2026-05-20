<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="/employe"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="/employe/demande"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="/employe/mes-demandes" class="active"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
      <li><a href="/employe"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
  </aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>

      <div>
        <div class="topbar-title">Mes demandes</div>
        <div class="topbar-breadcrumb"><a href="/employe">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Demandes</div>
      </div>
    
<?= $this->endSection() ?>

<?= $this->section('content') ?>


      <?php if (session()->getFlashdata('success')): ?>
      <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= esc(session()->getFlashdata('success')) ?>
      </div>
      <?php endif; ?>

      <div class="data-card">
        <div class="data-card-head"><h3>Toutes mes demandes</h3></div>
        <table class="tbl">
          <thead>
            <tr><th>Type</th><th>Période</th><th>Durée</th><th>Motif</th><th>Statut</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($demandes)): ?>
              <?php foreach ($demandes as $demande): ?>
              <tr>
                <td><span class="type-badge t-<?= strtolower(url_title($demande['libelle'] ?? 'conge')) ?>"><?= esc($demande['libelle'] ?? 'Congé') ?></span></td>
                <td class="td-muted" style="font-size:.8rem"><?= date('d/m', strtotime($demande['date_debut'])) ?> – <?= date('d/m/Y', strtotime($demande['date_fin'])) ?></td>
                <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
                <td class="td-muted" style="font-size:.8rem"><?= esc($demande['motif'] ?? '—') ?></td>
                <td><span class="statut s-<?= esc(str_replace('_', '-', $demande['statut'])) ?>"><?= str_replace('_', ' ', esc($demande['statut'])) ?></span></td>
                <td>
                  <div class="action-btns">
                    <?php if ($demande['statut'] === 'en_attente'): ?>
                    <form action="/employe/annuler-demande/<?= $demande['id'] ?>
<?= csrf_field() ?>" method="post" style="display:inline;">
                      <button class="btn-sm btn-refuse"><i class="bi bi-x-lg"></i> Annuler</button>
                    </form>
                    <?php else: ?>
                    <span class="td-muted" style="font-size:.75rem">—</span>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6">Aucune demande trouvée.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

<?= $this->endSection() ?>
