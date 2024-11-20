<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'register_customer';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'password', 'phone_number'];

    public function verifyLogin($email, $password)
    {
        return $this->where('email', $email)->where('password', md5($password))->first();
    }

    public function registerCustomer($data)
    {
        return $this->save($data);
    }
}
