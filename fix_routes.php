<?php
$file = 'app/Config/Routes.php';
$content = file_get_contents($file);

$routesAdd = <<<ROUTES
    // Employés Actions
    \$routes->post('employes/update', 'AdminController::updateEmploye');
    \$routes->post('employes/deactivate/(:num)', 'AdminController::deactivateEmploye/\$1');
    \$routes->post('employes/reactivate/(:num)', 'AdminController::reactivateEmploye/\$1');
ROUTES;

$content = str_replace('// Gestion des employés', $routesAdd . "\n" . '    // Gestion des employés', $content);
file_put_contents($file, $content);
