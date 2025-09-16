<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'gender'      => ['type' => 'VARCHAR', 'constraint' => 1, 'null' => false, 'comment' => 'W: Wanita, P: Pria'],
            'departemenid'=> ['type' => 'INT', 'null' => false],
            'address'     => ['type' => 'VARCHAR', 'constraint' => 200, 'null' => true],
            'keahlian'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true, 'comment' => 'Menyimpan ID dengan pembatas koma'],
            'active'      => ['type' => 'INT', 'default' => 1, 'comment' => '1: Aktif, 2: Non Aktif'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('departemenid', 'departemen', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}
