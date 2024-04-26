<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProductModel;

class AdminController extends BaseController
{
    protected $product_obj;
    protected $validation;

    public function __construct(){  
        $this->product_obj = model(ProductModel::class); 
        $this->validation = \Config\Services::validation();
    }    
    
    public function index()
    {
        if(!session()->has('user_id'))
            return redirect()->to('admin/login');

        return $this->randerPage("admin/dashboard");
    }

    public function products(){
        if(!session()->has('user_id'))
            return redirect()->to('admin/login');
        
        $data = [];
        $data['products'] = [];
        $products = $this->product_obj->get();
        if($products->getNumRows() > 0){
            $data['products'] = $products->getResult();
        }
        return $this->randerPage("admin/product/list", $data);
    }

    public function addProduct(){
        if(!session()->has('user_id'))
            return redirect()->to('admin/login');

        return $this->randerPage("admin/product/add");
    }

    public function saveProduct(){
        
        $post = $this->request->getPost(['name','slug','quantity','price','discount_status','discounted_price','status','description']);
        $id = $this->request->getVar('id');

        $is_update = false;
        if(isset($id)){
            $productData = $this->product_obj->getProduct($id);
            // print_r($productData);
            if($productData){
                $is_update = true;
            }
            else{
                $this->session->setFlashData('form-error','Invalid product.');
                return redirect()->back()->withInput();
            }
        }

        $rules = [
            'name' => 'required',
            'quantity' => 'required|integer|greater_than_equal_to[1]',
            'price' => 'required|numeric|greater_than_equal_to[1]',
            'discount_status' => 'required|if_exist',
            'status' => 'required|if_exist',
        ];
        if(isset($post['discount_status']) && $post['discount_status'] == 'yes'){
            if(isset($post['discounted_price'])){
                $rules['discounted_price'] = [
                    'rules' => "required|numeric|greater_than_equal_to[1]",
                    'errors' => [
                        'required' => 'The discounted price is required.',
                        'numeric' => 'The discounted price field must contain only numbers.',
                        'greater_than_equal_to' => 'The discounted price field must contain a number greater than or equal to 1.',
                    ],
                ];
            }
        }
        
        $validate = $this->validateData($post,$rules);
        if(!$validate){    
            return redirect()->back()->withInput();
        }

        if(isset($post['discount_status']) && $post['discount_status'] == 'yes' && isset($post['discounted_price'])){
            if(isset($post['price']) && $post['discounted_price']>=$post['price']){
                $this->session->setFlashData('form-error','The discounted price field value must be less then product price.');
                return redirect()->back()->withInput();
            }
        }

        if($is_update){
            $post['updated_at'] = date('Y-m-d H:i:s');
            $this->product_obj->updateProduct($id, $post);
            $this->session->setFlashData('success','Product updated successfully.');
        }
        else{
            $post['created_at'] = date('Y-m-d H:i:s');
            $this->product_obj->addProduct($post);
            $this->session->setFlashData('success','Product created successfully.');
        }

        return redirect()->route('admin/manage-products');
    }

    public function editProduct($id){
        if(!session()->has('user_id'))
            return redirect()->to('admin/login');

        $product = $this->product_obj->getProduct($id);
        return $this->randerPage("admin/product/update",['product'=>$product]);
    }

    public function deleteProduct($id){
        if(!session()->has('user_id'))
            return redirect()->to('admin/login');
        
        $product = $this->product_obj->deleteProduct($id);
        $this->session->setFlashData('success','Product delete successfully.');
        return redirect()->route('admin/manage-products');
    }
}
