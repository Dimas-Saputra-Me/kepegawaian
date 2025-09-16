<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class LaporanController extends Controller
{
    public function index()
    {
        $benarSemua     = $this->jumlahPegawaiLulus();
        $rataRata       = $this->rataRataNilai();
        $statPertanyaan = $this->statPertanyaan();

        return view('laporan/index', [
            'benarSemua'     => $benarSemua,
            'rataRata'       => $rataRata,
            'statPertanyaan' => $statPertanyaan,
        ]);
    }

    /**
     * 1. Jumlah pegawai dengan jawaban 100% benar
     */
    private function jumlahPegawaiLulus()
    {
        $db = Database::connect();

        // Semua pertanyaan aktif
        $totalPertanyaan = $db->table('Question')
            ->where('active', 1)
            ->countAllResults();

        $pegawai = $db->query("
            SELECT p.id
            FROM Pegawai p
            JOIN Jawaban_Pegawai jp ON jp.pegawaiid = p.id AND jp.active = 1
            WHERE p.active = 1
            GROUP BY p.id
        ")->getResultArray();

        $lulus = 0;
        foreach ($pegawai as $pg) {
            $nilai = $this->hitungNilaiPegawai($pg['id'], $totalPertanyaan);
            if ($nilai == 100) {
                $lulus++;
            }
        }

        return $lulus;
    }

    /**
     * 2. Rata-rata nilai pegawai
     */
    private function rataRataNilai()
    {
        $db = Database::connect();
        $totalPertanyaan = $db->table('Question')
            ->where('active', 1)
            ->countAllResults();

        $pegawai = $db->query("
            SELECT p.id
            FROM Pegawai p
            JOIN Jawaban_Pegawai jp ON jp.pegawaiid = p.id AND jp.active = 1
            WHERE p.active = 1
            GROUP BY p.id
        ")->getResultArray();

        $totalNilai = 0;
        $jumlah     = count($pegawai);

        foreach ($pegawai as $pg) {
            $totalNilai += $this->hitungNilaiPegawai($pg['id'], $totalPertanyaan);
        }

        return $jumlah > 0 ? round($totalNilai / $jumlah, 2) : 0;
    }

    /**
     * 3. Pertanyaan + total pegawai yang jawab benar
     */
    private function statPertanyaan()
    {
        $db = Database::connect();

        $pertanyaan = $db->table('Question')
            ->where('active', 1)
            ->get()->getResultArray();

        $stat = [];
        foreach ($pertanyaan as $q) {
            $benar = 0;

            // Detail Jawaban tiap pertanyaan
            $jawaban = $db->table('Detail_Jawaban_Pegawai d')
                ->select('jp.pegawaiid, d.answer')
                ->join('Jawaban_Pegawai jp', 'jp.id = d.jawabanpegawaiid')
                ->where('jp.active', 1)
                ->where('d.questionid', $q['id'])
                ->get()->getResultArray();

            // Cek apakah jawaban benar
            foreach ($jawaban as $j) {
                if ($this->cekJawabanBenar($q['id'], $j['answer'])) {
                    $benar++;
                }
            }

            $stat[] = [
                'question'     => $q['question'],
                'jumlah_benar' => $benar,
            ];
        }

        return $stat;
    }

    /**
     * Helper: Hitung nilai pegawai
     */
    private function hitungNilaiPegawai($pegawaiId, $totalPertanyaan)
    {
        $db = Database::connect();

        $jawaban = $db->table('Detail_Jawaban_Pegawai d')
            ->select('d.questionid, d.answer')
            ->join('Jawaban_Pegawai jp', 'jp.id = d.jawabanpegawaiid')
            ->where('jp.pegawaiid', $pegawaiId)
            ->where('jp.active', 1)
            ->get()->getResultArray();

        $benar = 0;
        foreach ($jawaban as $j) {
            if ($this->cekJawabanBenar($j['questionid'], $j['answer'])) {
                $benar++;
            }
        }

        return $totalPertanyaan > 0 ? ($benar / $totalPertanyaan) * 100 : 0;
    }

    /**
     * Helper: Cek jika jawaban benar
     */
    private function cekJawabanBenar($questionId, $answerString)
    {
        $db = Database::connect();

        // Jawaban pegawai
        $idsPegawai = array_filter(explode(',', $answerString));

        // Jawaban benar
        $idsBenar = $db->table('Answer')
            ->select('id')
            ->where('questionid', $questionId)
            ->where('isanswer', 1)
            ->get()->getResultArray();

        $idsBenar = array_column($idsBenar, 'id');

        // Benar jika sama
        sort($idsPegawai);
        sort($idsBenar);

        return $idsPegawai == $idsBenar;
    }
}
