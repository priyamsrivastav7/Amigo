<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu_items';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type', 'name', 'price', 'photo', 'restaurant_id', 'quantity_limit','status'
    ];

    protected $validationRules = [
        'type' => 'required|in_list[Beverages,Starter,Main Course,Dessert]',
        'name' => 'required|min_length[3]',
        'price' => 'required|decimal',
        'quantity_limit' => 'required|integer',
        'photo' => 'uploaded[photo]|is_image[photo]|max_size[photo,2048]',
        'status' => 'in_list[enabled,disabled]',
    ];


    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
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
