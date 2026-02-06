<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBeneficiaryProgressUpdatesTable extends Migration
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
            'progress_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'domain' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'comment'    => 'education, health, livelihood, nutrition, income, general',
                'null'       => true,
            ],
            'status_summary' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'score' => [
                'type'     => 'INT',
                'null'     => true,
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
        $this->forge->createTable('beneficiary_progress_updates');
    }

    public function down()
    {
        $this->forge->dropTable('beneficiary_progress_updates');
    }
}
