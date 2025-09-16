<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailJawabanPegawaiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'auto_increment' => true],
            'jawabanpegawaiid' => ['type' => 'INT', 'null' => false],
            'questionid'       => ['type' => 'INT','null' => false],
            'answer'           => ['type' => 'VARCHAR','constraint' => 100,'null' => false, 'comment' => 'Menyimpan jawaban-jawaban dengan pembatas koma'],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('jawabanpegawaiid', 'jawaban_pegawai', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('questionid', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_jawaban_pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('detail_jawaban_pegawai');
    }
}
