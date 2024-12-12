<?php

namespace App\Models;

use CodeIgniter\Model;

class RestaurantModel extends Model
{
    protected $table = 'restaurants';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone_number', 'password', 'image', 'latitude', 'longitude', 'address','is_live','status']; // Include 'latitude' and 'longitude'

    // Method to verify restaurant login credentials
    public function verifyLogin($email, $password)
{
    // Fetch restaurant by email
    $restaurant = $this->where('email', $email)->first();

    if ($restaurant) {
        // Verify the password using password_verify
        if (password_verify($password, $restaurant['password'])) {
            return $restaurant;
        }
    }

    return null;
}

}
