<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-person-check"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace responsable</span></div>
    </div>
    <div class="sidebar-section">Menu</div>
    <ul class="sidebar-nav">
      <li><a href="/rh"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li>
        <a href="/rh" class="active">
          <i class="bi bi-inbox"></i> Demandes à traiter
        </a>
      </li>
      <li><a href="/rh"><i class="bi bi-archive"></i> Historique</a></li>
      <li><a href="/rh"><i class="bi bi-people"></i> Soldes employés</a></li>
    </ul>
</aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
<div>
  <div class="topbar-title">Demandes à traiter</div>
  <div class="topbar-breadcrumb"><a href="/rh">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Demandes</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

  <div style="display:flex;gap:8px;margin-bottom:1.25rem;flex-wrap:wrap">
    <?php $actif = $statut_actif ?? ''; ?>
    <a href="/rh" style="text-decoration:none;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--forest);<?= $actif=='' ? 'background:var(--forest);color:var(--white);' : 'background:transparent;color:var(--forest);' ?>">Tous</a>
    <a href="?statut=en_attente" style="text-decoration:none;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);<?= $actif=='en_attente' ? 'background:#e2e3e5;color:#333;' : 'background:var(--white);color:var(--muted);' ?>">En attente</a>
    <a href="?statut=approuvee" style="text-decoration:none;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);<?= $actif=='approuvee' ? 'background:#e2e3e5;color:#333;' : 'background:var(--white);color:var(--muted);' ?>">Approuvées</a>
    <a href="?statut=refusee" style="text-decoration:none;padding:6px 14px;border-radius:20px;font-size:.8rem;font-weight:500;border:1.5px solid var(--border);<?= $actif=='refusee' ? 'background:#e2e3e5;color:#333;' : 'background:var(--white);color:var(--muted);' ?>">Refusées</a>
  </div>

  <div class="data-card">
    <div class="data-card-head"><h3>Toutes les demandes</h3></div>
    <table class="tbl">
      <thead>
        <tr><th>Employé</th><th>Type</th><th>Période</th><th>Durée</th><th>Solde dispo</th><th>Statut</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if (!empty($demandes)): ?>
          <?php foreach ($demandes as $demande): 
            $solde = (isset($demande['jours_attribues']) && isset($demande['jours_pris'])) ? $demande['jours_attribues'] - $demande['jours_pris'] : '?';
          ?>
          <tr>
            <td>
              <div class="profile-row">
                <div class="avatar av-green" style="width:32px;height:32px;font-size:.7rem">
                  <?= strtoupper(substr($demande['prenom'] ?? '', 0, 1) . substr($demande['nom'] ?? '', 0, 1)) ?>
                </div>
                <div class="profile-info">
                  <div class="pname"><?= esc($demande['prenom'] . ' ' . $demande['nom']) ?></div>
                  <div class="pdept">ID: <?= esc($demande['employe_id']) ?></div>
                </div>
              </div>
            </td>
            <td><span class="type-badge t-<?= strtolower(url_title($demande['libelle'] ?? 'conge')) ?>"><?= esc($demande['libelle'] ?? 'Congé') ?></span></td>
            <td class="td-muted" style="font-size:.8rem"><?= date('d/m/Y', strtotime($demande['date_debut'])) ?> – <?= date('d/m/Y', strtotime($demande['date_fin'])) ?></td>
            <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
            <td>
              <span style="font-family:'DM Mono',monospace;font-size:.82rem;color:<?= ($solde !== '?' && $solde < $demande['nb_jours']) ? 'var(--danger)' : 'var(--success)' ?>;font-weight:500"><?= esc((string)$solde) ?> j</span>
              <span style="font-size:.72rem;color:var(--muted)"> dispo</span>
            </td>
            <td><span class="statut s-<?= esc(str_replace('_', '-', $demande['statut'])) ?>"><?= str_replace('_', ' ', esc($demande['statut'])) ?></span></td>
            <td>
              <div class="action-btns">
                <?php if ($demande['statut'] === 'en_attente'): ?>
                <form action="/rh/approuver/<?= $demande['id'] ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button class="btn-sm btn-approve"><i class="bi bi-check-lg"></i> Approuver</button>
                </form>
                <form action="/rh/refuser/<?= $demande['id'] ?>" method="post" style="display:inline;">
                    <?= csrf_field() ?>
                    <button class="btn-sm btn-refuse"><i class="bi bi-x-lg"></i> Refuser</button>
                </form>
                <?php else: ?>
                  <span class="td-muted" style="font-size:.75rem">Traité par RH ID: <?= esc($demande['traite_par'] ?? '') ?></span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">Aucune demande trouvée.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
<?= $this->endSection() ?>
