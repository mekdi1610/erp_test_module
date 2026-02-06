<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCaseNotesTable extends Migration
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
            'note_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'comment'    => 'social_followup, counseling, referral, general',
            ],
            'content' => [
                'type' => 'TEXT',
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'next_follow_up_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'open',
            ],
            'risk_level' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
                'comment'    => 'low, medium, high',
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
        $this->forge->createTable('case_notes');
    }

    public function down()
    {
        $this->forge->dropTable('case_notes');
    }
}
