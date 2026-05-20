<?php
$file = 'app/Controllers/EmployeController.php';
$content = file_get_contents($file);

$calendarMethod = <<<'PHP'
    public function calendrier()
    {
        $congeModel = new CongeModel();
        $userId = session()->get('user_id');

        $demandes = $congeModel->select('conges.*, types_conge.libelle')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->where('employe_id', $userId)
                               ->findAll();
        
        $events = [];
        foreach ($demandes as $d) {
            $color = '#3498db'; // default
            if ($d['statut'] == 'approuvee') $color = '#2ecc71';
            else if ($d['statut'] == 'en_attente') $color = '#f1c40f';
            else if ($d['statut'] == 'refusee') $color = '#e74c3c';
            
            $events[] = [
                'title' => $d['libelle'] . ' (' . str_replace('_', ' ', $d['statut']) . ')',
                'start' => $d['date_debut'],
                'end'   => date('Y-m-d', strtotime($d['date_fin'] . ' +1 day')), // FullCalendar exclusive end
                'color' => $color,
                'allDay'=> true
            ];
        }

        return view('employe/calendrier', [
            'eventsJson' => json_encode($events)
        ]);
    }
PHP;

$content = preg_replace('/}(?=\s*$)/', "\n" . $calendarMethod . "\n}", $content);

file_put_contents($file, $content);
