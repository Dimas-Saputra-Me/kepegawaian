<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        $file = APPPATH . 'Database/Seeds/data/answer.xlsx';
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
                'questionid'   => $row[1],
                'text' => $row[2],
                'isanswer' => $row[3],
                'active' => $row[3] ?? 1,
            ];
        }

        $this->db->table('answer')->insertBatch($data);
    }
}
