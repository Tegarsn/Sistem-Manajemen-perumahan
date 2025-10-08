<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PembatalanModel;
use App\Models\PembelianRumahModel;
use App\Models\PerumahanModel;
use CodeIgniter\HTTP\ResponseInterface;

class PembatalanTransaksiController extends BaseController
{
    public function pembatalan()
    {
        $pembatalan = new PembatalanModel();
        $data['pembatalan_transaksi'] = $pembatalan->orderBy('Created_at', 'DESC');
        return view('page/pembatalan/pembatalan_transaksi', $data);
    }

    public function json() {
        $request = service('request');

        $pembatalan = new PembatalanModel();
        $perumahan = new PerumahanModel();
        $pembelian = new PembelianRumahModel();

        $searchValue = $request->getGet('search')['value'] ?? '';
        $start = $request->getGet('start') ?? 0;
        $length = $request->getGet('length') ?? 0;

        $builder = $pembatalan
        ->select('pembatalan_transaksi.*, perumahan.kode_rumah, customer.nama, pembelian_rumah.harga_beli, pembelian_rumah.tanggal_pembelian')
        ->join('perumahan', 'perumahan.id = pembatalan_transaksi.perumahan_id')
        ->join('customer', 'customer.id = pembatalan_transaksi.customer_id')
        ->join('pembelian_rumah', 'pembelian_rumah.id = pembatalan_transaksi.pembelian_id')
        ;

        if($searchValue) {
            $builder = $builder->groupStart()
            ->like('kode_rumah', $searchValue)
            ->orLike('nama', $searchValue)
            ->orLike('harga_beli', $searchValue)
            ->orLike('keterangan_pembatalan', $searchValue)
            ->groupEnd();
        }

        $data = $builder->orderBy('created_at', 'DESC')
        ->findAll($length, $start);
        $total = $pembatalan->countAll();
        $filtered = $searchValue ? count($data) : $total;

        return $this->response->setJSON([
            'draw' => (int) $request->getGet('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }

}
