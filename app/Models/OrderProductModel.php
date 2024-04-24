<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderProductModel extends Model
{
    protected $table            = 'order_products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['order_id','product_id','product_quantity','product_price','total_price','is_discounted','created_at','updated_at'];

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
        $this->db = $connect->table('order_products');
    }

    public function createOrderProduct($data){
        $this->db->insert($data);
    }
}
