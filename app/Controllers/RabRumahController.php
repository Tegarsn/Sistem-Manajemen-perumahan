<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PerumahanModel;
use App\Models\RabRumahModel;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;

class RabRumahController extends BaseController
{
    public function rabrumah()
{
    $rabRumah = new RabRumahModel();
    $perumahan = new PerumahanModel();
    // Semua data perumahan
    $data['perumahan'] = $perumahan->orderBy('created_at', 'DESC')->findAll();
    $used = $rabRumah->select('perumahan_id')->findAll();
    $data['usedIds'] = array_column($used, 'perumahan_id');
    return view('page/rab/rab_rumah', $data);
}


    public function json() {
        $request = service('request');
        $model = new RabRumahModel();

        $searchValue = $request->getGet('search')['value'] ?? null;
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;

        $query = $model->select('rab_rumah.*, perumahan.kode_rumah')
               ->join('perumahan', 'perumahan.id = rab_rumah.perumahan_id');

        if ($searchValue) {
            $query = $query->groupStart()
                ->like('kode_rab', $searchValue)
                ->orLike('perumahan.kode_rumah', $searchValue)
                ->orLike('total_anggaran', $searchValue)
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

    public function store() {
        $model = new RabRumahModel();
        $data = [
            'kode_rab' => $this->request->getPost('kode_rab'),
            'perumahan_id' => $this->request->getPost('perumahan_id'),
            'total_anggaran' => $this->request->getPost('total_anggaran'),
        ];
        $model->insert($data);
        return redirect()->to('/rab-rumah');
    }

     public function edit($id)
    {
        $model = new RabRumahModel();
        $data = $model->find($id);

        if ($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan'], 404);
        }
    } 

    public function update($id)
    {
        $model = new RabRumahModel();
        $data = [
            'kode_rab' => $this->request->getPost('kode_rab'),
            'perumahan_id' => $this->request->getPost('perumahan_id'),
            'total_anggaran' => $this->request->getPost('total_anggaran'),
        ];

        if ($model->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data'], 400);
        }
    }

    public function delete($id)
    {
        $model = new RabRumahModel();

        if ($model->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus data'], 400);
        }
    }
    

public function cetak($id)
{
    $rabModel       = new RabRumahModel();
    $rabBahanModel  = new \App\Models\RabBahanModel();
    $rabPekerjaModel= new \App\Models\RabPekerjaModel();

    $rab = $rabModel->select('rab_rumah.*, perumahan.kode_rumah')
                    ->join('perumahan', 'perumahan.id = rab_rumah.perumahan_id')
                    ->find($id);

    if (!$rab) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data RAB dengan ID $id tidak ditemukan");
    }

    $rabBahan = $rabBahanModel->select('rab_bahan.*, bahan_bangunan.nama_bahan')
                              ->join('bahan_bangunan', 'bahan_bangunan.id = rab_bahan.bahanbangunan_id')
                              ->where('rab_id', $id)
                              ->findAll();

    $rabPekerja = $rabPekerjaModel->where('rab_id', $id)->findAll();

    $total_bahan   = array_sum(array_column($rabBahan, 'sub_total'));
    $total_pekerja = array_sum(array_column($rabPekerja, 'biaya_kontraktor'));
    $total_semua   = $total_bahan + $total_pekerja;

    $html = view('page/rab/cetak_rab', [
        'rab'          => $rab,
        'rabBahan'     => $rabBahan,
        'rabPekerja'   => $rabPekerja,
        'total_bahan'  => $total_bahan,
        'total_pekerja'=> $total_pekerja,
        'total_semua'  => $total_semua
    ]);

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("RAB_Rumah_{$rab['kode_rumah']}.pdf", ["Attachment" => false]);
}


}
