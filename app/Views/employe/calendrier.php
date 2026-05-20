<?= $this->extend('layout/app') ?>

<?= $this->section('sidebar') ?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="/employe"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="/employe/demande"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="/employe/mes-demandes"><i class="bi bi-card-list"></i> Mes demandes</a></li>
      <li><a href="/employe/calendrier" class="active"><i class="bi bi-calendar3"></i> Vue Calendrier</a></li>
      <li><a href="/employe"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
  </aside>
<?= $this->endSection() ?>

<?= $this->section('topbar') ?>
    <div>
      <div class="topbar-title">Vue Calendrier</div>
      <div class="topbar-breadcrumb"><a href="/employe">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Calendrier</div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="data-card">
        <div class="data-card-head">
            <h3>Mes Congés (Vue Hebdomadaire & Mensuelle)</h3>
        </div>
        <div style="padding: 1rem;">
            <div id="calendar"></div>
        </div>
    </div>

    <!-- FullCalendar JS Offline -->
    <script src="/assets/js/fullcalendar.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var eventsData = <?= $eventsJson ?? '[]' ?>;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                events: eventsData
            });

            calendar.render();
        });
    </script>
<?= $this->endSection() ?>
