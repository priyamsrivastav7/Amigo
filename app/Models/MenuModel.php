<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu_items';
    protected $primaryKey = 'id';

    // Add 'photos' to the allowed fields (use plural for JSON storage)
    protected $allowedFields = [
        'type', 'name', 'price', 'photos', 'restaurant_id', 'quantity_limit', 'status'
    ];

    // Remove the specific 'photo' validation and handle JSON-encoded photos
    protected $validationRules = [
        'type' => 'required|in_list[Beverages,Starter,Main Course,Dessert]',
        'name' => 'required|min_length[3]',
        'price' => 'required|decimal',
        'quantity_limit' => 'required|integer',
        // Validation for 'photos' is handled in the controller (e.g., `is_image` and `max_size`)
        'status' => 'in_list[enabled,disabled]',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Method to fetch menu items for a specific restaurant
    public function getMenuItemsByRestaurant($restaurantId, $filters = [])
    {
        $query = $this->where('restaurant_id', $restaurantId);

        // Apply filters if provided
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->findAll();
    }
}
