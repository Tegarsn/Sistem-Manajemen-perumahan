<?php 

namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model {
    protected $table ='customer';
    protected $primaryKey = 'id';
     protected $allowedFields = [
        'perumahan_id',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_pembelian',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}