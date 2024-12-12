<?php 
namespace App\Models;

use CodeIgniter\Model;

class FavoritesModel extends Model 
{
    protected $table = 'favorites';
    protected $primaryKey = 'id';
    protected $allowedFields = ['customer_id', 'restaurant_id', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getFavoritesByCustomer($customerId)
{
    return $this->db->table('favorites')
        ->select('restaurants.id, restaurants.name, restaurants.image, restaurants.email, restaurants.phone_number, restaurants.address')
        ->join('restaurants', 'favorites.restaurant_id = restaurants.id')
        ->where('favorites.customer_id', $customerId)
        ->get()
        ->getResultArray();
}


    public function toggleFavorite($customerId, $restaurantId)
    {
        $existing = $this->where([
            'customer_id' => $customerId,
            'restaurant_id' => $restaurantId
        ])->first();

        if ($existing) {
            // Remove from favorites
            $this->delete($existing['id']);
            return ['status' => 'removed'];
        } else {
            // Add to favorites
            $this->insert([
                'customer_id' => $customerId,
                'restaurant_id' => $restaurantId
            ]);
            return ['status' => 'added'];
        }
    }

    public function isFavorited($customerId, $restaurantId)
    {
        return $this->where([
            'customer_id' => $customerId,
            'restaurant_id' => $restaurantId
        ])->countAllResults() > 0;
    }
}