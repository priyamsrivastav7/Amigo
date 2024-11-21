<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\RestaurantModel;
use App\Models\MenuModel;
use App\Models\FavoritesModel;
use CodeIgniter\Controller;

class CustomerController extends Controller
{
    protected $db;

    public function __construct()
    {
        // Load the database connection
        $this->db = \Config\Database::connect();
        $this->restaurantModel = new RestaurantModel();
        $this->favoriteModel = new FavoritesModel();
    }

    // Customer Dashboard
    public function dashboard()
    {
        // Ensure the customer is logged in
        $customerId = session()->get('customer_id');
        if (!$customerId) {
            return redirect()->to('/customer/login');
        }

        // Fetch restaurants and favorite restaurants
        $restaurantModel = new RestaurantModel();
        $restaurants = $restaurantModel->findAll();

        $favoriteModel = new FavoritesModel();
        $favorites = $favoriteModel->getFavoritesByCustomer(session()->get('customer_id'));

        return view('customer/dashboard', [
            'restaurants' => $restaurants,
            'favorites' => $favorites
        ]);
    }
    

    public function favoriteRestaurants() {
        $customerId = session()->get('customer_id');
        $favoritesModel = new \App\Models\FavoritesModel();
    
        // Get favorite restaurant IDs
        $favoriteIds = $favoritesModel
            ->where('customer_id', $customerId)
            ->findColumn('restaurant_id');
    
        if ($favoriteIds) {
            $restaurantModel = new \App\Models\RestaurantModel();
            $favorites = $restaurantModel
                ->whereIn('id', $favoriteIds)
                ->findAll();
        } else {
            $favorites = [];
        }
    
        return view('customer_dashboard', ['favorites' => $favorites]);
    }

    public function toggleFavorite($restaurant_id)
{
    $customer_id = session()->get('customer_id'); // Assuming customer session is set

    // Check if the restaurant exists
    $restaurant = $this->restaurantModel->find($restaurant_id);
    
    if (!$restaurant) {
        // Handle the case where the restaurant does not exist
        return redirect()->back()->with('error', 'Restaurant not found.');
    }

    // Check if the restaurant is already in favorites
    $favorite = $this->favoriteModel->where('customer_id', $customer_id)
                                    ->where('restaurant_id', $restaurant_id)
                                    ->first();
    
    if ($favorite) {
        // Remove from favorites
        $this->favoriteModel->delete($favorite['id']);
        return redirect()->back()->with('success', 'Removed from favorites.');
    } else {
        // Add to favorites
        $this->favoriteModel->save([
            'customer_id' => $customer_id,
            'restaurant_id' => $restaurant_id,
        ]);
        return redirect()->back()->with('success', 'Added to favorites.');
    }
}

    
    

    

    // Customer Login
    public function login()
    {
        $session = session();
        if ($session->get('customer_id')) {
            return redirect()->to('customer/dashboard');
        }
        return view('customer/login');
    }

    // Handle Customer Login
    public function loginUser()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $model = new CustomerModel();
        $customer = $model->verifyLogin($email, $password);

        if ($customer) {
            session()->set('customer_id', $customer['id']);
            return redirect()->to('customer/dashboard');
        } else {
            session()->setFlashdata('error', 'Invalid email or password.');
            return redirect()->to('/customer/login');
        }
    }

    // Customer Registration
    public function register()
    {
        return view('customer/register');
    }

    public function registerSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[register_customer.email]',
            'password' => 'required|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $customerData = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone_number' => $this->request->getPost('phone_number'),
            'password' => md5($this->request->getPost('password')), // Encrypt password
        ];

        $model = new CustomerModel();
        if ($model->registerCustomer($customerData)) {
            session()->setFlashdata('success', 'Registration successful! Please login.');
            return redirect()->to('/customer/login');
        } else {
            session()->setFlashdata('error', 'Registration failed, please try again.');
            return redirect()->to('/customer/register');
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to('customer/login');
    }

    // Display Restaurant Menu
    public function menu($restaurantId = null)
    {
        if (!session()->has('customer_id')) {
            return redirect()->to('/customer/login');
        }

        if (!$restaurantId) {
            return redirect()->to('/customer/dashboard');
        }

        $restaurantModel = new RestaurantModel();
        $menuModel = new MenuModel();

        $restaurant = $restaurantModel->find($restaurantId);
        if (!$restaurant) {
            return redirect()->to('/customer/dashboard');
        }

        $menuItems = $menuModel->getMenuItemsByRestaurant($restaurantId, ['status' => 'enabled']);

        return view('restaurant/menu', [
            'restaurant' => $restaurant,
            'menuItems' => $menuItems,
        ]);
    }
}
