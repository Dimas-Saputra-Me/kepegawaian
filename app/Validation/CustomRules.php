<?php

namespace App\Validation;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

class CustomRules
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Cek apakah value ada di tabel tertentu (misal: Departemen.id)
     * Usage: existsInTable[Departemen.id]
     */
    public function existsInTable(string $str, string $fields, array $data, ?string &$error = null): bool
    {
        [$table, $column] = explode('.', $fields);

        $exists = $this->db->table($table)
            ->where($column, $str)
            ->countAllResults() > 0;

        if (!$exists) {
            $error = "Data value $str not found in table $table.";
        }

        return $exists;
    }

    /**
     * Cek apakah banyak value (comma separated) ada di tabel tertentu
     * Usage: existsInTableMulti[Keahlian.id]
     */
    public function existsInTableMulti($value, string $fields, array $data, ?string &$error = null): bool
    {
        [$table, $column] = explode('.', $fields);

        // Jika value berupa array (dari form multiselect)
        if (is_array($value)) {
            $ids = array_filter($value);
        } else {
            // Kalau string "1,2,3"
            $ids = array_filter(array_map('trim', explode(',', (string)$value)));
        }

        if (empty($ids)) {
            $error = "Field must be filled with at least 1 ID.";
            return false;
        }

        // Hitung yang ada di DB
        $found = $this->db->table($table)
            ->whereIn($column, $ids)
            ->countAllResults();

        if ($found !== count($ids)) {
            $error = "Some id are invalid in the table $table.";
            return false;
        }

        return true;
    }

}
