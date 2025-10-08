<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Realisasibahan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'realisasi_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'bahan_bangunan_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'harga_satuan' => [
                'type' => 'BIGINT',
                'null' => true,
                'constraint' => 20,
            ],
            'sub_total' => [
                'type' => 'BIGINT',
                'null' => true,
                'constraint' => 20,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('realisasi_bahan');
    }

    public function down()
    {
        $this->forge->createTable('realisasi_bahan');
    }
}
