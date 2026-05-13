<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TypeCongeSeeder extends Seeder
{
    public function run()
    {
        $data = [

            [
                'libelle' => 'Congé annuel',
                'jours_annuels' => 30,
                'deductible' => 1
            ],

            [
                'libelle' => 'Maladie',
                'jours_annuels' => 15,
                'deductible' => 0
            ],

            [
                'libelle' => 'Sans solde',
                'jours_annuels' => 0,
                'deductible' => 0
            ]
        ];

        $this->db->table('types_conge')->insertBatch($data);
    }
}