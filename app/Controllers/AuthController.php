<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController
{
    protected $user_obj;
    protected $validation;

    public function __construct(){
        $this->user_obj = model(UserModel::class); 
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if(session()->has('user_id'))
            return redirect()->to('admin/dashboard');

        return $this->randerPage("admin/login");
    }

    public function signup(){
        $post = $this->request->getPost(['username','email','password','confirm_password']);
        // echo '<pre>';print_r($post);
        $datetime = date("Y-m-d H:i:s");

        $rules = [
            'username' => 'required|alpha',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]',
        ];

        $signup = [
            'username' => $post['username'],
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'role' => '1',
            'created_at' => $datetime
        ];
        
        $validate = $this->validateData($post,$rules);
        if(!$validate){    
            return redirect()->back()->withInput();
        }

        $this->user_obj->signUp($signup);
        $this->session->setFlashData('form-success','You are registered successfully. Please login to continue.');
        return redirect()->route("admin/login");
    }   

    public function loginUser(){
        $postdata = $this->request->getPost(['email','password']);

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        $validate = $this->validateData($postdata,$rules);
        if(!$validate){    
            return redirect()->back()->withInput();
        }

        $valid_user = $this->user_obj->validateUser($postdata['email'],$postdata['password']);
        if($valid_user['error']){
            $this->session->setFlashData('form-error',$valid_user['message']);
            return redirect()->back();
        }

        $user_data = $valid_user['data'];

        $session = $this->session;
        $session->set('user_id', $user_data['id']);
        $session->set('user_name', $user_data['username']);
        $session->set('email', $user_data['email']);
        
        return redirect()->route("admin/dashboard");
    }

    public function logout(){
        $this->session->destroy();
        return redirect()->route("admin/login");
    }

    /*
    public function createAdminCodeBackup(){
        $create = [];
        $create['username'] = 'Admin';
        $create['email'] = $postdata['email'];
        $create['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
        $create['role'] = '1';
        $create['created_at'] = date("Y-m-d H:i:s");

        $user = new UserModel();
        $user->save($create);
    }
    */
}
