<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RealisasiBahanModel;
use App\Models\RealisasiRumahModel;
use App\Models\RabBahanModel;
use App\Models\BahanBangunanModel;
use App\Models\RabRumahModel;

class RealisasiBahanController extends BaseController
{
    public function realisasibahan()
    {
        $realisasiRumahModel = new RealisasiRumahModel();
        $bahanModel          = new BahanBangunanModel();

        $realisasiRumah = $realisasiRumahModel
            ->select('realisasi_rumah.id as realisasi_id, perumahan.kode_rumah, rab_rumah.kode_rab')
            ->join('perumahan', 'perumahan.id = realisasi_rumah.perumahan_id')
            ->join('rab_rumah', 'rab_rumah.perumahan_id = perumahan.id', 'left')
            ->findAll();

        $bahan = $bahanModel->findAll();

        return view('page/realisasi/realisasi_bahan', [
            'realisasiRumah' => $realisasiRumah,
            'bahan' => $bahan
        ]);
    }

    public function json()
    {
        $request = service('request');
        $model   = new RealisasiBahanModel();

        $searchValue = $request->getGet('search')['value'] ?? null;
        $start       = $request->getGet('start') ?? 0;
        $length      = $request->getGet('length') ?? 10;

        $query = $model->select('
                realisasi_bahan.id,
                realisasi_bahan.realisasi_id,
                realisasi_bahan.bahanbangunan_id,
                perumahan.kode_rumah,
                bahan_bangunan.nama_bahan,
                realisasi_bahan.jumlah,
                realisasi_bahan.harga_satuan,
                realisasi_bahan.sub_total,
                realisasi_bahan.created_at
            ')
            ->join('realisasi_rumah', 'realisasi_rumah.id = realisasi_bahan.realisasi_id')
            ->join('perumahan', 'perumahan.id = realisasi_rumah.perumahan_id')
            ->join('bahan_bangunan', 'bahan_bangunan.id = realisasi_bahan.bahanbangunan_id');

        if ($searchValue) {
            $query->groupStart()
                ->like('perumahan.kode_rumah', $searchValue)
                ->orLike('bahan_bangunan.nama_bahan', $searchValue)
                ->orLike('realisasi_bahan.jumlah', $searchValue)
                ->orLike('realisasi_bahan.harga_satuan', $searchValue)
                ->orLike('realisasi_bahan.sub_total', $searchValue)
                ->groupEnd();
        }

        $data     = $query->orderBy('realisasi_bahan.created_at', 'DESC')->findAll($length, $start);
        $total    = $model->countAll();
        $filtered = $searchValue ? count($data) : $total;

        return $this->response->setJSON([
            'draw'            => (int)$request->getGet('draw'),
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $data,
        ]);
    }

    private function updateSubTotalAsli($realisasi_id) {
        $realisasiPekerjaModel = new \App\Models\RealisasiPekerjaModel();
        $realisasiBahanModel   = new \App\Models\RealisasiBahanModel();
        $realisasiRumahModel   = new \App\Models\RealisasiRumahModel();

        $totalPekerja = $realisasiPekerjaModel
            ->where('realisasi_id', $realisasi_id)
            ->selectSum('biaya_kontraktor')
            ->first();

        $totalBahan = $realisasiBahanModel
            ->where('realisasi_id', $realisasi_id)
            ->selectSum('sub_total')
            ->first();

        $grandTotal = ($totalPekerja['biaya_kontraktor'] ?? 0) + ($totalBahan['sub_total'] ?? 0);

        $realisasiRumahModel->update($realisasi_id, ['sub_total_asli' => $grandTotal]);
    }

    public function store() {
    $request = service('request');

    if ($request->getMethod(true) !== 'POST') {
        return $this->response->setStatusCode(400)
                             ->setJSON(['status' => 'error', 'message' => 'Invalid request method']);
    }

    $realisasiId  = $request->getPost('realisasi_id');
    $bahanIds     = $request->getPost('bahanbangunan_id') ?? [];
    $jumlahs      = $request->getPost('jumlah') ?? [];
    $hargaSatuans = $request->getPost('harga_satuan') ?? [];

    if (empty($realisasiId) || empty($bahanIds)) {
        return $this->response->setStatusCode(400)
                             ->setJSON(['status' => 'error', 'message' => 'Data tidak lengkap (realisasi_id / bahan).']);
    }

    $realisasiRumahModel = new RealisasiRumahModel();
    $rabRumahModel       = new RabRumahModel();
    $rabBahanModel       = new RabBahanModel();
    $realisasiBahanModel = new RealisasiBahanModel();
    $bahanModel          = new BahanBangunanModel();

    $realisasiRumah = $realisasiRumahModel->find($realisasiId);
    if (!$realisasiRumah) {
        return $this->response->setStatusCode(404)
                             ->setJSON(['status' => 'error', 'message' => 'Realisasi rumah tidak ditemukan.']);
    }

    $perumahanId = $realisasiRumah['perumahan_id'];
    $rabRumah    = $rabRumahModel->where('perumahan_id', $perumahanId)->first();
    if (!$rabRumah) {
        return $this->response->setStatusCode(404)
                             ->setJSON(['status' => 'error', 'message' => 'RAB untuk rumah ini tidak ditemukan.']);
    }

    $db = \Config\Database::connect();
    $db->transStart();

    $saved = 0;
    $skipped = [];

    for ($i = 0; $i < count($bahanIds); $i++) {
        $bahanId = (int) ($bahanIds[$i] ?? 0);
        $jumlah  = (int) ($jumlahs[$i] ?? 0);
        $harga   = (float) ($hargaSatuans[$i] ?? 0);

        if ($bahanId <= 0 || $jumlah < 0) {
            $skipped[] = ['bahan_id' => $bahanId, 'reason' => 'invalid input'];
            continue;
        }

        // ambil rab_bahan yang sesuai (rab_rumah.id -> rab_bahan.rab_id)
        $rabBahan = $rabBahanModel->where('rab_id', $rabRumah['id'])
                                 ->where('bahanbangunan_id', $bahanId)
                                 ->first();

        if (!$rabBahan) {
            $skipped[] = ['bahan_id' => $bahanId, 'reason' => 'tidak ada di RAB'];
            continue;
        }

        // delta: positif => stok bertambah (rencana > realisasi), negatif => stok berkurang
        $delta = (int) $rabBahan['jumlah_rencana'] - $jumlah;

        // update stok (stok = stok + delta)
        $bahanModel->where('id', $bahanId)
                   ->set('stok', 'stok + ' . (int)$delta, false)
                   ->update();

        // simpan record realisasi_bahan
        $realisasiBahanModel->insert([
            'realisasi_id'     => $realisasiId,
            'bahanbangunan_id' => $bahanId,
            'harga_satuan'     => $harga,
            'jumlah'           => $jumlah,
            'sub_total'        => $jumlah * $harga,
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);
        $saved++;
    }

    $this->updateSubTotalAsli($realisasiId);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return $this->response->setStatusCode(500)
                             ->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data (database error)']);
    }

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => "Selesai: tersimpan {$saved} item. dilewati: " . count($skipped),
        'skipped' => $skipped
    ]);
}
public function edit($id)
{
    $realisasiBahanModel = new RealisasiBahanModel();

    $realisasi = $realisasiBahanModel
        ->select('
            realisasi_bahan.id as realisasi_bahan_id,
            realisasi_bahan.*,
            perumahan.kode_rumah,
            rab_rumah.kode_rab,
            bahan_bangunan.stok,
            bahan_bangunan.satuan
        ')
        ->join('realisasi_rumah', 'realisasi_rumah.id = realisasi_bahan.realisasi_id')
        ->join('perumahan', 'perumahan.id = realisasi_rumah.perumahan_id')
        ->join('rab_rumah', 'rab_rumah.perumahan_id = perumahan.id', 'left')
        ->join('bahan_bangunan', 'bahan_bangunan.id = realisasi_bahan.bahanbangunan_id')
        ->where('realisasi_bahan.id', $id)
        ->first();

    if (!$realisasi) {
        return $this->response->setStatusCode(404)
                   ->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }

    return $this->response->setJSON([
        'status' => 'success',
        'data'   => $realisasi
    ]);
}

public function update($id)
{
    $realisasiBahanModel = new RealisasiBahanModel();
    $rabBahanModel       = new RabBahanModel();
    $realisasiRumahModel = new RealisasiRumahModel();
    $bahanModel          = new BahanBangunanModel();

    $jumlahBaru        = (int) $this->request->getPost('jumlah');
    $hargaSatuanBaru   = (int) $this->request->getPost('harga_satuan');
    $bahanBaruId       = (int) $this->request->getPost('bahanbangunan_id');

    $realisasiLama = $realisasiBahanModel->find($id);
    if (!$realisasiLama) {
        return $this->response->setStatusCode(404)
            ->setJSON(['status' => 'error', 'message' => 'Data realisasi tidak ditemukan']);
    }

    $bahanLamaId   = $realisasiLama['bahanbangunan_id'];
    $realisasiId   = $realisasiLama['realisasi_id'];
    $jumlahLama    = (int) $realisasiLama['jumlah'];

    $realisasiRumah = $realisasiRumahModel->find($realisasiId);
    $rabBahan = $rabBahanModel
        ->join('rab_rumah', 'rab_rumah.id = rab_bahan.rab_id')
        ->where('rab_rumah.perumahan_id', $realisasiRumah['perumahan_id'])
        ->where('rab_bahan.bahanbangunan_id', $bahanBaruId)
        ->first();

    if (!$rabBahan) {
        return $this->response->setStatusCode(404)
            ->setJSON(['status' => 'error', 'message' => 'Data RAB bahan tidak ditemukan']);
    }

    $jumlahRencana = (int) $rabBahan['jumlah_rencana'];

    if ($bahanLamaId == $bahanBaruId) {
        $deltaLama = $jumlahRencana - $jumlahLama;
        $deltaBaru = $jumlahRencana - $jumlahBaru;
        $delta     = $deltaBaru - $deltaLama;

        $bahanModel->where('id', $bahanBaruId)
            ->set('stok', 'stok + ' . (int)$delta, false)
            ->update();

    } else {
        $rabBahanLama = $rabBahanModel
            ->join('rab_rumah', 'rab_rumah.id = rab_bahan.rab_id')
            ->where('rab_rumah.perumahan_id', $realisasiRumah['perumahan_id'])
            ->where('rab_bahan.bahanbangunan_id', $bahanLamaId)
            ->first();

        if ($rabBahanLama) {
            $jumlahRencanaLama = (int) $rabBahanLama['jumlah_rencana'];
            $deltaLama         = $jumlahRencanaLama - $jumlahLama;

            $bahanModel->where('id', $bahanLamaId)
                ->set('stok', 'stok - ' . (int)$deltaLama, false)
                ->update();
        }

        $deltaBaru = $jumlahRencana - $jumlahBaru;
        $bahanModel->where('id', $bahanBaruId)
            ->set('stok', 'stok + ' . (int)$deltaBaru, false)
            ->update();
    }

    $realisasiBahanModel->update($id, [
        'bahanbangunan_id' => $bahanBaruId,
        'jumlah'           => $jumlahBaru,
        'harga_satuan'     => $hargaSatuanBaru,
        'sub_total'        => $jumlahBaru * $hargaSatuanBaru,
        'updated_at'       => date('Y-m-d H:i:s'),
    ]);
    $this->updateSubTotalAsli($realisasiId);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Data berhasil diperbarui, stok & total biaya diupdate'
    ]);
}

 

public function delete($id)
{
    $realisasiBahanModel = new RealisasiBahanModel();
    $rabBahanModel       = new RabBahanModel();
    $realisasiRumahModel = new RealisasiRumahModel();
    $bahanModel          = new BahanBangunanModel();

    $realisasi = $realisasiBahanModel->find($id);
    if (!$realisasi) {
        return $this->response->setStatusCode(404)
            ->setJSON(['status' => 'error', 'message' => 'Data realisasi tidak ditemukan']);
    }
    $bahanId     = $realisasi['bahanbangunan_id'];
    $realisasiId = $realisasi['realisasi_id'];
    $jumlah      = (int) $realisasi['jumlah'];

    $realisasiRumah = $realisasiRumahModel->find($realisasiId);
    $rabBahan = $rabBahanModel
        ->join('rab_rumah', 'rab_rumah.id = rab_bahan.rab_id')
        ->where('rab_rumah.perumahan_id', $realisasiRumah['perumahan_id'])
        ->where('rab_bahan.bahanbangunan_id', $bahanId)
        ->first();

    if (!$rabBahan) {
        return $this->response->setStatusCode(404)
            ->setJSON(['status' => 'error', 'message' => 'Data RAB bahan tidak ditemukan']);
    }

    $jumlahRencana = (int) $rabBahan['jumlah_rencana'];

    $deltaLama = $jumlahRencana - $jumlah;

    $realisasiBahanModel->delete($id);

    $bahanModel->where('id', $bahanId)
        ->set('stok', 'stok - ' . (int)$deltaLama, false)
        ->update();

    $this->updateSubTotalAsli($realisasiId);

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => 'Data berhasil dihapus & stok diperbarui'
    ]);
}

}
