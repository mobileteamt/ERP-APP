<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'product_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'quantity' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
            ],
            'price' => [
                'type' => 'FLOAT',
            ],
            'discount_status' => [
                'type'       => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default'    => 'no',
            ],
            'discounted_price' => [
                'type' => 'FLOAT',
                'default' => NULL,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['enable', 'disable'],
                'default'    => 'enable',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('product_id', true);
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
