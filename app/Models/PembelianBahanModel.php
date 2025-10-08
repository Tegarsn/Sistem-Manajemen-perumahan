<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianBahanModel extends Model
{
    protected $table      = 'pembelian_bahan';      // Nama tabel
    protected $primaryKey = 'id';                  // Primary key

    protected $allowedFields = [
        'nomor_nota',
        'tanggal',
        'supplier',
        'total_harga',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

}
