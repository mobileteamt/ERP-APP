<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'firstname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'lastname' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'mobile' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'order_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'shipping_address' => [
                'type' => 'TEXT',
            ],
            'city' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'State' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'Country' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'pincode' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'subtotal' => [
                'type' => 'FLOAT',
                'default' => 0
            ],
            'total' => [
                'type' => 'FLOAT',
                'default' => 0
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'success', 'failed'],
                'default'    => 'pending',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('order_id', true);
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
