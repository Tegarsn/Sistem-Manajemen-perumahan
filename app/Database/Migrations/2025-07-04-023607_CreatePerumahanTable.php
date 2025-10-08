<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerumahanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'            => 'INT',
                'auto_increment'  => true,
                'unsigned'        => true
            ],
            'kode_rumah' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'lokasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ],
            'tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => '50'
            ],
            'luas_tanah' => [
                'type' => 'INT',
                'null' => true
            ],
            'luas_bangunan' => [
                'type' => 'INT',
                'null' => true
            ],

            'harga' => [
                'type' => 'BIGINT'
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Tanah', 'Proses Pembangunan', 'Dijual', 'Terjual']
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
            ],
            'updated_at' => [
                'type'  => 'TIMESTAMP',
                'null'  => 'true',
            ]
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('perumahan');
    }

    public function down()
    {
        $this->forge->dropTable('perumahan');
    }
}
