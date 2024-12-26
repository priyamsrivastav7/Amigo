<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class CheckoutController extends Controller
{
    public function index()
    {
        
        $session = session();

        
        $cartData = $session->get('cart');
        $subtotal = 0;
        foreach ($cartData as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        session()->set('subtotal', $subtotal);

        
        return view('customer/checkout', ['cartData' => $cartData, 'subtotal' => $subtotal,'discount' => session('discount') ?? 0]);
    }

    public function checkout()
    {
        
        $cartData = json_decode(file_get_contents('php://input'), true);

        
        if ($cartData) {
            $session = session();
            $session->set('cart', $cartData);

            
            return $this->response->setJSON(['success' => true]);
        } else {
            
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid cart data']);
        }
    }
    public function applyCoupon()
{
    $couponCode = $this->request->getPost('coupon');
    $subtotal = session()->get('subtotal'); 

    $couponModel = new \App\Models\CouponModel();
    $coupon = $couponModel->validateCoupon($couponCode);

    if (!$coupon) {
        return redirect()->back()->with('error', 'Invalid or expired coupon code.');
    }

    $discount = 0;

    
    if ($coupon['type'] === 'percentage') {
        $discount = ($subtotal * $coupon['value']) / 100;
        if ($coupon['max_discount'] && $discount > $coupon['max_discount']) {
            $discount = $coupon['max_discount'];
        }
    } elseif ($coupon['type'] === 'flat') {
        $discount = $coupon['value'];
    }

    
    if ($discount > $subtotal) {
        $discount = $subtotal;
    }
    
    session()->set('discount', $discount);

    return redirect()->back()->with('success', 'Coupon applied successfully.');
}
public function resetDiscount()
{
    
    session()->remove('discount');    

    
}


}