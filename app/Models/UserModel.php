<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['id','username','email','password','role','created_at','updated_at'];

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
        $this->db = $connect->table('users');
    }  

    public function signUp($data){
        $this->db->insert($data);
    }

    public function validateUser($email, $password){
        $user = $this->db->where('email',$email)->get()->getRowArray();
        $response = [];
        if(!$user || !password_verify($password, $user['password'])){    
            $response = ['error'=>true,'message'=>'Invalid login credentials.'];
        }
        else{
            $response = ['error'=>false,'message'=>'login success','data'=>$user];
        }
        return $response;
    }

    public function checkAdminUser(){
        $adminUser = $this->db->where('role','1')->get();
        if($adminUser->getNumRows()>0){
            return true;
        }
        return false;
    }
}
