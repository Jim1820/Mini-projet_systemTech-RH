<?php
$file = 'app/Config/Routes.php';
$content = file_get_contents($file);

$routesAdd = <<<ROUTES
    // Départements Actions
    \$routes->get('departements', 'AdminController::departements');
    \$routes->post('departements', 'AdminController::storeDepartement');
    \$routes->post('departements/update', 'AdminController::updateDepartement');
    \$routes->post('departements/deactivate/(:num)', 'AdminController::deactivateDepartement/\$1');
    \$routes->post('departements/reactivate/(:num)', 'AdminController::reactivateDepartement/\$1');

    // Types Congés Actions
    \$routes->get('types', 'AdminController::types');
    \$routes->post('types', 'AdminController::storeType');
    \$routes->post('types/update', 'AdminController::updateType');
    \$routes->post('types/deactivate/(:num)', 'AdminController::deactivateType/\$1');
    \$routes->post('types/reactivate/(:num)', 'AdminController::reactivateType/\$1');
ROUTES;

$content = str_replace('// Gestion des employés', $routesAdd . "\n    // Gestion des employés", $content);
file_put_contents($file, $content);
