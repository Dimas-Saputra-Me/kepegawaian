<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJawabanPegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'pegawaiid'  => ['type' => 'INT', 'null' => false],
            'active'     => ['type' => 'INT', 'default' => 1, 'comment' => '1: Aktif, 2: Non Aktif'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pegawaiid', 'pegawai', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jawaban_pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('jawaban_pegawai');
    }
}
