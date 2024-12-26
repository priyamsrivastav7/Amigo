<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MenuModel;


class RestaurantDashboard extends Controller
{
    
    public function index()
    {
               
        if (!session()->get('restaurant_id')) {
            return redirect()->to('/restaurant/login')->with('error', 'You must be logged in to manage your menu items.');
        }
        $menuModel = new MenuModel();
        $restaurant_id = session()->get('restaurant_id');
        $menuItems = $menuModel->where('restaurant_id', $restaurant_id)->findAll();
        $restaurantModel = new \App\Models\RestaurantModel();
        $restaurant = $restaurantModel->find($restaurant_id);
        
        
        return view('restaurant/dashboard', [
            'restaurant' => $restaurant,
            'menu_items' => $menuItems,
        ]);
    }

    
    public function addMenuItem()
{
    // Retrieve form data
    $type = $this->request->getPost('type');
    $name = $this->request->getPost('name');
    $price = $this->request->getPost('price');
    $quantity_limit = $this->request->getPost('quantity_limit');

    // Handle multiple file uploads
    $photos = $this->request->getFiles(); // Retrieve all uploaded files
    $uploadedPhotos = [];

    if (isset($photos['photos']) && is_array($photos['photos'])) {
        foreach ($photos['photos'] as $photo) {
            if ($photo->isValid() && !$photo->hasMoved()) {
                // Generate a random name for the file
                $newName = $photo->getRandomName();
        
                // Move the file to the public directory (accessible via the web)
                $photo->move( FCPATH . 'uploads/menu_items/', $newName);
        
                // Store the relative path of the uploaded file (accessible via the web)
                $uploadedPhotos[] = 'uploads/menu_items/' . $newName;
            }
        }
        
    }

    
    $menuData = [
        'type' => $type,
        'name' => $name,
        'price' => $price,
        'quantity_limit' => $quantity_limit,
        'photos' => json_encode($uploadedPhotos), 
        'status' => 'enabled', 
        'restaurant_id' => session()->get('restaurant_id'),
    ];

   
    $menuModel = new \App\Models\MenuModel();
    
    if (!$menuModel->insert($menuData)) {
        dd($menuModel->errors()); // Display validation errors
    }
    
    return redirect()->to('/restaurant/mainmenu')->with('success', 'Menu item added successfully!');
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
            return redirect()->to('/restaurant/mainmenu')->with('success', 'Menu item status updated successfully.');
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
        return redirect()->to('/restaurant/mainmenu')->with('success', 'Quantity updated successfully.');
    } else {
        return redirect()->to('/restaurant/mainmenu')->with('error', 'Failed to update quantity.');
    }
}


public function editMenuItem($id)
{
   
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

    
    public function updateMenuItem($id)
    {
        
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

        $photo = $this->request->getFile('photo');
        if ($photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move(WRITEPATH . 'uploads/menu_photos', $newName);
            $data['photo'] = 'uploads/menu_photos/' . $newName;
        }

        
        if ($menuModel->update($id, $data)) {
            return redirect()->to('/restaurant/dashboard')->with('success', 'Menu item updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update menu item.');
        }
    }
    public function mainmenu()
{
    // Load the model for menu items
    $menuModel = new \App\Models\MenuModel();
    $restaurant_id = session()->get('restaurant_id');
    $menuItems = $menuModel->where('restaurant_id', $restaurant_id)->findAll();
    
    if (empty($menuItems)) {
        echo "No menu items found for the restaurant.";
        
    }

    return view('restaurant/mainmenu',  ['menuItems' => $menuItems]);
}


    

   
}
