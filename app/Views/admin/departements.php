<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Administration</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="/admin"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li><a href="/rh"><i class="bi bi-inbox"></i> Toutes les demandes</a></li>
      <li><a href="/admin/employes"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="/admin/departements" class="active"><i class="bi bi-building"></i> Départements</a></li>
      <li><a href="/admin/types"><i class="bi bi-tags"></i> Types de congé</a></li>
    </ul>
</aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
<div>
  <div class="topbar-title">Gestion des Départements</div>
  <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Départements</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="form-section">
  <h3><i class="bi bi-building-add" style="color:var(--forest);margin-right:6px"></i>Ajouter un département</h3>
  <form action="/admin/departements" method="post">
    <?= csrf_field() ?>
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Nom du Département</label>
        <input type="text" name="nom" class="f-input" required>
      </div>
      <div class="f-group">
        <label class="f-label">Description</label>
        <input type="text" name="description" class="f-input">
      </div>
    </div>
    <button type="submit" class="btn-forest" style="padding:8px 16px">Sauvegarder</button>
  </form>
</div>

<div class="data-card">
  <div class="data-card-head">
    <h3>Départements existants</h3>
  </div>
  <table class="tbl">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Description</th>
        <th>Statut</th>
        <th style="width:100px;text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($departements as $d): ?>
      <tr>
        <td><?= esc($d['id']) ?></td>
        <td><strong><?= esc($d['nom']) ?></strong></td>
        <td><?= esc($d['description']) ?></td>
        <td><span class="statut s-<?= esc(str_replace('_', '-', $d['statut'])) ?>"><?= esc($d['statut']) ?></span></td>
        <td style="text-align:right">
            <div style="display:flex;gap:5px;justify-content:flex-end">
                <button type="button" class="btn-sm btn-edit" onclick="openDeptModal(<?= $d['id'] ?>, '<?= esc(addslashes($d['nom'])) ?>', '<?= esc(addslashes($d['description'])) ?>')"><i class="bi bi-pencil"></i></button>
                <?php if ($d['statut'] === 'inactif'): ?>
                    <form action="/admin/departements/reactivate/<?= $d['id'] ?>" method="post" style="display:inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-sm btn-view"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </form>
                <?php else: ?>
                    <form action="/admin/departements/deactivate/<?= $d['id'] ?>" method="post" style="display:inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-sm btn-del" onclick="return confirm('Désactiver ce département ?')"><i class="bi bi-slash-circle"></i></button>
                    </form>
                <?php endif; ?>
            </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div id="editDeptModal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:999;">
  <div class="data-card" style="width:500px;max-width:90%;">
    <div class="data-card-head" style="display:flex;justify-content:space-between;">
      <h3>Modifier le département</h3>
      <button type="button" onclick="closeDeptModal()" style="background:none;border:none;cursor:pointer;font-size:1.2rem;">&times;</button>
    </div>
    <form id="editForm" method="post" action="/admin/departements/update">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="edit_d_id">
      <div style="padding:1rem;">
          <div class="f-group">
            <label class="f-label">Nom</label>
            <input type="text" name="nom" id="edit_d_nom" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Description</label>
            <input type="text" name="description" id="edit_d_desc" class="f-input">
          </div>
          <div style="margin-top:1rem;">
             <button type="submit" class="btn-forest" style="padding:8px 16px;">Mettre à jour</button>
             <button type="button" class="btn-outline" style="padding:8px 16px;margin-left:5px;" onclick="closeDeptModal()">Annuler</button>
          </div>
      </div>
    </form>
  </div>
</div>
<script>
function openDeptModal(id, nom, desc) {
    document.getElementById('edit_d_id').value = id;
    document.getElementById('edit_d_nom').value = nom;
    document.getElementById('edit_d_desc').value = desc;
    document.getElementById('editDeptModal').style.display = 'flex';
}
function closeDeptModal() {
    document.getElementById('editDeptModal').style.display = 'none';
}
</script>
<?= $this->endSection() ?>