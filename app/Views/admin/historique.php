<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="/admin"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="/admin/historique" class="active"><i class="bi bi-archive"></i> Historique Global</a></li>
      <li><a href="/rh"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
      <li><a href="/admin/employes"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="/admin/departements"><i class="bi bi-building"></i> Départements</a></li>
      <li><a href="/admin/types"><i class="bi bi-tags"></i> Types de congé</a></li>
    </ul>
</aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
<div>
  <div class="topbar-title">Historique Global</div>
  <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Historique</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="data-card">
  <div class="data-card-head">
    <h3>Toutes les demandes enregistrées</h3>
  </div>
  <table class="tbl">
    <thead>
      <tr>
        <th>Date dépôt</th>
        <th>Employé</th>
        <th>Type</th>
        <th>Période</th>
        <th>Durée</th>
        <th>Statut</th>
        <th>Approuvé par</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($demandes)): ?>
        <?php foreach ($demandes as $d): ?>
        <tr>
          <td><?= date('d/m/Y H:i', strtotime($d['created_at'])) ?></td>
          <td><strong><?= esc($d['prenom'] . ' ' . $d['nom']) ?></strong></td>
          <td><span class="type-badge t-<?= strtolower(url_title($d['libelle'] ?? '')) ?>"><?= esc($d['libelle']) ?></span></td>
          <td class="td-muted" style="font-size:.8rem"><?= date('d/m/Y', strtotime($d['date_debut'])) ?> – <?= date('d/m/Y', strtotime($d['date_fin'])) ?></td>
          <td class="td-mono"><?= esc($d['nb_jours']) ?> j</td>
          <td><span class="statut s-<?= esc(str_replace('_', '-', $d['statut'])) ?>"><?= str_replace('_', ' ', esc($d['statut'])) ?></span></td>
          <td class="td-muted" style="font-size:.8rem"><?= esc($d['traite_par'] ?? '-') ?></td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="7">Aucune demande trouvée.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
<?= $this->endSection() ?>
