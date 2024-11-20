<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MenuModel;


class RestaurantDashboard extends Controller
{
    // Display the dashboard for managing menu items
    public function index()
    {
        // Ensure the restaurant is logged in        
        if (!session()->get('restaurant_id')) {
            return redirect()->to('/restaurant/login')->with('error', 'You must be logged in to manage your menu items.');
        }

        // Load the MenuModel to fetch the restaurant's menu items
        $menuModel = new MenuModel();
        $restaurant_id = session()->get('restaurant_id');
        
        // Get all menu items for the logged-in restaurant
        $data['menu_items'] = $menuModel->where('restaurant_id', $restaurant_id)->findAll();
        
        return view('restaurant/dashboard', $data);
    }

    // Add a new menu item
    public function addMenuItem()
{
    // Ensure the restaurant is logged in
    
    if (!session()->get('restaurant_id')) {
        
        return redirect()->to('/restaurant/login')->with('error', 'You must be logged in to add a menu item.');
    }

    $menuModel = new \App\Models\MenuModel();

    // Get form data
    $data = [
        'type'           => $this->request->getPost('type'),
        'name'           => $this->request->getPost('name'),
        'price'          => $this->request->getPost('price'),
        'quantity_limit' => $this->request->getPost('quantity_limit'),
        'restaurant_id'  => session()->get('restaurant_id'),
    ];
    $existingItem = $menuModel
        ->where('name', $data['name'])
        ->where('type', $data['type'])
        ->where('restaurant_id', $data['restaurant_id'])
        ->first();

    if ($existingItem) {
        return redirect()->back()->withInput()->with('error', 'This menu item already exists.');
    }

    // Handle photo upload
    $photo = $this->request->getFile('photo');
    if ($photo->isValid() && !$photo->hasMoved()) {
        $photoName = $photo->getRandomName();
        $photo->move('uploads/menu_photos', $photoName);
        $data['photo'] = 'uploads/menu_photos/' . $photoName;
    }
    

    if ($menuModel->skipValidation(true)->save($data)
    ) {
        
        return redirect()->to('/restaurant/dashboard')->with('success', 'Menu item added successfully.');
    } else {
        return redirect()->back()->with('error', 'Failed to add menu item.');
    }
}
public function toggleStatus($id)
{
    if (!session()->get('restaurant_id')) {
        return redirect()->to('/restaurant/login')->with('error', 'You must be logged in.');
    }

    $menuModel = new \App\Models\MenuModel();
    $menuItem = $menuModel->find($id);

    if ($menuItem) {
        $newStatus = ($menuItem['status'] === 'enabled') ? 'disabled' : 'enabled';

        if ($menuModel->update($id, ['status' => $newStatus])) {
            return redirect()->to('/restaurant/dashboard')->with('success', 'Menu item status updated successfully.');
        }
    }

    return redirect()->to('/restaurant/dashboard')->with('error', 'Failed to update status.');
}
public function deleteMenuItem($id)
{
    if (!session()->get('restaurant_id')) {
        return redirect()->to('/restaurant/login')->with('error', 'You must be logged in.');
    }

    $menuModel = new \App\Models\MenuModel();

    if ($menuModel->delete($id)) {
        return redirect()->to('/restaurant/dashboard')->with('success', 'Menu item deleted successfully.');
    } else {
        return redirect()->to('/restaurant/dashboard')->with('error', 'Failed to delete menu item.');
    }
}
public function updateQuantity($id)
{
    if (!session()->get('restaurant_id')) {
        return redirect()->to('/restaurant/login')->with('error', 'You must be logged in.');
    }

    $menuModel = new \App\Models\MenuModel();
    $newQuantity = $this->request->getPost('quantity_limit');

    if ($menuModel->update($id, ['quantity_limit' => $newQuantity])) {
        return redirect()->to('/restaurant/dashboard')->with('success', 'Quantity updated successfully.');
    } else {
        return redirect()->to('/restaurant/dashboard')->with('error', 'Failed to update quantity.');
    }
}



    // Edit an existing menu item
    public function editMenuItem($id)
    {
        // Ensure the restaurant is logged in
        if (!session()->get('restaurant_id')) {
            return redirect()->to('/restaurant/login')->with('error', 'You must be logged in to edit a menu item.');
        }

        $menuModel = new MenuModel();
        $data['menu_item'] = $menuModel->find($id);
        
        if (!$data['menu_item']) {
            return redirect()->to('/restaurant/dashboard')->with('error', 'Menu item not found.');
        }

        return view('restaurant/edit_menu_item', $data);
    }

    // Update an existing menu item
    public function updateMenuItem($id)
    {
        // Ensure the restaurant is logged in
        if (!session()->get('restaurant_id')) {
            return redirect()->to('/restaurant/login')->with('error', 'You must be logged in to update a menu item.');
        }

        $menuModel = new MenuModel();
        $data = [
            'type'           => $this->request->getPost('type'),
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'quantity_limit' => $this->request->getPost('quantity_limit'),
        ];

        // Handle photo upload
        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/menu_photos', $newName);
            $data['photo'] = 'uploads/menu_photos/' . $newName;
        }

        // Update the menu item
        if ($menuModel->update($id, $data)) {
            return redirect()->to('/restaurant/dashboard')->with('success', 'Menu item updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update menu item.');
        }
    }
    

   
}
