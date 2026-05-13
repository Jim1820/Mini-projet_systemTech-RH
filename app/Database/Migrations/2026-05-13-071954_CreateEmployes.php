<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmployes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INTEGER',
                'auto_increment' => true
            ],
            'nom' => [
                'type' => 'TEXT'
            ],
            'prenom' => [
                'type' => 'TEXT'
            ],
            'email' => [
                'type'   => 'TEXT',
                'unique' => true
            ],
            'password' => [
                'type' => 'TEXT'
            ],
            'role' => [
                'type' => 'TEXT'
            ],
            'departement_id' => [
                'type' => 'INTEGER',
                'null' => true
            ],
            'date_embauche' => [
                'type' => 'DATE'
            ],
            'actif' => [
                'type'    => 'INTEGER',
                'default' => 1
            ]
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey(
            'departement_id',
            'departements',
            'id',
            'CASCADE',
            'SET NULL'
        );

        $this->forge->createTable('employes');
    }

    public function down()
    {
        $this->forge->dropTable('employes');
    }
}