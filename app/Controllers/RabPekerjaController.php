<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RabPekerjaModel;
use App\Models\RabRumahModel;
use CodeIgniter\HTTP\ResponseInterface;

class RabPekerjaController extends BaseController
{
    public function rabpekerja()
    {
        $rabrumah = new RabRumahModel();
        $rabpekerja = new RabPekerjaModel();
        
        $data['rabrumah'] = $rabrumah->findAll();
        $data['rabpekerja'] = $rabpekerja->findAll();

        return view ('page/rabpekerja/rab_pekerja', $data);
    }

    public function json() {
        $request = service('request');
        $model = new RabPekerjaModel();

        $searchValue = $request->getGet('search')['value'] ?? null;
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;

        $query = $model->select('rab_pekerja.*, rab_rumah.kode_rab')
        ->join('rab_rumah', 'rab_rumah.id = rab_pekerja.rab_id');

        if($searchValue) {
            $query = $query->groupStart()
            ->like('rab_rumah.kode_rab', $searchValue)
            ->orLike('nama_kontraktor', $searchValue)
            ->orLike('biaya_kontraktor', $searchValue)
            ->orLike('estimasi_hari', $searchValue)
            ->groupEnd();
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


    private function updateTotalAnggaran($rabId) {
    $rabBahanModel = new \App\Models\RabBahanModel();
    $rabPekerjaModel = new \App\Models\RabPekerjaModel();
    $rabRumahModel = new \App\Models\RabRumahModel();

    // Hitung total bahan
    $totalBahan = $rabBahanModel->where('rab_id', $rabId)
                                ->selectSum('sub_total')
                                ->first()['sub_total'] ?? 0;

    // Hitung total pekerja
    $totalPekerja = $rabPekerjaModel->where('rab_id', $rabId)
                                    ->selectSum('biaya_kontraktor')
                                    ->first()['biaya_kontraktor'] ?? 0;

    // Jumlahkan
    $total = $totalBahan + $totalPekerja;

    // Update kolom total_anggaran di rab_rumah
    $rabRumahModel->update($rabId, ['total_anggaran' => $total]);
}

public function store(){
    $request = service('request');
    $rabpekerja = new RabPekerjaModel();

    $data = [
        'rab_id'        => $request->getPost('rab_id'),
        'nama_kontraktor'=> $request->getPost('nama_kontraktor'),
        'biaya_kontraktor'  => $request->getPost('biaya_kontraktor'),
        'estimasi_hari' => $request->getPost('estimasi_hari'),
    ];

    $rabpekerja->insert($data);
    $this->updateTotalAnggaran($data['rab_id']);

    return $this->response->setJSON(['status' => 'success']);
}

public function getKodeRumah($rabId)
{
    $model = new RabRumahModel();
    $rab = $model->select('rab_rumah.id, rab_rumah.kode_rab, perumahan.kode_rumah')
        ->join('perumahan', 'perumahan.id = rab_rumah.perumahan_id')
        ->where('rab_rumah.id', $rabId)
        ->first();

    if ($rab) {
        return $this->response->setJSON([
            'status' => 'success',
            'kode_rumah' => $rab['kode_rumah']
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'kode_rumah' => null
        ], 404);
    }
}


public function edit($id) {
    $model = new RabPekerjaModel();
    $data = $model->find($id);

    if ($data) {
        return $this->response->setJSON($data);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data Tidak ditemukan'], 400);
    }
}

public function update($id) {
    $request = service('request');
    $model = new RabPekerjaModel();
   
    $data = [
        'rab_id'        => $request->getPost('rab_id'),
        'nama_kontraktor'=> $request->getPost('nama_kontraktor'),
        'biaya_kontraktor'  => $request->getPost('biaya_kontraktor'),
        'estimasi_hari' => $request->getPost('estimasi_hari'),
    ];

    if ($model->update($id, $data)) {
        // 🔥 Update total_anggaran setelah update
        $this->updateTotalAnggaran($data['rab_id']);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil diperbarui']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal diperbarui'],400);
    }
}


public function delete($id) {
    $model = new RabPekerjaModel();
    $data = $model->find($id);

    if($data && $model->delete($id)) {
        // 🔥 Update total_anggaran setelah delete
        $this->updateTotalAnggaran($data['rab_id']);
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil dihapus']);
    } else {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal di hapus'],400);
    }
}

}
