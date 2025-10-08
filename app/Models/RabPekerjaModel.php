<?php

namespace App\Models;

use CodeIgniter\Model;

class RabPekerjaModel extends Model
{
    protected $table      = 'rab_pekerja';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'rab_id',
        'nama_kontraktor',
        'biaya_kontraktor',
        'estimasi_hari',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
