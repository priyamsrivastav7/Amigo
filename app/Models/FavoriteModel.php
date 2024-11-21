<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model {
    protected $table = 'customer_favorites';
    protected $allowedFields = ['customer_id', 'restaurant_id'];

    public function isFavorite($customerId, $restaurantId) {
        return $this->where(['customer_id' => $customerId, 'restaurant_id' => $restaurantId])->first();
    }

    public function addFavorite($customerId, $restaurantId) {
        $this->insert(['customer_id' => $customerId, 'restaurant_id' => $restaurantId]);
    }

    public function removeFavorite($customerId, $restaurantId) {
        $this->where(['customer_id' => $customerId, 'restaurant_id' => $restaurantId])->delete();
    }

    public function getFavoriteRestaurants($customerId) {
        return $this->select('restaurants.*')
            ->join('restaurants', 'restaurants.id = customer_favorites.restaurant_id')
            ->where('customer_favorites.customer_id', $customerId)
            ->findAll();
    }
}
