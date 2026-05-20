<?php
$file = 'app/Views/admin/dashboard.php';
$content = file_get_contents($file);

$chartHtml = <<<'HTML'
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
HTML;

$content = str_replace('<div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">', $chartHtml . "\n" . '      <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">', $content);

$scriptHtml = <<<'HTML'
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
HTML;

$content = str_replace('<?= $this->endSection() ?>', $scriptHtml . "\n" . '<?= $this->endSection() ?>', $content);
file_put_contents($file, $content);
