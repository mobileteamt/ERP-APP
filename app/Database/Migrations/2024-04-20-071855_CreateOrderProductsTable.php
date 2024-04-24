<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 11,
            ],
            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'constraint' => 11,
            ],
            'product_quantity' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'product_price' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'total_price' => [
                'type' => 'FLOAT',
                'default' => 0,
            ],
            'is_discounted' => [
                'type'       => 'ENUM',
                'constraint' => ['yes', 'no'],
                'default'    => 'no',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('order_products');
    }

    public function down()
    {
        $this->forge->dropTable('order_products');
    }
}
