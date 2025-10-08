<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BahanBangunanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_bahan' => 'Semen',
                'satuan'     => 'sak',
                'stok'       => 100,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bahan' => 'Pasir',
                'satuan'     => 'm³',
                'stok'       => 50,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bahan' => 'Batu Bata',
                'satuan'     => 'buah',
                'stok'       => 1000,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bahan' => 'Cat Tembok',
                'satuan'     => 'kaleng',
                'stok'       => 30,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'nama_bahan' => 'Besi Beton',
                'satuan'     => 'batang',
                'stok'       => 200,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert ke dalam tabel
        $this->db->table('bahan_bangunan')->insertBatch($data);
    }
}
