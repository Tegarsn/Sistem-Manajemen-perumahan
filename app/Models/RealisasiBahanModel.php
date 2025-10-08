<?php

namespace App\Models;

use CodeIgniter\Model;

class RealisasiBahanModel extends Model
{
    protected $table      = 'realisasi_bahan';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'realisasi_id',
        'bahanbangunan_id',
        'harga_satuan',
        'jumlah',
        'sub_total',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
