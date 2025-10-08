<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDataPembelianTable extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id'             => [
            'type' => 'INT', 
            'auto_increment' => true
        ],
            'nomor_nota'     => [
            'type' => 'VARCHAR', 
            'constraint' => 50
        ],
            'tanggal'        => [
            'type' => 'DATE'
        ],
            'supplier'       => [
            'type' => 'VARCHAR', 
            'constraint' => 100, 
            'null' => true
        ],
            'total_harga'    => [
            'type' => 'DECIMAL', 
            'constraint' => '15,2', 
            'null' => true
        ],
            'created_at'     => [
            'type' => 'DATETIME', 
            'null' => true
        ],
            'updated_at'     => ['type' => 'DATETIME', 
            'null' => true
        ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pembelian_bahan');
    }

    public function down()
    {
        $this->forge->dropTable('pembelian_bahan');
    }
}
