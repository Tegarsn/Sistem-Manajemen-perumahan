<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'Rika',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'karyawan',
                'nama'     => 'RIka',
                'status'   => 'Aktif'
            ],
            [
                'username' => 'ElGato',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'karyawan',
                'nama'     => 'El Gato',
                'status'   => 'Aktif'
            ],
            [
                'username' => 'UjangRambo',
                'password' => password_hash('password123', PASSWORD_DEFAULT),
                'role'     => 'mandor',
                'nama'     => 'UjangRambo',
                'status'   => 'Aktif'
            ],
            [
                'username' => 'admin1',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'nama'     => 'Admin Sistem',
                'status'   => 'Aktif'
            ],
        ];

        // Insert ke tabel user
        $this->db->table('user')->insertBatch($data);
    
    }
}
