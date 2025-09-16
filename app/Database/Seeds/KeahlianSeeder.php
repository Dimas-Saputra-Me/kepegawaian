<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class KeahlianSeeder extends Seeder
{
    public function run()
    {
        $file = APPPATH . 'Database/Seeds/data/keahlian.xlsx';
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
                'active' => $row[2] ?? 1,
            ];
        }

        $this->db->table('keahlian')->insertBatch($data);
    }
}
