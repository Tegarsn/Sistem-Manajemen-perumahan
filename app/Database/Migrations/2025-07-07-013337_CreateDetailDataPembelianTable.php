<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailDataPembelianTable extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'auto_increment' => true],
            'pembelian_id'       => ['type' => 'INT'],
            'bahan_bangunan_id'  => ['type' => 'INT'],
            'jumlah'             => ['type' => 'INT'],
            'harga_satuan'       => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'subtotal'           => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('detail_pembelian_bahan');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pembelian_bahan');
    }
}
