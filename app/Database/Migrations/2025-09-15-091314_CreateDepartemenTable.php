<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDepartemenTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => ['type' => 'INT', 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'active' => ['type' => 'INT', 'default' => 1, 'comment' => '1: Active, 0: Non Active'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('departemen');
    }

    public function down()
    {
        $this->forge->dropTable('departemen');
    }
}
