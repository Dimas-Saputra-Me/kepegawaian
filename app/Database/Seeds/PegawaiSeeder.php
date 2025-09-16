<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PegawaiSeeder extends Seeder
{
    public function run()
    {
        $file = APPPATH . 'Database/Seeds/data/pegawai.xlsx';
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
                'name'   => $row[1],
                'gender' => $row[2],
                'departemenid' => $row[3],
                'address' => $row[4],
                'keahlian' => $row[5],
                'active' => $row[6] ?? 1,
            ];
        }

        $this->db->table('pegawai')->insertBatch($data);
    }
}
