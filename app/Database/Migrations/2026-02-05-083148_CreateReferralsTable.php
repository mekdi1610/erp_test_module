<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReferralsTable extends Migration
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
            'referral_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'comment'    => 'health, psychosocial, legal',
            ],
            'referred_to' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'referral_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'pending',
            ],
            'outcome' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'high_risk' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'next_follow_up_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
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
        $this->forge->createTable('referrals');
    }

    public function down()
    {
        $this->forge->dropTable('referrals');
    }
}
