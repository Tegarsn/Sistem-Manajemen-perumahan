<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatebahanbangunanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'            => 'INT',
                'auto_increment'  => true,
                'unsigned'        => true
            ],
            'nama_bahan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100'
            ],
            'satuan' => [
                'type'       => 'VARCHAR',
                'constraint' => '20'
            ],
            'stok' => [
                'type'       => 'INT',
                'default'    => 0
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

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('bahan_bangunan');
    }

    public function down()
    {
        $this->forge->dropTable('bahan_bangunan');
    }
}
