<?php


namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;
use App\Models\CartModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;

class UserController extends BaseController
{
    protected $product_obj;
    protected $cart_obj;
    protected $order_obj;
    protected $order_product_obj;

    public function __construct(){
        $this->product_obj = model(ProductModel::class);
        $this->cart_obj = model(CartModel::class);
        $this->order_obj = model(OrderModel::class);
        $this->order_product_obj = model(OrderProductModel::class);
    }

    public function index()
    {
        return $this->randerPage("user/home");
    }

    public function products(){
        $products = $this->product_obj->getProducts();
        return $this->randerPage("user/products",['products'=>$products]);
    }

    public function productDetails($slug){
        $product = $this->product_obj->getProductBySlug($slug);
        return $this->randerPage("user/productDetails",['product'=>$product]);
    }

    public function addToCart(){
        
        $post = $this->request->getPost();
        // echo '<pre>';print_r($post);
        $product_id = $this->request->getVar('product_id');
        $quantity = $this->request->getVar('qty');
        $datetime = date("Y-m-d H:i:s");
        
        if(isset($product_id) && isset($quantity))
        {
            $product_data = $this->product_obj->getProduct($product_id);
            $product_qty = $product_data['quantity']; 
            
            $cookie_id = $this->cart_obj->getCookie('cookie_id');
            if($cookie_id)
            { 
                $cart_data = $this->cart_obj->getCartData($cookie_id,$product_id);
                if($cart_data){
                    // echo 'update'; die();
                    $newQty = $cart_data['qty'] + $quantity;
                    if($newQty > $product_qty){
                        echo json_encode(['error'=>true, 'message'=>'Sorry!! no more quantity available in our stock.']);
                        exit;
                    }
                    $this->cart_obj->updateCart(['cart_id'=>$cart_data['cart_id']],['qty'=>$newQty,'updated_at'=>$datetime]);
                }
                else{
                    // echo 'create 1';
                    if($quantity > $product_qty){
                        echo json_encode(['error'=>true, 'message'=>'Sorry!! Your selected quantity is not available in our stock.']);
                        exit;
                    }
                    $add_cart = [
                        'cookie_id' => $cookie_id,
                        'product_id' => $product_id,
                        'qty' => $quantity,
                        'user_id' => '0',
                        'order_id' => '0',
                        'created_at' => $datetime
                    ];
                    $this->cart_obj->createCart($add_cart);
                }
            }
            else{
                if($quantity > $product_qty){
                    echo json_encode(['error'=>true, 'message'=>'Sorry!! Your selected quantity is not available in our stock.']);
                    exit;
                }
                // echo 'create 2';die();
                $max_cookie = $this->cart_obj->getMaxCookie();
                $cookie_id = (int)$max_cookie + 1;
                $add_cart = [
                    'cookie_id' => $cookie_id,
                    'product_id' => $product_id,
                    'qty' => $quantity,
                    'user_id' => '0',
                    'order_id' => '0',
                    'created_at' => $datetime
                ];
                $this->cart_obj->setCartCookie('cookie_id', $cookie_id);
                $this->cart_obj->createCart($add_cart);
            }
            $cart_count = $this->cart_obj->getCartCount($cookie_id);
            echo json_encode(['error'=>false, 'message'=>'The product has been successfully added to the cart.','cart_count'=>$cart_count]);
        }
        else{
            echo json_encode(['error'=>true, 'message'=>'Something went wrong!!']);
        }
    }

    public function updateCartQty(){
        $post = $this->request->getPost();
        $cart_id = $this->request->getVar('cart_id');
        $qty = $this->request->getVar('qty');
        $action = $this->request->getVar('action');

        $cart_product = $this->cart_obj->getCartByCookie($cart_id);
        if($cart_product){
            if($action == 'plus' && $qty>$cart_product['quantity']){
                echo json_encode(['error'=>true, 'message'=>'Invalid qty']);
            }
            else{
                $this->cart_obj->updateCart(['cart_id'=>$cart_id],['qty'=>$qty]);
                $cart_details = $this->cart_obj->getCartDetails();
                echo json_encode(['error'=>false, 'message'=>'The product quantity has updated successfully.','cart_total'=>$cart_details['total']]);
            }
        }
        else{
            echo json_encode(['error'=>true, 'message'=>'Something went wrong!!']);
        }
    }

    public function cart(){
        $cart_data = $this->cart_obj->getCartByCookie();
        return $this->randerPage("user/cart",['cart_data'=>$cart_data]);
    }

    public function deleteCart(){
        $cart_id = $this->request->getVar('cart_id');
        if($cart_id){
            $cart_details = $this->cart_obj->deleteUserCart($cart_id);
            echo json_encode(['error'=>false, 'message'=>'The product has been successfully removed from the cart.','cart_total'=>$cart_details['total']]);
        }
        else{
            echo json_encode(['error'=>true, 'message'=>'Something went wrong!!']);
        }
    }

    public function checkout(){

        $cart_count = $this->cart_obj->getCartCount();
        if($cart_count>0){
            return $this->randerPage("user/checkout");
        }
        else{
            return redirect()->to("/");
        }
    }

    public function placeOrder(){
        $post = $this->request->getPost();
        $datetime = date("Y-m-d H:i:s");

        $rules = [
            'firstname' => 'required|alpha_numeric_space',
            'lastname' => 'required|alpha_numeric_space',
            'email' => 'required|valid_email',
            'mobile' => 'required|integer|max_length[10]|min_length[10]',
            'city' => 'required|alpha_numeric_space|max_length[20]',
            'pincode' => 'required|integer|min_length[6]|max_length[6]',
            'state' => 'if_exist|max_length[30]',
            'country' => 'if_exist|max_length[30]',
        ];
        $rules['shipping_address'] = [
            'label' => 'Address',
            'rules' => 'required',
            'errors' => [
                'required' => 'The address field is required.'
            ] 
        ];

        $validate = $this->validateData($post,$rules);
        if(!$validate){    
            return redirect()->back()->withInput();
        }

        $cart_data = $this->cart_obj->getCartByCookie();
        if($cart_data){
            
            $order_payload = [
                'firstname' => $this->request->getVar('firstname'),
                'lastname' => $this->request->getVar('lastname'),
                'email' => $this->request->getVar('email'),
                'mobile' => $this->request->getVar('mobile'),
                'user_id' => '0',
                'shipping_address' => $this->request->getVar('shipping_address'),
                'city' => $this->request->getVar('city'),
                'state' => $this->request->getVar('state'),
                'country' => $this->request->getVar('country'),
                'pincode' => $this->request->getVar('pincode'),
                'subtotal' => '',
                'total' => '',
                'status' => 'Pending',
                'created_at' => $datetime
            ];
    
            $order_products = [];
            $total = 0;
            foreach($cart_data as $cdata)
            {
                $p_price = $cdata['discount_status'] == 'yes' && $cdata['discounted_price'] > 0 ? $cdata['discounted_price'] : $cdata['price'];
                $total_price = $cdata['qty']*$p_price;
                $is_discounted = $cdata['discount_status'] == 'yes' && $cdata['discounted_price'] > 0 ? 'yes' : 'no';
                $total+= $total_price;

                $order_products[] = [
                    'order_id' => '',
                    'product_id' => $cdata['product_id'],
                    'product_quantity' => $cdata['qty'],
                    'product_price' => $p_price,
                    'total_price' => $total_price,
                    'is_discounted' => $is_discounted,
                    'created_at' => $datetime
                ];
            }

            $order_payload['subtotal'] = $total;
            $order_payload['total'] = $total;

            $order_id = $this->order_obj->createOrder($order_payload);
            foreach($order_products as &$product){
                $product['order_id'] = $order_id;
                $this->order_product_obj->createOrderProduct($product);
                $this->product_obj->updateProductQty($product['product_id'], $product['product_quantity']);
            }

            // echo '<pre>';print_r($order_products);
            // echo '<pre>';print_r($order_payload);

            $this->cart_obj->updateCart(['cookie_id'=>$cart_data[0]['cookie_id']],['order_id'=>$order_id]);
            $removeCookie = $this->cart_obj->deleteCookie('cookie_id');
            $this->session->setFlashData('success','Order created successfully.');
            return redirect()->to('/')->withCookies($removeCookie);
        }
    }
}
