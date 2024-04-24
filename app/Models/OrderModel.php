<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $allowedFields    = [
        'order_id',
        'firstname',
        'lastname',
        'email',
        'mobile',
        'user_id',
        'shipping_address',
        'city',
        'state',
        'country',
        'pincode',
        'subtotal',
        'total',
        'status',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $db;
    protected $db_connect;
    
    public function __construct(){
        $connect = \Config\Database::connect();
        $this->db_connect = $connect;
        $this->db = $connect->table('orders');
    }

    public function createOrder($data){
        $this->db->insert($data);
        return $this->db_connect->insertID();
    }
}
