<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBahanPembangunanRumahTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true
            ],
            'perumahan_id' => [
                'type'       => 'INT',
            ],
            'mandor_id' => [
                'type' => 'INT',
            ],
            'bahan_bangunan_id' => [
                'type'       => 'INT',
            ],
            'jumlah_pemakaian' => [
                'type'       => 'INT',
            ],
            'tanggal_penggunaan' => [
                'type'       => 'DATE',
            ],
            'keterangan' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('bahan_pembangunan_rumah');
    }

    public function down()
    {
        $this->forge->dropTable('bahan_pembangunan_rumah');
    }
}
