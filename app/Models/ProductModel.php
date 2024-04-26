<?php

namespace App\Models;

use CodeIgniter\Model;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


class ProductModel extends Model
{
    protected $table            = 'products';
    protected $allowedFields    = ['product_id','name','slug','description','quantity','price','discount_status','discounted_price','status','created_at','updated_at'];
    protected $db;
    protected $db_connect;
    
    public function __construct(){
        $connect = \Config\Database::connect();
        $this->db_connect = $connect;
        $this->db = $connect->table('products');
    }

    public function getProduct($id){
        $product_data = [];
        $product = $this->db->where('product_id', $id)->get();
        if($product->getNumRows()>0){
            $product_data = $product->getRowArray();
        }
        return $product_data;
    }

    public function getProductBySlug($slug){
        $product_data = [];
        $product = $this->db->where('slug', $slug)->get();
        if($product->getNumRows()>0){
            $product_data = $product->getRowArray();
        }
        return $product_data;
    }

    public function addProduct($data){
        $query = $this->db->insert($data);
        $insert_id = $this->db_connect->insertID();
        $slug = strtolower($data['name']);
        $slug = str_replace(" ","-",$slug);
        $slug = preg_replace('/[^\p{L}\p{N}\s-]/u', '-', $slug);
        $slug = ltrim($slug, "-");
        $slug = rtrim($slug, "-");
        $slug = str_replace("_","-",$slug).'-'.$insert_id;
        $this->updateProduct($insert_id,['slug'=>$slug]);
    }

    public function updateProduct($id, $data){   
        $this->db->where('product_id', $id)->update($data);
    }

    public function deleteProduct($id){
        $this->db->where('product_id', $id)->delete();
    }

    public function getProducts(){
        $store_products = [];
        $products = $this->db->where(['status'=>'enable'])->get();
        if($products->getNumRows()>0){
            $store_products = $products->getResultArray();
        }
        return $store_products;
    }

    public function updateProductQty($product_id, $qty){
        $product = $this->getProduct($product_id);
        if(count($product)>0){  
            $p_qty = (int) $product['quantity'];
            $qty = (int) $qty;
            if($p_qty >= $qty){
                $new_qty = $p_qty - $qty;
                $this->updateProduct($product_id,['quantity'=>$new_qty]);
            }
        }
    }
}
