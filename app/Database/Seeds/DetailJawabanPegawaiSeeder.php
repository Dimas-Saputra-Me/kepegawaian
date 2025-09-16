<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DetailJawabanPegawaiSeeder extends Seeder
{
        public function run()
    {
        $file = APPPATH . 'Database/Seeds/data/detailjawabanpegawai.xlsx';
        if (!file_exists($file)) {
            echo "File $file tidak ditemukan!";
            return;
        }

        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $data = [];

        // main seeder
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $data[] = [
                'jawabanpegawaiid'   => $row[1],
                'questionid' => $row[2],
                'answer' => $row[3],
            ];
        }

        $this->db->table('detail_jawaban_pegawai')->insertBatch($data);
    }
}
