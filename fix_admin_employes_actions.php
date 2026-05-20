<?php
$file = 'app/Views/admin/employes.php';
$content = file_get_contents($file);

$tableRowActions = <<<'HTML'
                  <div style="display:flex;gap:5px">
                    <button type="button" class="btn-sm btn-edit" onclick="openEditModal(<?= $employe['id'] ?>, '<?= esc($employe['prenom']) ?>', '<?= esc($employe['nom']) ?>', '<?= esc($employe['email']) ?>', '<?= esc($employe['departement_id'] ?? '') ?>', '<?= esc($employe['role']) ?>')"><i class="bi bi-pencil"></i> Éditer</button>
                    <?php if (isset($employe['statut']) && $employe['statut'] === 'inactif'): ?>
                      <form action="/admin/employes/reactivate/<?= $employe['id'] ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-sm btn-view" title="Réactiver"><i class="bi bi-arrow-counterclockwise"></i></button>
                      </form>
                    <?php else: ?>
                      <form action="/admin/employes/deactivate/<?= $employe['id'] ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-sm btn-del" title="Désactiver" onclick="return confirm('Voulez-vous désactiver cet employé ?');"><i class="bi bi-slash-circle"></i></button>
                      </form>
                    <?php endif; ?>
                  </div>
HTML;

$content = preg_replace('/<div style="display:flex;gap:5px">\s*<button class="btn-sm btn-edit">.*?<\/div>/s', $tableRowActions, $content);

$modalHtml = <<<'HTML'
<div id="editModal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:999;">
  <div class="data-card" style="width:500px;max-width:90%;">
    <div class="data-card-head" style="display:flex;justify-content:space-between;">
      <h3>Modifier l'employé</h3>
      <button type="button" onclick="closeEditModal()" style="background:none;border:none;cursor:pointer;font-size:1.2rem;">&times;</button>
    </div>
    <form id="editForm" method="post" action="/admin/employes/update">
      <?= csrf_field() ?>
      <input type="hidden" name="id" id="edit_id">
      <div style="padding:1rem;">
          <div class="f-group">
            <label class="f-label">Prénom</label>
            <input type="text" name="prenom" id="edit_prenom" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Nom</label>
            <input type="text" name="nom" id="edit_nom" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Email</label>
            <input type="email" name="email" id="edit_email" class="f-input" required>
          </div>
          <div class="f-group">
            <label class="f-label">Département</label>
            <select name="departement_id" id="edit_departement_id" class="f-select">
              <option value="">Sélectionner</option>
              <?php foreach($departements ?? [] as $d): ?>
              <option value="<?= $d['id'] ?>"><?= esc($d['nom']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="f-group">
            <label class="f-label">Rôle</label>
            <select name="role" id="edit_role" class="f-select">
              <option value="employe">Employé</option>
              <option value="rh">Responsable RH</option>
              <option value="admin">Administrateur</option>
            </select>
          </div>
          <div style="margin-top:1rem;">
             <button type="submit" class="btn-forest" style="padding:8px 16px;">Mettre à jour</button>
             <button type="button" class="btn-outline" style="padding:8px 16px;margin-left:5px;" onclick="closeEditModal()">Annuler</button>
          </div>
      </div>
    </form>
  </div>
</div>
<script>
function openEditModal(id, prenom, nom, email, deptId, role) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_prenom').value = prenom;
    document.getElementById('edit_nom').value = nom;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_departement_id').value = deptId;
    document.getElementById('edit_role').value = role;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>
HTML;

$content = str_replace('<?= $this->endSection() ?>', "\n" . $modalHtml . "\n<?= \$this->endSection() ?>", $content);

file_put_contents($file, $content);
echo "Actions updated.\n";
