<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnswerTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'questionid' => ['type' => 'INT', 'null' => false],
            'text'       => ['type' => 'VARCHAR', 'constraint' => 300, 'null' => false],
            'isanswer'   => ['type' => 'INT', 'default' => 0, 'comment' => '1: Yes, 0: No'],
            'active'     => ['type' => 'INT', 'default' => 1, 'comment' => '1: Aktif, 2: Non Aktif'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('questionid', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('answer');
    }

    public function down()
    {
        $this->forge->dropTable('answer');
    }
}
