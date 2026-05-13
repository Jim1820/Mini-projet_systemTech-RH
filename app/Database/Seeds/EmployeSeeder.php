<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'nom' => 'Rakoto',
                'prenom' => 'Admin',
                'email' => 'admin@techmada.mg',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'departement_id' => 1,
                'date_embauche' => '2024-01-10',
                'actif' => 1
            ],

            [
                'nom' => 'Rabe',
                'prenom' => 'Sarah',
                'email' => 'rh@techmada.mg',
                'password' => password_hash('rh123', PASSWORD_DEFAULT),
                'role' => 'rh',
                'departement_id' => 2,
                'date_embauche' => '2024-02-01',
                'actif' => 1
            ],

            [
                'nom' => 'Jean',
                'prenom' => 'Michel',
                'email' => 'jean@techmada.mg',
                'password' => password_hash('emp123', PASSWORD_DEFAULT),
                'role' => 'employe',
                'departement_id' => 1,
                'date_embauche' => '2025-01-05',
                'actif' => 1
            ],

            [
                'nom' => 'Marie',
                'prenom' => 'Claire',
                'email' => 'marie@techmada.mg',
                'password' => password_hash('emp123', PASSWORD_DEFAULT),
                'role' => 'employe',
                'departement_id' => 3,
                'date_embauche' => '2025-03-10',
                'actif' => 1
            ]
        ];

        $this->db->table('employes')->insertBatch($data);
    }
}