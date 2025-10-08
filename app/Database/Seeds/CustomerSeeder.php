<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Contoh data perumahan_id yang sudah ada
        $data = [
            [
                'perumahan_id'      => 1,
                'nama'              => 'Ahmad Subagyo',
                'email'             => 'ahmad@example.com',
                'telepon'           => '081234567890',
                'alamat'            => 'Jl. Melati No. 123, Banyuwangi',
                'tanggal_pembelian' => '2024-11-20',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ],
            [
                'perumahan_id'      => 2,
                'nama'              => 'Siti Mariam',
                'email'             => 'siti@example.com',
                'telepon'           => '082134567891',
                'alamat'            => 'Jl. Kenanga No. 45, Jember',
                'tanggal_pembelian' => '2025-01-10',
                'created_at'        => date('Y-m-d H:i:s'),
                'updated_at'        => date('Y-m-d H:i:s'),
            ]
        ];

        // Insert ke tabel customer
        $this->db->table('customer')->insertBatch($data);
    }
}
