<?php
namespace App\Models;

use CodeIgniter\Model;

class FavoritesModel extends Model {
    protected $table = 'favorites';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'restaurant_id', 'created_at'];


    public function getFavoritesByCustomer($customerId)
    {
        return $this->where('customer_id', $customerId)->findAll();
    }

}
?>