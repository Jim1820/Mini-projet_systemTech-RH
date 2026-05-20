<?php
$file = 'app/Controllers/AdminController.php';
$content = file_get_contents($file);

$methods = <<<'METHODS'
    // --- HISTORIQUE GLOBAL ---
    public function historique()
    {
        $congeModel = new \App\Models\CongeModel();
        
        $demandes = $congeModel->select('conges.*, employes.nom, employes.prenom, types_conge.libelle')
                               ->join('employes', 'employes.id = conges.employe_id')
                               ->join('types_conge', 'types_conge.id = conges.type_conge_id')
                               ->orderBy('conges.created_at', 'DESC')
                               ->findAll();

        return view('admin/historique', [
            'demandes' => $demandes
        ]);
    }
METHODS;

$content = preg_replace('/}(?=\s*$)/', "\n" . $methods . "\n}", $content);
file_put_contents($file, $content);

$routesFile = 'app/Config/Routes.php';
$routesContent = file_get_contents($routesFile);
$routesContent = str_replace(
    '$routes->get(\'/\', \'AdminController::dashboard\');',
    '$routes->get(\'/\', \'AdminController::dashboard\');' . "\n" . '        $routes->get(\'historique\', \'AdminController::historique\');',
    $routesContent
);
file_put_contents($routesFile, $routesContent);
