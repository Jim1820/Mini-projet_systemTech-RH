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
      <li><a href="/admin/departements"><i class="bi bi-building"></i> Départements</a></li>
      <li><a href="/admin/types" class="active"><i class="bi bi-tags"></i> Types de congé</a></li>
    </ul>
</aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
<div>
  <div class="topbar-title">Gestion des Types de Congé</div>
  <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Types</div>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="form-section">
  <h3><i class="bi bi-tag" style="color:var(--forest);margin-right:6px"></i>Ajouter un Type</h3>
  <form action="/admin/types" method="post">
    <?= csrf_field() ?>
    <div class="form-grid-2" style="margin-bottom:1rem">
      <div class="f-group">
        <label class="f-label">Libellé</label>
        <input type="text" name="libelle" class="f-input" required>
      </div>
      <div class="f-group">
        <label class="f-label">Jours alloués (par an)</label>
        <input type="number" name="jours_alloues" class="f-input" min="1" value="30" required>
      </div>
      <div class="f-group">
        <label class="f-label">Description</label>
        <input type="text" name="description" class="f-input">
      </div>
      <div class="f-group" style="display:flex;align-items:center;gap:10px;margin-top:1.5rem;">
        <input type="checkbox" name="est_deductible" id="add_est_deductible" value="1" checked>
        <label for="add_est_deductible" style="font-weight:500;font-size:0.9rem;">Est déductible du solde</label>
      </div>
    </div>
    <button type="submit" class="btn-forest" style="padding:8px 16px">Sauvegarder</button>
  </form>
</div>

<div class="data-card">
  <div class="data-card-head">
    <h3>Types de congés existants</h3>
  </div>
  <table class="tbl">
    <thead>
      <tr>
        <th>Libellé</th>
        <th>Jours</th>
        <th>Type</th>
        <th>Statut</th>
        <th style="width:100px;text-align:right">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($types as $t): ?>
      <tr>
        <td><strong><?= esc($t['libelle']) ?></strong></td>
        <td><?= esc($t['jours_alloues']) ?></td>
        <td><?= $t['est_deductible'] ? '<span style="color:var(--forest);font-size:0.8rem">Déductible</span>' : '<span style="color:var(--amber);font-size:0.8rem">Spécial (non déduit)</span>' ?></td>
        <td><span class="statut s-<?= esc(str_replace('_', '-', $t['statut'])) ?>"><?= esc($t['statut']) ?></span></td>
        <td style="text-align:right">
            <div style="display:flex;gap:5px;justify-content:flex-end">
                <button type="button" class="btn-sm btn-edit" onclick="openTypeModal(<?= $t['id'] ?>, '<?= esc(addslashes($t['libelle'])) ?>', <?= $t['jours_alloues'] ?>, '<?= esc(addslashes($t['description'])) ?>', <?= $t['est_deductible'] ?>)"><i class="bi bi-pencil"></i></button>
                <?php if ($t['statut'] === 'inactif'): ?>
                    <form action="/admin/types/reactivate/<?= $t['id'] ?>" method="post" style="display:inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-sm btn-view"><i class="bi bi-arrow-counterclockwise"></i></button>
                    </form>
                <?php else: ?>
                    <form action="/admin/types/deactivate/<?= $t['id'] ?>" method="post" style="display:inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-sm btn-del" onclick="return confirm('Désactiver ce type ?')"><i class="bi bi-slash-circle"></i></button>
                    </form>
                <?php endif; ?>
            </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div id="editTypeModal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:999;">
  <div class="data-card" style="width:500px;max-width:90%;">
    <div class="data-card-head" style="display:flex;justify-content:space-between;">
      <h3>Modifier le type</h3>
      <button type="button" onclick="closeTypeModal()" style="background:none;border:none;cursor:pointer;font-size:1.2rem;">&times;</button>
    </div>
    <form id="editTypeForm" method="post" action="/admin/types/update">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="edit_t_id">
      <div style="padding:1rem;">
          <div class="f-group">
            <label class="f-label">Libellé</label>
            <input type="text" name="libelle" id="edit_t_lib" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Jours alloués</label>
            <input type="number" name="jours_alloues" id="edit_t_jours" min="1" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Description</label>
            <input type="text" name="description" id="edit_t_desc" class="f-input">
          </div>
          <div class="f-group" style="display:flex;align-items:center;gap:10px;margin-top:1.5rem;">
            <input type="checkbox" name="est_deductible" id="edit_t_deductible" value="1">
            <label for="edit_t_deductible" style="font-weight:500;font-size:0.9rem;">Est déductible du solde</label>
          </div>
          <div style="margin-top:1rem;">
             <button type="submit" class="btn-forest" style="padding:8px 16px;">Mettre à jour</button>
             <button type="button" class="btn-outline" style="padding:8px 16px;margin-left:5px;" onclick="closeTypeModal()">Annuler</button>
          </div>
      </div>
    </form>
  </div>
</div>
<script>
function openTypeModal(id, lib, jours, desc, deduct) {
    document.getElementById('edit_t_id').value = id;
    document.getElementById('edit_t_lib').value = lib;
    document.getElementById('edit_t_jours').value = jours;
    document.getElementById('edit_t_desc').value = desc;
    document.getElementById('edit_t_deductible').checked = deduct == 1;
    document.getElementById('editTypeModal').style.display = 'flex';
}
function closeTypeModal() {
    document.getElementById('editTypeModal').style.display = 'none';
}
</script>
<?= $this->endSection() ?>
