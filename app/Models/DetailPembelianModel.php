<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembelianModel extends Model
{
    protected $table            = 'detail_pembelian_bahan';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'pembelian_id',
        'bahan_bangunan_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
