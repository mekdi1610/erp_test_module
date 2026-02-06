<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInterventionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'service_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'comment'    => 'Cash assistance, Food aid, IGA, Training, Education, Health services',
            ],
            'description' => [
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
        $this->forge->addForeignKey('project_id', 'projects', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('interventions');
    }

    public function down()
    {
        $this->forge->dropTable('interventions');
    }
}
