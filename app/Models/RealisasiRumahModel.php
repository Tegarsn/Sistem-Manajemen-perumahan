<?php

namespace App\Models;

use CodeIgniter\Model;

class RealisasiRumahModel extends Model
{
    protected $table      = 'realisasi_rumah';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'perumahan_id',
        'sub_total_asli',
        'tanggal_mulai',
        'tanggal_selesai',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
