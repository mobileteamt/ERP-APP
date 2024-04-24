<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class CartModel extends Model
{
    protected $table            = 'cart';
    protected $primaryKey       = 'cart_id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['cart_id','cookie_id','product_id','qty','user_id','order_id','created_at','updated_at'];

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
        $this->db = $connect->table('cart');
        helper('cookie');
    }

    public function getCartData($cookie_id,$product_id){
        $cart_data = $this->db->where(['cookie_id'=>$cookie_id,'product_id'=>$product_id])->get();
        if($cart_data->getNumRows()>0){
            return $cart_data->getRowArray();
        }
        return false;
    }

    public function updateCart($where, $data){
        $this->db->where($where)->update($data);
    }

    public function createCart($data){
        $this->db->insert($data);
    }

    public function setCartCookie($name, $value){
        $name = (string) $name;
        $value = (string) $value;
        $response = service('response');
        $response->setCookie($name, $value, 86400); // expires in 24 hours
    }

    public function getCartCount($cookie_id = false){
        if($cookie_id){
            $get_by_cookie = $cookie_id;
        }
        else{
            $get_by_cookie = $this->getCookie('cookie_id');
        }
        
        $cart_count = 0;
        if($get_by_cookie){
            $count_data = $this->db->selectSum('qty','cart_count')->where('cookie_id',$get_by_cookie)->orderBy('product_id')->get();
            $cart_count = $count_data->getRow()->cart_count;
        }
        return (int)$cart_count;
    }

    public function getCookie($name){
        return get_cookie($name);
    }

    public function deleteCookie($name){
        $name = (string) $name;
        $response = service('response');
        return $response->setCookie($name, '', time() - 86400);
    }

    public function getMaxCookie(){
        $query = $this->db->selectMax('cookie_id')->get();
        if($query->getNumRows()>0){
            return $query->getRow()->cookie_id;
        }
        return 0;
    }

    public function getCartByCookie($cart_id = false){
        $cookie_id = $this->getCookie('cookie_id');
        $where = [];
        if($cart_id){
            $where['cart_id'] = $cart_id;
        }
        else{
            $where['cookie_id'] = $cookie_id;
        }

        $this->db->select('products.*, cart.cart_id, cart.qty, cart.cookie_id');
        $this->db->join('products','products.product_id = cart.product_id');
        $cart_data = $this->db->where($where)->get();
        if($cart_data->getNumRows()>0){
            if($cart_id){
                return $cart_data->getRowArray();
            }
            else{   
                return $cart_data->getResultArray();
            }
        }
        return false;
    }

    public function getCartProduct($slug){
        $cookie_id = $this->getCookie('cookie_id');

        $this->db->select('products.*, cart.cart_id, cart.qty, cart.cookie_id');
        $this->db->join('products','products.product_id = cart.product_id');
        $cart_data = $this->db->where(['cart.cookie_id'=>$cookie_id,'products.slug'=>$slug])->get();
        if($cart_data->getNumRows()>0){
            return $cart_data->getRowArray();
        }
        return false;
    }

    public function deleteUserCart($cart_id){
        $this->db->where('cart_id', $cart_id)->delete();
        return $this->getCartDetails();
    }

    public function getCartDetails(){
        $cart_data = $this->getCartByCookie();
        return $this->getCartPrices($cart_data);
    }

    public function getCartPrices($cart_data){
        $cart_total = 0;
        if($cart_data){
            foreach($cart_data as $item){
                if($item['discount_status'] == 'yes' && $item['discounted_price']>0){
                    $product_price = $item['discounted_price'];
                }
                else{
                    $product_price = $item['price'];
                }
                $cart_total += $item['qty']*$product_price;
            }
        }
        return [
            'total' => $cart_total
        ];
    }

    public function getProductWithCart($cart_id){
        $this->db->select('products.product_id, products.quantity as product_qty, cart.cart_id, cart.qty, cart.cookie_id');
        $this->db->join('products','products.product_id = cart.product_id');
        $cart_data = $this->db->where(['cart.cart_id'=>$cart_id])->get();
        if($cart_data->getNumRows()>0){
            $cart_product = $cart_data->getRowArray();
            // echo '<pre>';
            // print_r($cart_product);
            return $cart_product;
        }
        return false;
    }
}
