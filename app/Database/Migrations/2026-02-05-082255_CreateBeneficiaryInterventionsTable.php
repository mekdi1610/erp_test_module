<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeneficiaryInterventionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'beneficiary_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'project_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'intervention_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'service_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'comment'    => 'Cash, Food, IGA, Training, Education, Health, etc.',
            ],
            'service_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('beneficiary_id', 'beneficiaries', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('intervention_id', 'interventions', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('beneficiary_interventions');
    }

    public function down()
    {
        $this->forge->dropTable('beneficiary_interventions');
    }
}
