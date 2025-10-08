<?php

namespace App\Models;

use CodeIgniter\Model;

class RabRumahModel extends Model
{
    protected $table      = 'rab_rumah';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'kode_rab',
        'perumahan_id',
        'total_anggaran',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
