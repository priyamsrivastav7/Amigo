<?php

namespace App\Controllers;

use App\Models\RestaurantModel;
use App\Models\MenuModel;
use CodeIgniter\Controller;

class RestaurantController extends Controller
{
    
    public function login()
    {
        if (session()->get('restaurant_id')) {
            return redirect()->to('/restaurant/dashboard');
        }
        return view('restaurant/login');
    }

    
    public function loginSubmit()
{
    $recaptchaResponse = $this->request->getPost('g-recaptcha-response');
    $secretKey = '6LfBAqcqAAAAAEoxjKdYtvYjmGx9xCuWvQ3O5WG2'; // Replace with your secret key
    $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
    $responseData = json_decode($verifyResponse);

    if (!$responseData->success) {
        return redirect()->back()->with('error', 'reCAPTCHA verification failed. Please try again.');
    }
    


    
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    
    $validation = \Config\Services::validation();
    $validation->setRules([
        'email' => 'required|valid_email',
        'password' => 'required|min_length[6]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('error', $validation->listErrors());
    }

   
    $model = new RestaurantModel();

    
    $restaurant = $model->verifyLogin($email, $password);

    if ($restaurant) {
        
        session()->set('restaurant_id', $restaurant['id']);
        session()->set('restaurant_name', $restaurant['name']);
        // $a = session()->get('restaurant_id');
        // var_dump($a);
        // exit;


        return redirect()->to('/restaurant/dashboard'); 
    } else {
        session()->setFlashdata('error', 'Invalid email or password.');
        return redirect()->to('/restaurant/login');
    }
}


    public function register()
    {
        return view('restaurant/register');
    }

    
    public function registerSubmit()
{
    
    $name = $this->request->getPost('name');
    $email = $this->request->getPost('email');
    $phone_number = $this->request->getPost('phone_number');
    $address = $this->request->getPost('address');
    $password = $this->request->getPost('password');
    $latitude = $this->request->getPost('latitude');
    $longitude = $this->request->getPost('longitude');

    
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

    
    $imageFile = $this->request->getFile('image');
    if ($imageFile->isValid() && !$imageFile->hasMoved()) {
        
        $imageName = $imageFile->getRandomName();
        
        
        $imageFile->move(WRITEPATH . '../public/restaurant', $imageName);
        
        
        $imagePath = 'restaurant/' . $imageName;
    } else {
        
        $imagePath = null;
    }

    
    $model = new RestaurantModel();

    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $data = [
        'name' => $name,
        'email' => $email,
        'phone_number' => $phone_number,
        'password' => $hashedPassword,
        'address' => $address,
        'image' => $imagePath, 
        'latitude' => $latitude,
        'longitude' => $longitude, 
    ];

    
    if ($model->save($data)) {
        return redirect()->to('/restaurant/login')->with('success', 'Registration successful! Please login.');
    } else {
        return redirect()->back()->withInput()->with('error', 'Registration failed. Please try again.');
    }
}
public function RestaurantMenu($restaurantId)
{    
    $restaurantModel = new RestaurantModel();
    $menuModel = new MenuModel();

   
    $restaurant = $restaurantModel->find($restaurantId);

    
    if (!$restaurant) {
        return redirect()->to('/customer/dashboard')->with('error', 'Restaurant not found.');
    }

    
    $menu = $menuModel->where('restaurant_id', $restaurantId)->findAll();

    
    return view('restaurant/menu', ['restaurant' => $restaurant, 'menu' => $menu]);
}
public function logout()
    {
        
        session()->destroy();

        
        return redirect()->to('/restaurant/login')->with('success', 'You have been logged out successfully.');
    }

    public function updateStatus()
    {
        $status = $this->request->getPost('status');
        $restaurantId = session()->get('restaurant_id');
        //  var_dump($status);
        //  die;
        //  var_dump($restaurantId);
        //  die;
        $restaurantModel = new RestaurantModel;

        if ($restaurantModel->update($restaurantId, ['status' => $status]));

        
        {
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['success' => false]);
    }

public function viewMenu()
{
    $menuModel = new \App\Models\MenuModel(); // Adjust to your actual model path and name
    $data['menu_items'] = $menuModel->findAll(); // Fetch all menu items
    return view('restaurant/menu', $data); // Load the menu page view with data
}

}

