<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\RestaurantModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;

class CustomerController extends Controller
{
    public function dashboard()
    {
        // Check if customer is logged in
        
        if (!session()->has('customer_id')) {
            return redirect()->to('/customer/login');
        }

        // Instantiate the Restaurant model
        $restaurantModel = new RestaurantModel();

        // Get all registered restaurants
        $restaurants = $restaurantModel->findAll();

        // Pass the list of restaurants to the view
        return view('customer/dashboard', ['restaurants' => $restaurants]);
    }

    public function login()
    {
        
        $session = session();
        if($session ->get('customer_id') ){
            return redirect()->to('customer/dashboard');
        }
        return view('customer/login');
    }

    public function loginUser()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new CustomerModel();
        
        $customer = $model->verifyLogin($email, $password);
        

        if ($customer) {
            // Login successful
            session()->set('customer_id', $customer['id']);
            
            return redirect()->to('customer/dashboard');  // Redirect to the customer dashboard
        } else {
            // Invalid credentials
            session()->setFlashdata('error', 'Invalid email or password.');
            return redirect()->to('/customer/login');
        }
    }

    public function register()
    {
        return view('customer/register');
    }

    // Handle registration form submission
    public function registerSubmit()
    {
        // Get form data
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $phone_number = $this->request->getPost('phone_number');
        $password = $this->request->getPost('password');
        
        // Validation rules
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[register_customer.email]',
            'password' => 'required|min_length[6]',
        ]);

        // Check if validation passes
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        // Prepare customer data
        $customerData = [
            'name' => $name,
            'email' => $email,
            'phone_number' => $phone_number,
            'password' => md5($password), // Ensure password is encrypted
        ];

        // Instantiate the CustomerModel
        $model = new CustomerModel();

        // Save customer to the database
        if ($model->registerCustomer($customerData)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/customer/login');
        } else {
            session()->setFlashdata('error', 'Registration failed, please try again.');
            return redirect()->to('/customer/register');
        }
    }
    public function logout()
    {
        
        session()->destroy();  
        return redirect()->to('customer/login');
    }

    public function menu($restaurantId =null )
{

    if (!session()->has('customer_id')) {
        return redirect()->to('/customer/login');
    }
    // $restaurantId = session()->get('restaurant_id');
    if (!$restaurantId) {
        return redirect()->to('/customer/dashboard'.$restaurantId);
    }

    // Load the restaurant model and menu model
    $restaurantModel = new RestaurantModel();
    $menuModel = new MenuModel();

    // Verify restaurant exists
    $restaurant = $restaurantModel->find($restaurantId);
    if (!$restaurant) {
        return redirect()->to('/customer/dashboard');
    }

    // Fetch all enabled menu items for this restaurant
    $menuItems = $menuModel->getMenuItemsByRestaurant($restaurantId, ['status' => 'enabled']);

    // Pass data to the view
    $data = [
        'restaurant' => $restaurant,
        'menuItems' => $menuItems
        
    ];

    return view('restaurant/menu', $data);
}
}
