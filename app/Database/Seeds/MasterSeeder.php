<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterSeeder extends Seeder
{
    public function run()
    {
        $this->call('DepartemenSeeder');
        $this->call('KeahlianSeeder');
        $this->call('QuestionSeeder');
        $this->call('AnswerSeeder');
        $this->call('PegawaiSeeder');
        $this->call('JawabanPegawaiSeeder');
        $this->call('DetailJawabanPegawaiSeeder');
    }
}
