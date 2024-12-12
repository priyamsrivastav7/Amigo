<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone_number', 'password', 'image', 'latitude', 'longitude', 'address','is_live','status']; // Include 'latitude' and 'longitude'

    
    public function verifyLogin($email, $password)
{
    
    $restaurant = $this->where('email', $email)->first();

    if ($restaurant) {
        
        if (password_verify($password, $restaurant['password'])) {
            return $restaurant;
        }
    }

    return null;
}

}
