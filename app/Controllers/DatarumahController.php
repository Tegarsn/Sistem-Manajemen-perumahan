<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PerumahanModel;
use CodeIgniter\HTTP\ResponseInterface;

class DatarumahController extends BaseController
{
    public function datarumah() {
        return view('page/datarumah/datarumah');
    }

    public function json() {
    $request = service('request');
    $model = new PerumahanModel();

    $searchValue = $request->getGet('search')['value'];
    $start = $request->getGet('start');
    $length = $request->getGet('length');

    $query = $model; 
    if ($searchValue) {
        $query = $query
            ->like('kode_rumah', $searchValue)
            ->orLike('lokasi', $searchValue)
            ->orLike('tipe', $searchValue)
            ->orLIke('status', $searchValue);
    }

    $data = $query->orderBy('created_at', 'DESC')
                  ->findAll($length, $start);
                  
    $total = $model->countAll();
    $filtered = $searchValue ? count($data) : $total;

    return $this->response->setJSON([
        'draw' => (int) $request->getGet('draw'),
        'recordsTotal' => $total,
        'recordsFiltered' => $filtered,
        'data' => $data,
    ]);
}


    public function create() {
        return view('page/datarumah/create');
    } 

    public function store() {
        $model = new PerumahanModel();
        $data  = [
            'kode_rumah'     => $this->request->getPost('kode_rumah'),
            'lokasi'         => $this->request->getPost('lokasi'),
            'tipe'           => $this->request->getPost('tipe'),
            'luas_tanah'     => $this->request->getPost('luas_tanah'),
            'luas_bangunan'  => $this->request->getPost('luas_bangunan'),
            'harga'          => $this->request->getPost('harga'),
            'status'         => $this->request->getPost('status')
        ];
        $model->insert($data);
        return redirect()->to('/data-rumah');
    }

    public function edit($id) {
        $model = new PerumahanModel();
        $data['perumahan'] = $model->find($id);
        return $this->response->setJSON($data['perumahan']);
    }

    public function update($id) {
        $model = new PerumahanModel();
        $data = [
            'kode_rumah'     => $this->request->getPost('kode_rumah'),
            'lokasi'         => $this->request->getPost('lokasi'),
            'tipe'           => $this->request->getPost('tipe'),
            'luas_tanah'     => $this->request->getPost('luas_tanah'),
            'luas_bangunan'  => $this->request->getPost('luas_bangunan'),
            'harga'          => $this->request->getPost('harga'),
            'status'         => $this->request->getPost('status'),
        ];
        $model->update($id, $data);
        return $this->response->setJSON(['success' => true]);
    }

    public function delete($id) {
        $model = new PerumahanModel();
        $model->delete($id);
        return $this->response->setJSON(['success' => true]);
    }
}
