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
    protected $favoriteModel;
    protected $restaurantModel;

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

        // $favoriteModel = new FavoritesModel();
        // $favorites = $favoriteModel->getFavoritesByCustomer(session()->get('customer_id'));
        $favorites = $this->favoriteModel->getFavoritesByCustomer($customerId);
        $favoriteIds = array_column($favorites, 'restaurant_id');

        return view('customer/dashboard', [
            'restaurants' => $restaurants,
            'favorites' => $favorites,
            'favoriteIds' => $favoriteIds
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

    public function toggleFavorite($restaurantId = null)
    {
        $customerId = session()->get('customer_id');
        // echo $restaurantId;
        // die;

        // Handle AJAX request
        if ($this->request->isAJAX()) {
            $result = $this->favoriteModel->toggleFavorite($customerId, $restaurantId);
            
            // Get updated favorites for response
            $favorites = $this->favoriteModel->getFavoritesByCustomer($customerId);
            
            return $this->response->setJSON([
                'status' => $result['status'],
                'favorites' => $favorites
            ]);
        }

        // Handle regular form submission
        $result = $this->favoriteModel->toggleFavorite($customerId, $restaurantId);
        $message = $result['status'] === 'added' ? 'Added to favorites.' : 'Removed from favorites.';
        
        return redirect()->back()->with('message', $message);
    }
    public function getFavorites()
    {
        $customerId = session()->get('customer_id');
        $favorites = $this->favoriteModel->getFavoritesByCustomer($customerId);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['favorites' => $favorites]);
        }
        
        return view('favorites', ['favorites' => $favorites]);
    }
// public function toggleFavorite($restaurantId = null)
// {
//     // If this is an AJAX request
//     if ($this->request->isAJAX()) {
//         // Your existing favorite toggle logic
//         $result = $this->favoriteModel->toggleFavorite(
//             session()->get('customer_id'), 
//             $restaurantId
//         );

//         // Prepare response
//         $response = [
//             'status' => $result ? 'added' : 'removed'
//         ];

//         // Optionally, if you want to update favorites section dynamically
//         if ($result) {
//             $favorites = $this->favoriteModel->getCustomerFavorites(session()->get('customer_id'));
//             $response['favorites_html'] = $this->generateFavoritesHtml($favorites);
//         }

//         return $this->response->setJSON($response);
//     }

//     // Fallback to traditional form submission if not AJAX
//     return redirect()->back();
// }

// Helper method to generate favorites HTML (optional)
private function generateFavoritesHtml($favorites)
{
    $html = '';
    foreach ($favorites as $restaurant) {
        $html .= '<li>' . 
            $restaurant['name'] . 
            ' <button class="remove-favorite" data-id="' . $restaurant['id'] . '">Remove</button>' . 
            '</li>';
    }
    return $html;
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
