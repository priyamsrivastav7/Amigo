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
        $this->session = \config\Services::session();
        $this->db = \Config\Database::connect();
        $this->restaurantModel = new RestaurantModel();
        $this->favoriteModel = new FavoritesModel();
        helper('jwt_helper');
    }

    // Customer Dashboard
    public function dashboard()
    {
        // Ensure the customer is logged in
        $jwt  = $this ->session->get('token');
        $data  = $jwt ? validate_jwt($jwt) : null;
        $customer_id = $this ->session->get('customer_id');
        
        if (!$data || !isset($data->data->id) || !$customer_id || $data->data->id != $customer_id) {
        return redirect()->to('customer/login')->with('error', 'Please login to access the dashboard.');
}


        // Fetch restaurants and favorite restaurants
        $restaurantModel = new RestaurantModel();
        $restaurants = $restaurantModel->findAll();
        $favorites = $this->favoriteModel->getFavoritesByCustomer($customer_id);
        $favoriteIds = array_column($favorites, 'id');        
        // var_dump($favoriteIds);
        // die;

        return view('customer/dashboard', [
            'restaurants' => $restaurants,
            'favoriteIds' => $favoriteIds,
            'favorites' => $favorites
        ]);
    }
    

    public function toggleFavorite($restaurantId = null)
    {
        $json = $this->request->getJSON();
        $restaurantId = $json->restaurant_id;
        $customerId = session()->get('customer_id');
        
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

    // Extract restaurant IDs from the favorites data
    $favoriteIds = array_column($favorites, 'id'); // Adjust key based on database column name

    if ($this->request->isAJAX()) {
        return $this->response->setJSON(['favorites' => $favoriteIds]);
    }

    return view('favorites', ['favorites' => $favoriteIds]);
}

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
    // Validate reCAPTCHA response
    $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
    $secretKey = '6LfIOokqAAAAAH5laKejKAv9kO_QjzK2N1JIXW7N'; // Replace with your secret key
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        return redirect()->back()->with('error', 'reCAPTCHA verification failed. Please try again.');
    }

    // Retrieve user input
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    // Verify login credentials
    $model = new CustomerModel();
    $customer = $model->verifyLogin($email, $password);

    if ($customer) {
        // Prepare data for JWT
        $data = [
            'id' => $customer['id'],
            'email' => $customer['email'],
        ];

        // Generate JWT token
        $jwt = generate_jwt($data);

        // Set session variables
        $this->session->set([
            'customer_id' => $customer['id'],
            'token' => $jwt,
        ]);

        // Redirect to dashboard
        return redirect()->to('customer/dashboard');
    } else {
        // Flash error message for invalid login
        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->to('customer/login');
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