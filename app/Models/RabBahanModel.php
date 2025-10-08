<?php

namespace App\Models;

use CodeIgniter\Model;

class RabBahanModel extends Model
{
    protected $table      = 'rab_bahan';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'rab_id',
        'bahanbangunan_id',
        'jumlah_rencana',
        'harga_satuan',
        'sub_total',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
