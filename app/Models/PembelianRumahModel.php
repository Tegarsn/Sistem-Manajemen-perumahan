<?php 

namespace App\Models;
use CodeIgniter\Model;

class PembelianRumahModel extends Model {
    protected $table = 'pembelian_rumah';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'customer_id',
        'perumahan_id',
        'tanggal_pembelian',
        'harga_beli',
        'status_pembelian',
        'metode_pembayaran',
        'catatan_marketing',
        'status_dokumen',
        'request_khusus',
        'created_at',
        'updated_at',
    ];
    protected $useTimestamps = true;
}