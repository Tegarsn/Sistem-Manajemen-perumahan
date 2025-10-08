<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BahanBangunanModel;
use App\Models\RabBahanModel;
use App\Models\RabRumahModel;
use CodeIgniter\HTTP\ResponseInterface;

class RabBahanController extends BaseController
{
    public function rabbahan()
    {
        $rabrumah = new RabRumahModel();
        $rabbahan = new RabBahanModel();
        $bahan = new BahanBangunanModel();
        
        $data['rabrumah'] = $rabrumah->findAll();
        $data['bahan']  = $bahan->findAll();
        return view('page/rabbahan/rab_bahan', $data);
    }

    public function json() {
        $request = service('request');
        $model = new RabBahanModel();

        $searchValue = $request->getGet('search')['value'] ?? null ;
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;

        $query =  $model->select('rab_bahan.*, rab_rumah.kode_rab, bahan_bangunan.nama_bahan')
                    ->join('rab_rumah', 'rab_rumah.id = rab_bahan.rab_id')
                    ->join('bahan_bangunan', 'bahan_bangunan.id = rab_bahan.bahanbangunan_id');

        if ($searchValue) {
            $query = $query->groupStart()
            ->like('rab_rumah.kode_rab', $searchValue)
            ->orLike('bahan_bangunan.nama_bahan', $searchValue)
            ->orLike('jumlah_rencana', $searchValue)
            ->orLike('harga_satuan', $searchValue)
            ->orLike('sub_total', $searchValue)
            ->groupEnd();
        }

        $data = $query->orderBy('created_at', 'DESC')
                ->findAll($length, $start);
        $total = $model->countAll();
        $filtered = $searchValue ? count($data) : $total;

        return $this->response->setJson([
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
    $totalBahan = $rabBahanModel->where('rab_id', $rabId)
                                ->selectSum('sub_total')
                                ->first()['sub_total'] ?? 0;
    $totalPekerja = $rabPekerjaModel->where('rab_id', $rabId)
                                    ->selectSum('biaya_kontraktor')
                                    ->first()['biaya_kontraktor'] ?? 0;

    $total = $totalBahan + $totalPekerja;
    $rabRumahModel->update($rabId, ['total_anggaran' => $total]);
}

    public function store() {
    $rabBahanModel = new RabBahanModel();
    $bahanModel = new BahanBangunanModel();

    $rab_id = $this->request->getPost('rab_id');
    $bahan_ids = $this->request->getPost('bahanbangunan_id'); // array
    $jumlah_rencana = $this->request->getPost('jumlah_rencana'); // array
    $harga_satuan = $this->request->getPost('harga_satuan'); // array

    foreach ($bahan_ids as $i => $bahan_id) {
        $jumlah = (int) $jumlah_rencana[$i];
        $harga = (int) $harga_satuan[$i];
        $sub_total = $jumlah * $harga;

        $bahan = $bahanModel->find($bahan_id);
        if ($bahan && $bahan['stok'] >= $jumlah) {
            $bahanModel->update($bahan_id, [
                'stok' => $bahan['stok'] - $jumlah
            ]);

            $rabBahanModel->insert([
                'rab_id' => $rab_id,
                'bahanbangunan_id' => $bahan_id,
                'jumlah_rencana' => $jumlah,
                'harga_satuan' => $harga,
                'sub_total' => $sub_total
            ]);
            $this->updateTotalAnggaran($rab_id);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Stok tidak mencukupi untuk bahan: ' . $bahan['nama_bahan']
            ]);
        }
    }

    return $this->response->setJSON(['status' => 'success']);
}


    public function edit($id) {
    $model = new RabBahanModel();
    $bahan = new BahanBangunanModel();
    $data = $model->select('rab_bahan.id, rab_bahan.rab_id, rab_bahan.bahanbangunan_id, rab_bahan.jumlah_rencana, rab_bahan.harga_satuan, rab_rumah.kode_rab, bahan_bangunan.nama_bahan, bahan_bangunan.stok')
                  ->join('rab_rumah', 'rab_rumah.id = rab_bahan.rab_id')
                  ->join('bahan_bangunan', 'bahan_bangunan.id = rab_bahan.bahanbangunan_id')
                  ->where('rab_bahan.id', $id)
                  ->first();
    
    $bahan = $bahan->findAll();
    return $this->response->setJSON([
        'rab_bahan' => $data,
        'bahan' => $bahan,
    ]);
}


    public function update($id) {
        $rabBahanModel = new RabBahanModel();
        $bahanModel = new BahanBangunanModel();

        $dataLama = $rabBahanModel->find($id);
        if (!$dataLama) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }

        $bahan_id = $this->request->getPost('bahanbangunan_id');
        $jumlah_baru = (int) $this->request->getPost('jumlah_rencana');
        $harga_satuan = (int) $this->request->getPost('harga_satuan');
        $sub_total = $jumlah_baru * $harga_satuan;

        $bahan = $bahanModel->find($dataLama['bahanbangunan_id']);
        $bahanModel->update($dataLama['bahanbangunan_id'], [
            'stok' => $bahan['stok'] + $dataLama['jumlah_rencana']
        ]);

        $bahanBaru = $bahanModel->find($bahan_id);
        if ($bahanBaru && $bahanBaru['stok'] >= $jumlah_baru) {
            $bahanModel->update($bahan_id, [
                'stok' => $bahanBaru['stok'] - $jumlah_baru
            ]);

            $rabBahanModel->update($id, [
                'bahanbangunan_id' => $bahan_id,
                'jumlah_rencana' => $jumlah_baru,
                'harga_satuan' => $harga_satuan,
                'sub_total' => $sub_total
            ]);
            $this->updateTotalAnggaran($dataLama['rab_id']);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Stok tidak mencukupi']);
    }

    public function delete($id)
    {
        $rabBahanModel = new RabBahanModel();
        $bahanModel = new BahanBangunanModel();

        $data = $rabBahanModel->find($id);
        if ($data) {
            $bahan = $bahanModel->find($data['bahanbangunan_id']);
            $bahanModel->update($data['bahanbangunan_id'], [
                'stok' => $bahan['stok'] + $data['jumlah_rencana']
            ]);

            $rabBahanModel->delete($id);
            $this->updateTotalAnggaran($data['rab_id']);
            return $this->response->setJSON(['status' => 'success']);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }
}
