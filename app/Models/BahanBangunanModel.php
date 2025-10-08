<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanBangunanModel extends Model
{
    protected $table      = 'bahan_bangunan';      // Nama tabel
    protected $primaryKey = 'id';                  // Primary key

    protected $allowedFields = [
        'nama_bahan',
        'satuan',
        'stok',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

}
