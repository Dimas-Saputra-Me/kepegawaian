<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DepartemenModel;
use App\Models\KeahlianModel;
use App\Models\PegawaiModel;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
{
    public function index()
    {
        $pegawaiModel = new PegawaiModel();
        $departemenModel = new DepartemenModel();
        $keahlianModel = new KeahlianModel();
        $db = db_connect();

        // Statistik Card
        $data['countPegawai'] = $pegawaiModel->countAll();
        $data['countDepartemen'] = $departemenModel->countAll();
        $data['countKeahlian'] = $keahlianModel->countAll();

        // Statistik Gender
        $gender = $db->table('pegawai')
                     ->select('gender, COUNT(*) as total')
                     ->groupBy('gender')
                     ->get()
                     ->getResultArray();
        $data['genderLabels'] = array_map(fn($g)=> $g['gender']=='P'?'Pria':'Wanita', $gender);
        $data['genderData'] = array_map(fn($g)=> (int)$g['total'], $gender);

        // Pegawai per departemen
        $departemenCount = $db->table('pegawai p')
                              ->select('d.name, COUNT(p.id) as total')
                              ->join('departemen d','d.id = p.departemenid','left')
                              ->groupBy('d.name')
                              ->get()
                              ->getResultArray();
        $data['departemenLabels'] = array_column($departemenCount,'name');
        $data['departemenData'] = array_map(fn($d)=> (int)$d['total'], $departemenCount);

        return view('dashboard/index', $data);
    }
}
