<?php

namespace App\Models;

use CodeIgniter\Model;

class InsidentilModel extends Model
{
    protected $table      = 'pekerjaan_insidentil';         
    protected $primaryKey = 'id';                 

    protected $allowedFields = [
        'perumahan_id',
        'mandor_id',
        'tanggal',
        'nama_pekerjaan',
        'keterangan',
        'total_biaya',
        'status',
        'approved_by',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;               
}
