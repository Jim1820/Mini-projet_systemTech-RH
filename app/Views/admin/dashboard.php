<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon" style="background:var(--ink);border:1px solid rgba(255,255,255,.15)"><i class="bi bi-shield-check" style="color:var(--leaf)"></i></div>
      <div class="sidebar-brand-name">TechMada RH
        <span>Administration</span>
      </div>
    </div>
    <div class="sidebar-section">Gestion</div>
    <ul class="sidebar-nav">
      <li><a href="/admin" class="active"><i class="bi bi-speedometer2"></i> Vue d'ensemble</a></li>
      <li>
        <a href="/rh">
          <i class="bi bi-inbox"></i> Toutes les demandes
        </a>
      </li>
      <li><a href="/admin/employes"><i class="bi bi-people"></i> Employés</a></li>
      <li><a href="/admin/employes"><i class="bi bi-building"></i> Départements</a></li>
      <li><a href="/admin/employes"><i class="bi bi-tags"></i> Types de congé</a></li>
      <li><a href="/admin/employes"><i class="bi bi-sliders"></i> Soldes annuels</a></li>
    </ul>
</aside>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
      <div>
        <div class="topbar-title">Vue d'ensemble</div>
        <div class="topbar-breadcrumb">Administration</div>
      </div>
      <div class="topbar-actions">
        <a href="/admin/employes" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-person-plus"></i> Ajouter un employé</a>
      </div>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

      <div class="metrics">
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-forest"><i class="bi bi-people"></i></div></div>
          <div class="metric-val"><?= esc($totalEmployes) ?></div>
          <div class="metric-label">Employés actifs</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-amber"><i class="bi bi-hourglass-split"></i></div></div>
          <div class="metric-val"><?= esc($enAttenteCount) ?></div>
          <div class="metric-label">Demandes en attente</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-green"><i class="bi bi-calendar-check"></i></div></div>
          <div class="metric-val"><?= esc($approuveesCeMois) ?></div>
          <div class="metric-label">Approuvées ce mois</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-blue"><i class="bi bi-building"></i></div></div>
          <div class="metric-val"><?= esc($departementsCount) ?></div>
          <div class="metric-label">Départements</div>
        </div>
        <div class="metric">
          <div class="metric-top"><div class="metric-icon mi-red"><i class="bi bi-person-slash"></i></div></div>
          <div class="metric-val"><?= esc($absentsAujourdhui) ?></div>
          <div class="metric-label">Absents aujourd'hui</div>
        </div>
      </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Congés par Mois</h3>
          </div>
          <div style="padding:1rem">
            <canvas id="chartMois" style="max-height:250px"></canvas>
          </div>
        </div>
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Jours de Congés</h3>
          </div>
          <div style="padding:1rem">
            <canvas id="chartJours" style="max-height:250px"></canvas>
          </div>
        </div>
      </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-bottom:1.5rem">
        
      </div>
      <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

        <!-- Demandes récentes -->
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3>Demandes récentes</h3>
            <a href="/rh" style="font-size:.8rem;color:var(--forest);text-decoration:none">Tout voir →</a>
          </div>
          <table class="tbl">
            <thead>
              <tr><th>Employé</th><th>Type</th><th>Durée</th><th>Statut</th></tr>
            </thead>
            <tbody>
              <?php if (!empty($demandes)): ?>
                <?php foreach ($demandes as $demande): ?>
                <tr>
                  <td>
                    <div style="display:flex;align-items:center;gap:7px">
                      <div class="avatar av-green" style="width:28px;height:28px;font-size:.62rem">
                        <?= strtoupper(substr($demande['prenom'] ?? '', 0, 1) . substr($demande['nom'] ?? '', 0, 1)) ?>
                      </div>
                      <span class="td-name" style="font-size:.84rem"><?= esc($demande['prenom'] . ' ' . $demande['nom']) ?></span>
                    </div>
                  </td>
                  <td><span class="type-badge t-<?= strtolower(url_title($demande['libelle'] ?? '')) ?>"><?= esc($demande['libelle'] ?? '') ?></span></td>
                  <td class="td-mono"><?= esc($demande['nb_jours']) ?> j</td>
                  <td><span class="statut s-<?= esc(str_replace('_', '-', $demande['statut'])) ?>"><?= str_replace('_', ' ', esc($demande['statut'])) ?></span></td>
                </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4">Aucune demande récente.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

        <div style="display:flex;flex-direction:column;gap:1rem">
          <div class="data-card" style="margin:0">
            <div class="data-card-head"><h3><i class="bi bi-person-slash" style="color:var(--muted);margin-right:5px"></i>Absents aujourd'hui</h3></div>
            <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.6rem">
                <?php if (!empty($absentsList)): ?>
                    <?php foreach ($absentsList as $absent): ?>
                      <div style="display:flex;align-items:center;gap:8px">
                        <div class="avatar av-green" style="width:30px;height:30px;font-size:.65rem">
                            <?= strtoupper(substr($absent['prenom'] ?? '', 0, 1) . substr($absent['nom'] ?? '', 0, 1)) ?>
                        </div>
                        <div><div style="font-size:.83rem;font-weight:500;color:var(--ink)"><?= esc($absent['prenom'] . ' ' . $absent['nom']) ?></div><div style="font-size:.72rem;color:var(--muted)"><?= esc($absent['libelle']) ?> · retour <?= date('d/m', strtotime($absent['date_fin'] . ' +1 day')) ?></div></div>
                      </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="font-size:0.8rem; color: #555;">Aucun absent aujourd'hui.</p>
                <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<script src="/assets/js/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dataMois = <?= $chartDataMois ?? '{"labels":[], "data":[]}' ?>;
    const dataJours = <?= $chartDataJours ?? '{"labels":[], "data":[]}' ?>;

    new Chart(document.getElementById('chartMois'), {
        type: 'bar',
        data: {
            labels: dataMois.labels,
            datasets: [{
                label: 'Nombre de congés',
                data: dataMois.data,
                backgroundColor: '#3498db',
                borderRadius: 4
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    new Chart(document.getElementById('chartJours'), {
        type: 'doughnut',
        data: {
            labels: dataJours.labels,
            datasets: [{
                data: dataJours.data,
                backgroundColor: ['#e74c3c', '#e67e22', '#f1c40f', '#2ecc71', '#3498db', '#9b59b6', '#34495e']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
<?= $this->endSection() ?>
