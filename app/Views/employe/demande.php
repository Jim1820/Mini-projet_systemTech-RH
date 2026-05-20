<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="/employe"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="/employe/demande" class="active"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="/employe/mes-demandes"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
      <li><a href="/employe"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-green">SR</div>
        <div><div class="user-name">Soa Rakoto</div><div class="user-role">Employé · IT</div></div>
      </div>
    </div>
  </aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>

      <div>
        <div class="topbar-title">Nouvelle demande de congé</div>
        <div class="topbar-breadcrumb">
          <a href="/employe">Accueil</a>
          <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Nouvelle demande
        </div>
      </div>
    
<?= $this->endSection() ?>

<?= $this->section('content') ?>


      <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start" class="form-layout">

        <!-- Formulaire principal -->
        <div>
          <form action="/employe/demande/save" method="post" class="form-section">
<?= csrf_field() ?>
            <h3>Détails de la demande</h3>

            <div class="f-group" style="margin-bottom:1rem">
              <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
              <select class="f-select" name="type_conge_id">
                <option value="">-- Choisir un type --</option>
                <?php foreach ($types_conge ?? [] as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= set_select('type_conge_id', $t['id']) ?>><?= esc($t['libelle']) ?></option>
                <?php endforeach; ?>
              </select>
              <?php if (isset($validation) && $validation->getError('type_conge_id')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                    <?= esc((string) $validation->getError('type_conge_id')) ?>
                </small>
              <?php endif; ?>
            </div>

            <div class="form-grid-2" style="margin-bottom:1rem">
              <div class="f-group">
                <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
                <input type="date" name="date_debut" class="f-input" value="<?= set_value('date_debut') ?>">
              <?php if (isset($validation) && $validation->getError('date_debut')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                    <?= esc((string) $validation->getError('date_debut')) ?>
                </small>
              <?php endif; ?>
              </div>
              <div class="f-group">
                <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
                <input type="date" name="date_fin" class="f-input" value="<?= set_value('date_fin') ?>">
              <?php if (isset($validation) && $validation->getError('date_fin')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                    <?= esc((string) $validation->getError('date_fin')) ?>
                </small>
              <?php endif; ?>
              </div>
            </div>

            <!-- Calcul automatique côté PHP (affiché après soumission ou en JS) -->
            <div class="f-computed">
              <div class="f-computed-num">5</div>
              <div class="f-computed-label">jours calendaires calculés<br><span style="font-size:.7rem;opacity:.7">du lundi 23 au vendredi 27 juin 2025</span></div>
            </div>

            <div class="f-group" style="margin-bottom:1rem">
              <label class="f-label">Motif (optionnel)</label>
              <textarea name="motif" class="f-textarea" placeholder="Précisez le motif de votre demande si nécessaire..."><?= set_value('motif') ?></textarea>
              <?php if (isset($validation) && $validation->getError('motif')) : ?>
                <small style="color:#dc3545; display:block; margin-top:0.25rem; font-size:0.8rem;">
                    <?= esc((string) $validation->getError('motif')) ?>
                </small>
              <?php endif; ?>
              <div class="f-hint">Le motif est visible par le responsable RH.</div>
            </div>

            <div class="form-actions">
              <button class="btn-forest" type="submit"><i class="bi bi-send"></i> Soumettre la demande</button>
              <a href="/employe" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
            </div>
          </div>
        </div>

        <!-- Panneau latéral : solde & règles -->
        <div style="display:flex;flex-direction:column;gap:1rem">
          <div class="data-card" style="margin:0">
            <div class="data-card-head"><h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3></div>
            <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
              <?php if (!empty($soldes)): ?>
                <?php foreach ($soldes as $solde): 
                  $restant = $solde['jours_attribues'] - $solde['jours_pris'];
                  $percent = $solde['jours_attribues'] > 0 ? ($restant / $solde['jours_attribues']) * 100 : 0;
                  $isWarn = $percent <= 20;
                ?>
                <div>
                  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                    <span style="font-size:.8rem;color:var(--ink)"><?= esc($solde['libelle']) ?></span>
                    <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:<?= $isWarn ? 'var(--warn)' : 'var(--forest)' ?>;font-weight:500"><?= esc($restant) ?> j</span>
                  </div>
                  <div class="solde-bar"><div class="solde-fill <?= $isWarn ? 'warn' : '' ?>" style="width:<?= esc($percent) ?>%"></div></div>
                </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Aucun solde trouvé.</p>
              <?php endif; ?>
            </div>
          </div>
          <div class="flash flash-info" style="margin:0">
            <i class="bi bi-info-circle-fill"></i>
            <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
          </div>
          <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
            <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem"><i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles</div>
            <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
              <li>Préavis minimum : 48h avant la date de début</li>
              <li>Pas de chevauchement avec une demande en cours</li>
              <li>Solde insuffisant = demande refusée automatiquement</li>
            </ul>
          </div>
        </div>

      </div>
    
<?= $this->endSection() ?>
