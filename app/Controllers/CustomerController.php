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
        
        $this->session = \config\Services::session();
        $this->db = \Config\Database::connect();
        $this->restaurantModel = new RestaurantModel();
        $this->favoriteModel = new FavoritesModel();
        helper('jwt_helper');
    }

    public function dashboard()
{
    // Retrieve JWT token and validate
    $jwt = $this->session->get('token');
    $data = $jwt ? validate_jwt($jwt) : null;

    // Get the customer ID from the session
    $customer_id = $this->session->get('customer_id');

    // Validate customer session and JWT data
    if (!$customer_id ) {
        return redirect()->to('customer/login')->with('error', 'Please login to access the dashboard.');
    }
    $restaurantModel = new RestaurantModel();
    $restaurants = $restaurantModel->findAll();

    $favorites = $this->favoriteModel->getFavoritesByCustomer($customer_id);
    $favoriteIds = array_column($favorites, 'id');

    // Return the dashboard view with all necessary data
    return view('customer/dashboard', [
        'restaurants' => $restaurants,
        'favoriteIds' => $favoriteIds,
        'favorites' => $favorites,
    ]);
}

    

    public function toggleFavorite($restaurantId = null)
    {
        $json = $this->request->getJSON();
        $restaurantId = $json->restaurant_id;
        $customerId = session()->get('customer_id');
        
        if ($this->request->isAJAX()) {
            $result = $this->favoriteModel->toggleFavorite($customerId, $restaurantId);
            
            
            $favorites = $this->favoriteModel->getFavoritesByCustomer($customerId);
            
            return $this->response->setJSON([
                'status' => $result['status'],
                'favorites' => $favorites
            ]);
        }

        
        $result = $this->favoriteModel->toggleFavorite($customerId, $restaurantId);
        $message = $result['status'] === 'added' ? 'Added to favorites.' : 'Removed from favorites.';
        
        return redirect()->back()->with('message', $message);
    }
    public function getFavorites()
{
    $customerId = session()->get('customer_id');
    $favorites = $this->favoriteModel->getFavoritesByCustomer($customerId);

    
    $favoriteIds = array_column($favorites, 'id'); 

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

    
    public function login()
    {
        $session = session();
        if ($session->get('customer_id')) {
            return redirect()->to('customer/dashboard');
        }
        return view('customer/login');
    }

    
    public function loginUser()
{
    
    $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
    $secretKey = '6LfIOokqAAAAAH5laKejKAv9kO_QjzK2N1JIXW7N'; // Replace with your secret key
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        return redirect()->back()->with('error', 'reCAPTCHA verification failed. Please try again.');
    }

    
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    
    $model = new CustomerModel();
    $customer = $model->verifyLogin($email, $password);

    if ($customer) {
        
        $data = [
            'id' => $customer['id'],
            'email' => $customer['email'],
        ];

        
        $jwt = generate_jwt($data);

        
        $this->session->set([
            'customer_id' => $customer['id'],
            'token' => $jwt,
        ]);

        
        return redirect()->to('customer/dashboard');
    } else {
        
        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->to('customer/login');
    }
}


   
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
            'password' => md5($this->request->getPost('password')), 
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

   
    public function logout()
    {
        session()->destroy();
        return redirect()->to('customer/login');
    }

    
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
    public function editProfile()
    {
        $session = session();
        $customerId = $session->get('customer_id'); // Assuming customer_id is stored in the session

        if (!$customerId) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        $model = new CustomerModel();
        $customer = $model->find($customerId);

        return view('customer/edit_profile', ['customer' => $customer]);
    }

    public function updateProfile()
    {
        $session = session();
        $customerId = $session->get('customer_id');

        if (!$customerId) {
            return redirect()->to('/login');
        }

        $model = new CustomerModel();
        $data = $this->request->getPost();

        // Validate input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required',
            'email' => 'required|valid_email',
            'phone_number' => 'required|min_length[10]|max_length[15]',
            'password' => 'permit_empty|min_length[6]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->with('errors', $validation->getErrors())->withInput();
        }

        // Hash password only if it's being updated
        if (!empty($data['password'])) {
            $data['password'] = md5($data['password']);
        } else {
            unset($data['password']);
        }

        $model->update($customerId, $data);

        $session->setFlashdata('success', 'Profile updated successfully!');
        return redirect()->to('/customer/editprofile');
    }
    


}