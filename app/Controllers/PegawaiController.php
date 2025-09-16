<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DepartemenModel;
use App\Models\KeahlianModel;
use App\Models\PegawaiModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PegawaiController extends ResourceController
{
    protected $modelName = PegawaiModel::class;
    protected $format    = 'html';

    protected $request;
    public function __construct()
    {
        $this->request = service("request");
    }

    // GET /pegawai
    public function index()
    {
        // cek apakah request AJAX dari DataTables
        if ($this->request->isAJAX()) {

            $builder = $this->model
                ->select('pegawai.id, pegawai.name, pegawai.gender, departemen.name as departemen_name, pegawai.address, pegawai.keahlian, pegawai.active')
                ->join('departemen', 'departemen.id = pegawai.departemenid', 'left')
                ->where('pegawai.active = 1');

            return \Hermawan\DataTables\DataTable::of($builder)
                ->addNumbering('no')
                ->add('actions', function($row){
                    $btn = '<a href="'.site_url('pegawai/'.$row->id).'" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="'.site_url('pegawai/'.$row->id.'/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="'.$row->id.'">
                                Hapus
                             </button>';
                    return $btn;
                })
                ->toJson(true);
        }

        // Jika bukan AJAX, tampilkan view biasa
        return view('pegawai/index');
    }


    // GET /pegawai/new
    public function new()
    {
        $keahlianModel = new KeahlianModel();
        $departemenModel = new DepartemenModel();

        $data = [
            'mode'       => 'create',
            'pegawai'    => null,
            'departemen' => $departemenModel->getActiveDepartemen(),
            'allKeahlian' => $keahlianModel->getActiveKeahlian(),
            'title'      => 'Tambah Pegawai'
        ];
        return view('pegawai/form', $data);
    }

    // POST /pegawai
    public function create()
    {
        // Validation
        $rules = [
            'name' => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
            'gender' => 'required|in_list[P,W]',
            'departemenid'=> 'required|integer|existsInTable[Departemen.id]',
            'address' => 'required|max_length[200]',
            'keahlian' => 'required|existsInTableMulti[Keahlian.id]',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $post = $this->request->getPost();
        $data = [
            'name'         => $post['name'],
            'gender'       => $post['gender'],
            'departemenid' => $post['departemenid'],
            'address'      => $post['address'],
            'keahlian'     => isset($post['keahlian']) ? implode(',', $post['keahlian']) : null,
            'active'       => 1
        ];

        $this->model->insert($data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Pegawai berhasil ditambahkan'
        ]);
    }

    // GET /pegawai/{id}
    public function show($id = null)
    {
        $pegawai = $this->model->getWithKeahlian($id);
        if (!$pegawai) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        return view('pegawai/show', [
            'mode'    => 'show',
            'pegawai' => $pegawai,
            'title'   => 'Detail Pegawai'
        ]);
    }

    // GET /pegawai/{id}/edit
    public function edit($id = null)
    {
        $pegawai = $this->model->getById($id);
        if (!$pegawai) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $db = db_connect();
        $keahlianModel = new KeahlianModel();
        $departemenModel = new DepartemenModel();

        $data = [
            'mode'       => 'edit',
            'pegawai'    => $pegawai,
            'departemen' => $departemenModel->getActiveDepartemen(),
            'allKeahlian'   => $keahlianModel->getActiveKeahlian(),
            'title'      => 'Edit Pegawai'
        ];
        return view('pegawai/form', $data);
    }

    // PUT /pegawai/{id}
    public function update($id = null)
    {
        // Validation
        $rules = [
            'name' => 'required|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
            'gender' => 'required|in_list[P,W]',
            'departemenid'=> 'required|integer|existsInTable[Departemen.id]',
            'address' => 'required|max_length[200]',
            'keahlian' => 'required|existsInTableMulti[Keahlian.id]',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $post = $this->request->getPost();
        $data = [
            'name'         => $post['name'],
            'gender'       => $post['gender'],
            'departemenid' => $post['departemenid'],
            'address'      => $post['address'],
            'keahlian'     => isset($post['keahlian']) ? implode(',', $post['keahlian']) : null,
        ];

        $this->model->update($id, $data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Pegawai berhasil diperbarui'
        ]);
    }

    // DELETE /pegawai/{id}
    public function delete($id = null)
    {
        $this->model->softDelete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data Pegawai berhasil dihapus'
        ]);
    }

    // Export data pegawai
    public function exportCsv()
    {
        $db = db_connect();
        $pegawaiList = $db->table('pegawai p')
            ->select('p.id, p.name, p.gender, d.name as departemen_name, p.address, p.keahlian, p.active')
            ->join('departemen d', 'd.id = p.departemenid', 'left')
            ->get()
            ->getResultArray();

        // Replace keahlian IDs with names
        $keahlianIds = array_unique(array_merge(...array_map(fn($p)=> explode(',', $p['keahlian']), $pegawaiList)));
        $keahlianMap = $db->table('keahlian')
                            ->select('id,name')
                            ->whereIn('id', $keahlianIds)
                            ->get()
                            ->getResultArray();
        $keahlianMap = array_column($keahlianMap, 'name', 'id');

        foreach ($pegawaiList as &$p) {
            $ids = explode(',', $p['keahlian']);
            $names = array_map(fn($id)=> $keahlianMap[$id] ?? '', $ids);
            $p['keahlian'] = implode(', ', $names);
            $p['gender'] = $p['gender'] == 'P' ? 'Pria' : 'Wanita';
            $p['active'] = $p['active'] == 1 ? 'Active' : 'Non Active';
        }

        // CSV headers
        $filename = 'pegawai_export_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Kolom Data
        fputcsv($output, ['ID', 'Nama', 'Gender', 'Departemen', 'Alamat', 'Keahlian', 'Status']);

        foreach ($pegawaiList as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

}
