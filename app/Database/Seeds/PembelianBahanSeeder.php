<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PembelianBahanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nomor_nota'  => 'NOTA-001',
                'tanggal'     => '2025-07-01',
                'supplier'    => 'UD Sumber Makmur',
                'total_harga' => 2500000.00,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_nota'  => 'NOTA-002',
                'tanggal'     => '2025-07-03',
                'supplier'    => 'CV Bangun Jaya',
                'total_harga' => 3200000.00,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'nomor_nota'  => 'NOTA-003',
                'tanggal'     => '2025-07-05',
                'supplier'    => 'Toko Bahan Abadi',
                'total_harga' => 1850000.00,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert multiple rows
        $this->db->table('pembelian_bahan')->insertBatch($data);
    }
}
