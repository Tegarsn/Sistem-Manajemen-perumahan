<?php

namespace App\Models;

use CodeIgniter\Model;

class RealisasiPekerjaModel extends Model
{
    protected $table      = 'realisasi_pekerja';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'realisasi_id',
        'nama_kontraktor',
        'biaya_kontraktor',
        'jumlah_hari',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
