<?php
$file = 'app/Controllers/AdminController.php';
$content = file_get_contents($file);

$chartLogic = <<<'PHP'
        $departementsCount = $departementModel->countAllResults();

        // Data for Charts
        $tousLesConges = $congeModel->findAll();
        
        $congesParMois = array_fill(1, 12, 0);
        $congesParJour = [
            '1' => 0, // Lundi
            '2' => 0, // Mardi
            '3' => 0, // Mercredi
            '4' => 0, // Jeudi
            '5' => 0, // Vendredi
            '6' => 0, // Samedi
            '7' => 0  // Dimanche
        ];

        foreach ($tousLesConges as $c) {
            if (empty($c['date_debut'])) continue;
            $mois = (int)date('m', strtotime($c['date_debut']));
            if(isset($congesParMois[$mois])) {
                $congesParMois[$mois]++;
            }

            $start = new \DateTime($c['date_debut']);
            $end = new \DateTime($c['date_fin']);
            $end->modify('+1 day');
            try {
                $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
                foreach ($period as $dt) {
                    $jourSemaine = $dt->format('N');
                    if(isset($congesParJour[$jourSemaine])) {
                        $congesParJour[$jourSemaine]++;
                    }
                }
            } catch (\Exception $e) {}
        }
        
        $chartDataMois = [
            'labels' => ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            'data'   => array_values($congesParMois)
        ];
        
        $chartDataJours = [
            'labels' => ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
            'data'   => array_values($congesParJour)
        ];
PHP;

$content = str_replace('$departementsCount = $departementModel->countAllResults();', $chartLogic, $content);

$viewDataFind = <<<'PHP'
            'departementsCount' => $departementsCount,
            'demandes'          => $demandes
        ]);
PHP;

$viewDataReplace = <<<'PHP'
            'departementsCount' => $departementsCount,
            'demandes'          => $demandes,
            'chartDataMois'     => json_encode($chartDataMois),
            'chartDataJours'    => json_encode($chartDataJours)
        ]);
PHP;

$content = str_replace($viewDataFind, $viewDataReplace, $content);
file_put_contents($file, $content);
