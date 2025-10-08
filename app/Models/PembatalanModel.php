<?php

namespace App\Models;

use CodeIgniter\Model;

class PembatalanModel extends Model
{
    protected $table      = 'pembatalan_transaksi';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'perumahan_id',
        'customer_id',
        'pembelian_id',
        'keterangan_pembatalan',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
