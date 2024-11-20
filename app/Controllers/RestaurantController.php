<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;

class RestaurantController extends Controller
{
    // Display the restaurant login page
    public function login()
    {
        
        return view('restaurant/login');
    }

    // Handle restaurant login form submission
    public function loginSubmit()
{
    // Get form data
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Validate the form inputs
    $validation = \Config\Services::validation();
    $validation->setRules([
        'email' => 'required|valid_email',
        'password' => 'required|min_length[6]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('error', $validation->listErrors());
    }

    // Instantiate the RestaurantModel
    $model = new RestaurantModel();

    // Verify login credentials
    $restaurant = $model->verifyLogin($email, $password);

    if ($restaurant) {
        // Store session data
        session()->set('restaurant_id', $restaurant['id']);
        session()->set('restaurant_name', $restaurant['name']);

        return redirect()->to('/restaurant/dashboard'); // Redirect to dashboard
    } else {
        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->to('/restaurant/login');
    }
}


    public function register()
    {
        return view('restaurant/register');
    }

    // Handle restaurant registration form submission
    public function registerSubmit()
{
    // Get form data
    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $phone_number = $this->request->getPost('phone_number');
    $address = $this->request->getPost('address');
    $password = $this->request->getPost('password');
    $latitude = $this->request->getPost('latitude');
    $longitude = $this->request->getPost('longitude');

    // Validate the form input
    $validation =  \Config\Services::validation();
    $validation->setRules([
        'name' => 'required',
        'email' => 'required|valid_email',
        'phone_number' => 'required',
        'address' => 'required',
        'password' => 'required|min_length[6]',
        'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]',
        'latitude' => 'required|decimal',
        'longitude' => 'required|decimal',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('error', $validation->listErrors());
    }

    // Handle image upload
    $imageFile = $this->request->getFile('image');
    if ($imageFile->isValid() && !$imageFile->hasMoved()) {
        // Generate a random name for the image
        $imageName = $imageFile->getRandomName();
        
        // Move the image to the public/restaurant folder
        $imageFile->move(WRITEPATH . '../public/restaurant', $imageName);
        
        // Save the image path in the database (relative to the public folder)
        $imagePath = 'restaurant/' . $imageName;
    } else {
        // If no image is uploaded, set the imagePath to null
        $imagePath = null;
    }

    // Instantiate the RestaurantModel
    $model = new RestaurantModel();

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the data for insertion
    $data = [
        'name' => $name,
        'email' => $email,
        'phone_number' => $phone_number,
        'password' => $hashedPassword,
        'address' => $address,
        'image' => $imagePath, // Store the image path in the database
        'latitude' => $latitude, // Save the latitude
        'longitude' => $longitude, // Save the longitude
    ];

    // Insert restaurant data into the database
    if ($model->save($data)) {
        return redirect()->to('/restaurant/login')->with('success', 'Registration successful! Please login.');
    } else {
        return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
    }
}
public function RestaurantMenu($restaurantId)
{
    // Load the restaurant and menu models
    $restaurantModel = new RestaurantModel();
    $menuModel = new MenuModel();

    // Get the restaurant data
    $restaurant = $restaurantModel->find($restaurantId);

    // If the restaurant does not exist, redirect back
    if (!$restaurant) {
        return redirect()->to('/customer/dashboard')->with('error', 'Restaurant not found.');
    }

    // Get the menu for the restaurant
    $menu = $menuModel->where('restaurant_id', $restaurantId)->findAll();

    // Pass the data to the view
    return view('restaurant/menu', ['restaurant' => $restaurant, 'menu' => $menu]);
}
public function logout()
    {
        // Destroy the session
        session()->destroy();

        // Redirect to the login page
        return redirect()->to('/restaurant/login')->with('success', 'You have been logged out successfully.');
    }


}
