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
      <li><a href="/admin/employes" class="active"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="/admin/employes"><i class="bi bi-building"></i> Départements</a></li>
      <li><a href="/admin/employes"><i class="bi bi-tags"></i> Types de congé</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar" style="background:#5a2d82;width:32px;height:32px;font-size:.7rem">AD</div>
        <div><div class="user-name">Administrateur</div><div class="user-role">Admin système</div></div>
      </div>
    </div>
  </aside>

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
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>

      <div>
        <div class="topbar-title">Gestion des employés</div>
        <div class="topbar-breadcrumb"><a href="/admin">Admin</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Employés</div>
      </div>
      <div class="topbar-actions">
        <a href="javascript:void(0);" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i> Ajouter</a>
      </div>
    

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
<?= $this->endSection() ?>

<?= $this->section('content') ?>


      <!-- Formulaire ajout -->
<form action="/admin/employes" method="post">
<?= csrf_field() ?>
      <div class="form-section">
        <h3><i class="bi bi-person-plus" style="color:var(--forest);margin-right:6px"></i>Ajouter un employé</h3>
        <div class="form-grid-2" style="margin-bottom:1rem">
          <div class="f-group">
            <label class="f-label">Prénom</label>
            <input type="text" name="prenom" class="f-input" placeholder="Jean" value="<?= set_value('prenom') ?>">
            <?php if (isset($validation) && $validation->getError('prenom')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError('prenom')) ?></small>
            <?php endif; ?>
          </div>
          <div class="f-group">
            <label class="f-label">Nom</label>
            <input type="text" name="nom" class="f-input" placeholder="Rakoto" value="<?= set_value('nom') ?>">
            <?php if (isset($validation) && $validation->getError('nom')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError('nom')) ?></small>
            <?php endif; ?>
          </div>
          <div class="f-group">
            <label class="f-label">Email</label>
            <input type="email" name="email" class="f-input" placeholder="jean.rakoto@techmada.mg" value="<?= set_value('email') ?>">
            <?php if (isset($validation) && $validation->getError('email')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError('email')) ?></small>
            <?php endif; ?>
          </div>
          <div class="f-group">
            <label class="f-label">Mot de passe initial</label>
            <input type="password" name="password" class="f-input" placeholder="À communiquer à l'employé" value="<?= set_value('password') ?>">
            <?php if (isset($validation) && $validation->getError('password')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError('password')) ?></small>
            <?php endif; ?>
          </div>
          <div class="f-group">
            <label class="f-label">Département</label>
            <select class="f-select">
              <option>IT</option>
              <option>Finance</option>
              <option>Marketing</option>
              <option>RH</option>
            </select>
          </div>
          <div class="f-group">
            <label class="f-label">Rôle</label>
            <select class="f-select">
              <option value="employe">Employé</option>
              <option value="rh">Responsable RH</option>
              <option value="admin">Administrateur</option>
            </select>
          </div>
          <div class="f-group">
            <label class="f-label">Date d'embauche</label>
            <input type="date" name="date_embauche" class="f-input" value="<?= set_value('date_embauche') ?>">
            <?php if (isset($validation) && $validation->getError('date_embauche')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;"><?= esc((string) $validation->getError('date_embauche')) ?></small>
            <?php endif; ?>
          </div>
        </div>
        <div class="flash flash-info" style="margin-bottom:1rem">
          <i class="bi bi-info-circle-fill"></i>
          <span style="font-size:.82rem">Les soldes de congés seront initialisés automatiquement selon les types de congé configurés.</span>
        </div>
        <div class="form-actions">
          <button class="btn-forest"><i class="bi bi-plus"></i> Créer l'employé</button>
          <button class="btn-secondary">Réinitialiser</button>
        </form>
      </div>

      <!-- Liste employés -->
      <div class="data-card">
        <div class="data-card-head">
          <h3>Tous les employés</h3>
          <div style="display:flex;gap:6px">
            <input type="text" class="f-input" placeholder="Rechercher..." style="width:200px;padding:6px 10px;font-size:.8rem">
            <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
              <option>Tous les depts</option>
              <option>IT</option>
              <option>Finance</option>
            </select>
          </div>
        </div>
        <table class="tbl">
          <thead>
            <tr><th>Employé</th><th>Département</th><th>Rôle</th><th>Embauche</th><th>Statut</th><th>Solde annuel</th><th>Actions</th></tr>
          </thead>
          <tbody>
            <?php if (!empty($employes)): ?>
              <?php foreach ($employes as $employe): ?>
              <tr <?= (isset($employe['statut']) && $employe['statut'] === 'inactif') ? 'style="opacity:.5"' : '' ?>>
                <td>
                  <div class="profile-row">
                    <div class="avatar av-green" style="width:32px;height:32px;font-size:.68rem">
                      <?= strtoupper(substr($employe['prenom'] ?? '', 0, 1) . substr($employe['nom'] ?? '', 0, 1)) ?>
                    </div>
                    <div class="profile-info">
                      <div class="pname"><?= esc($employe['prenom'] . ' ' . $employe['nom']) ?></div>
                      <div class="pdept"><?= esc($employe['email']) ?></div>
                    </div>
                  </div>
                </td>
                <td class="td-muted"><?= esc($employe['dep_nom'] ?? '—') ?></td>
                <td>
                  <span class="type-badge" style="<?= $employe['role'] === 'admin' ? 'background:#f4e6e6;color:#8a2e2e' : ($employe['role'] === 'rh' ? 'background:#e6f4ea;color:#2e8a55' : 'background:#f1efe8;color:#444441') ?>">
                    <?= esc($employe['role']) ?>
                  </span>
                </td>
                <td class="td-muted td-mono" style="font-size:.78rem"><?= esc($employe['date_embauche']) ?></td>
                <td>
                  <span class="statut s-<?= esc(str_replace('_', '-', $employe['statut'] ?? 'actif')) ?>" style="font-size:.68rem">
                    <?= esc($employe['statut'] ?? 'actif') ?>
                  </span>
                </td>
                <td><span style="font-family:'DM Mono',monospace;font-size:.82rem;color:var(--forest)">— / — j</span></td>
                <td>
                  <div class="action-btns">
                    <button class="btn-sm btn-edit"><i class="bi bi-pencil"></i> Éditer</button>
                    <?php if (isset($employe['statut']) && $employe['statut'] === 'inactif'): ?>
                      <button class="btn-sm btn-view"><i class="bi bi-arrow-counterclockwise"></i></button>
                    <?php else: ?>
                      <button class="btn-sm btn-del"><i class="bi bi-slash-circle"></i></button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7">Aucun employé trouvé.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    

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
<?= $this->endSection() ?>
