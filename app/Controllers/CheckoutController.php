<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class CheckoutController extends Controller
{
    public function index()
    {
        // Load the session service
        $session = session();

        // Retrieve cart data from session
        $cartData = $session->get('cart');

        // Pass cart data to the view
        return view('customer/checkout', ['cartData' => $cartData]);
    }

    public function checkout()
    {
        // Read the incoming JSON data
        $cartData = json_decode(file_get_contents('php://input'), true);

        // Check if cart data is valid
        if ($cartData) {
            // Load the session service
            $session = session();

            // Store cart data in session
            $session->set('cart', $cartData);

            // Send a success response
            return $this->response->setJSON(['success' => true]);
        } else {
            // If there's an issue with cart data
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid cart data']);
        }
    }
}