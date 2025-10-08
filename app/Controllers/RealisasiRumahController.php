<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Migrations\RealisasiRumah;
use App\Models\PerumahanModel;
use App\Models\RabRumahModel;
use App\Models\RealisasiRumahModel;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;

class RealisasiRumahController extends BaseController
{
    public function realisasiRumah()
    {
        $perumahanModel = new PerumahanModel();
        $rabRumahModel  = new RabRumahModel();
        $perumahan = $perumahanModel
                ->select('perumahan.id, perumahan.kode_rumah, perumahan.status, rab_rumah.kode_rab')
                ->join('rab_rumah', 'rab_rumah.perumahan_id = perumahan.id', 'inner') // hanya yg ada di rab_rumah
                ->findAll();

        $usedIds = model('RealisasiRumahModel')->select('perumahan_id')->findColumn('perumahan_id') ?? [];

        return view('page/realisasi/realisasi_rumah', [
            'perumahan' => $perumahan,
            'usedIds'   => $usedIds
        ]);
    }
    public function json() {
        $request = service('request');
        $model = new RealisasiRumahModel();

        $searchValue = $request->getGet('search')['value'] ?? null;
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 10;

        $query = $model->select('realisasi_rumah.*, perumahan.kode_rumah, rab_rumah.kode_rab')
                    ->join('perumahan', 'perumahan.id = realisasi_rumah.perumahan_id')
                    ->join('rab_rumah', 'rab_rumah.perumahan_id = realisasi_rumah.perumahan_id');
        if ($searchValue) {
            $query = $query->groupStart()
            ->like('kode_rumah', $searchValue)
            ->orLike('kode_rab', $searchValue)
            ->orLike('sub_total_asli', $searchValue)
            ->orLike('tanggal_mulai', $searchValue)
            ->orLike('tanggal_selesai', $searchValue)
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
        $model = new RealisasiRumahModel();
        $data = [
            'perumahan_id' => $this->request->getPost('perumahan_id'),
            'sub_total_asli' => $this->request->getPost('sub_total_asli'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        ];
        $model->insert($data);
        return $this->response->setJSON(['status' => 'success']);

    }

    public function edit($id) {
        $model = new RealisasiRumahModel();
        $data = $model->find($id);
        if($data) {
            return $this->response->setJSON($data);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Tidak Ditemukan'], 400);
        }
    }

    public function update($id) {
        $model = new RealisasiRumahModel();
        $data = [
            'perumahan_id' => $this->request->getPost('perumahan_id'),
            'sub_total_asli' => $this->request->getPost('sub_total_asli'),
            'tanggal_mulai' => $this->request->getPost('tanggal_mulai'),
            'tanggal_selesai' => $this->request->getPost('tanggal_selesai'),
        ];
        if ($model->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil di perbarui']);
        } else {
            return $this->response->setJSON(['status' => 'error','message' => 'Data Gagal untuk di perbarui'], 400);
        }
    }

    public function delete($id) {
        $model = new RealisasiRumahModel();
        if ($model->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil untuk dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'messsage' => 'Data Gagal Dihapus'], 400);
        }
    }

  

    public function cetak($id) {
        $realisasiRumahModel   = new \App\Models\RealisasiRumahModel();
        $realisasiBahanModel   = new \App\Models\RealisasiBahanModel();
        $realisasiPekerjaModel = new \App\Models\RealisasiPekerjaModel();
        $pekerjaanInsidentilModel = new \App\Models\InsidentilModel();

        $realisasi = $realisasiRumahModel
            ->select('realisasi_rumah.*, perumahan.kode_rumah, realisasi_rumah.tanggal_mulai, realisasi_rumah.tanggal_selesai')
            ->join('perumahan', 'perumahan.id = realisasi_rumah.perumahan_id')
            ->find($id);

        $realisasiBahan = $realisasiBahanModel
            ->select('realisasi_bahan.*, bahan_bangunan.nama_bahan')
            ->join('bahan_bangunan', 'bahan_bangunan.id = realisasi_bahan.bahanbangunan_id')
            ->where('realisasi_id', $id)
            ->findAll();

        $realisasiPekerja = $realisasiPekerjaModel
            ->where('realisasi_id', $id)
            ->findAll();
        
        $pekerjaanInsidentil = $pekerjaanInsidentilModel
            ->select('pekerjaan_insidentil.*, user.nama AS nama_mandor')
            ->join('user', 'user.id = pekerjaan_insidentil.mandor_id', 'left')
            ->where('pekerjaan_insidentil.perumahan_id', $realisasi['perumahan_id'])
            ->findAll();

        $html = view('page/realisasi/cetak_realisasi', [
            'realisasi'        => $realisasi,
            'realisasiBahan'   => $realisasiBahan,
            'realisasiPekerja' => $realisasiPekerja,
            'pekerjaanInsidentil' => $pekerjaanInsidentil,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream("Realisasi_Rumah_{$id}.pdf", ["Attachment" => false]);
    }


}

