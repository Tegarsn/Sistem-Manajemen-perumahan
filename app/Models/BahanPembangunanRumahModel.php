<?php

namespace App\Models;

use CodeIgniter\Model;

class BahanPembangunanRumahModel extends Model
{
    protected $table            = 'bahan_pembangunan_rumah';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'perumahan_id',
        'bahan_bangunan_id',
        'mandor_id',
        'jumlah_pemakaian',
        'tanggal_penggunaan',
        'keterangan',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
