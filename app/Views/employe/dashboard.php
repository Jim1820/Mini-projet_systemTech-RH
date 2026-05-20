<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="/employe" class="active"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="/employe/demande"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li>
        <a href="/employe/mes-demandes">
          <i class="bi bi-calendar3"></i> Mes demandes
          <span class="nav-badge alert">2</span>
        </a>
      </li>
      <li><a href="/employe"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-green">SR</div>
        <div>
          <div class="user-name">Soa Rakoto</div>
          <div class="user-role">Employé · IT</div>
        </div>
        <a href="/auth/logout" style="margin-left:auto;color:rgba(255,255,255,.25);font-size:1.1rem" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></a>
      </div>
    </div>
  </aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>

      <div>
        <div class="topbar-title">Tableau de bord</div>
        <div class="topbar-breadcrumb">Accueil</div>
      </div>
      <div class="topbar-actions">
        <a href="/employe/demande" class="btn-forest" style="padding:7px 14px;font-size:.82rem">
          <i class="bi bi-plus-lg"></i> Nouvelle demande
        </a>
      </div>
    
<?= $this->endSection() ?>

<?= $this->section('content') ?>


      <!-- Flash succès -->
      <div class="flash flash-success">
        <i class="bi bi-check-circle-fill"></i>
        Votre demande de congé a bien été soumise. Elle est en attente de validation.
      </div>

      <!-- Métriques -->
      <div class="metrics">
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
          <div class="metric-val"><?= esc($enAttenteCount) ?></div>
          <div class="metric-label">En attente</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-check-circle"></i></div></div>
          <div class="metric-val"><?= esc($approuveesCount) ?></div>
          <div class="metric-label">Approuvées</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-calendar-check"></i></div></div>
          <div class="metric-val">18</div>
          <div class="metric-label">Jours restants</div>
          <div class="metric-sub">sur 30 cette année</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-x-circle"></i></div></div>
          <div class="metric-val">1</div>
          <div class="metric-label">Refusée</div>
        </div>
      </div>

      <!-- Soldes de congés -->
      <div class="data-card">
        <div class="data-card-head"><h3>Mes soldes de congés — <?= date('Y') ?></h3></div>
        <div style="padding:1rem 1.25rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1rem">
          <?php if (!empty($soldes)): ?>
            <?php foreach ($soldes as $solde): 
              $restant = $solde['jours_attribues'] - $solde['jours_pris'];
              $percent = $solde['jours_attribues'] > 0 ? ($restant / $solde['jours_attribues']) * 100 : 0;
              $isWarn = $percent <= 20;
            ?>
            <div class="solde-card" style="margin:0">
              <div class="solde-header">
                <span class="solde-type"><?= esc($solde['libelle']) ?></span>
                <span class="solde-nums"><strong><?= esc($restant) ?></strong> / <?= esc($solde['jours_attribues']) ?> j</span>
              </div>
              <div class="solde-bar"><div class="solde-fill <?= $isWarn ? 'warn' : '' ?>" style="width:<?= esc($percent) ?>%"></div></div>
              <div class="solde-label"><?= esc($restant) ?> jours restants · <?= esc($solde['jours_pris']) ?> pris</div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>Aucun solde trouvé pour cette année.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Dernières demandes -->
      <div class="data-card">
        <div class="data-card-head">
          <h3>Mes dernières demandes</h3>
          <a href="/employe/mes-demandes" style="font-size:.8rem;color:var(--forest);text-decoration:none">Voir tout →</a>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Type</th><th>Du</th><th>Au</th><th>Durée</th><th>Statut</th><th>Action</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($demandes)): ?>
              <?php foreach ($demandes as $demande): ?>
              <tr>
                <td><span class="type-badge t-<?= strtolower(url_title($demande['libelle'] ?? 'conge')) ?>"><?= esc($demande['libelle'] ?? 'Congé') ?></span></td>
                <td class="td-muted"><?= date('d M Y', strtotime($demande['date_debut'])) ?></td>
                <td class="td-muted"><?= date('d M Y', strtotime($demande['date_fin'])) ?></td>
                <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
                <td><span class="statut s-<?= esc(str_replace('_', '-', $demande['statut'])) ?>"><?= str_replace('_', ' ', esc($demande['statut'])) ?></span></td>
                <td>
                  <?php if ($demande['statut'] === 'en_attente'): ?>
                    <form action="/employe/annuler-demande/<?= $demande['id'] ?>
<?= csrf_field() ?>" method="post" style="display:inline;">
                      <button class="btn-sm btn-cancel"><i class="bi bi-x"></i> Annuler</button>
                    </form>
                  <?php else: ?>
                    <span class="td-muted" style="font-size:.75rem">—</span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6">Aucune demande récente.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    
<?= $this->endSection() ?>
