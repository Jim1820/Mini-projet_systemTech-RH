<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index', ['filter' => 'auth']);

$routes->get('/', 'Home::index', ['filter' => 'auth']);

// Auth
$routes->group('auth', static function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->post('login', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout');
});

// Employé
$routes->group('employe', ['filter' => ['auth', 'role:employe']], static function ($routes) {
    $routes->get('/', 'EmployeController::dashboard');
    $routes->get('demande', 'EmployeController::nouvelleDemande');
    $routes->post('demande/save', 'EmployeController::sauvegarderDemande');
    $routes->get('mes-demandes', 'EmployeController::mesDemandes');
    $routes->post('annuler-demande/(:num)', 'EmployeController::annulerDemande/$1');
    $routes->get('profil', 'EmployeController::profil');
    $routes->post('profil/update', 'EmployeController::updateProfil');
});

// RH
$routes->group('rh', ['filter' => ['auth', 'role:rh']], static function ($routes) {
    $routes->get('/', 'RhController::demandes');
    $routes->post('approuver/(:num)', 'RhController::approuver/$1');
    $routes->post('refuser/(:num)', 'RhController::refuser/$1');
});

// Admin
$routes->group('admin', ['filter' => ['auth', 'role:admin']], static function ($routes) {
    $routes->get('/', 'AdminController::dashboard');
        $routes->get('historique', 'AdminController::historique');
    $routes->get('employes', 'AdminController::employes');
    $routes->post('employes/store', 'AdminController::storeEmploye');
});
