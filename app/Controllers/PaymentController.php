<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class PaymentController extends Controller
{
    public function initiatePayment()
    {
        $amount = $this->request->getPost('total');
        $orderId = 'ORDER_' . time(); // Unique order ID
        $customerName = 'Test User';  // Replace with logged-in customer name
        $customerEmail = 'test@example.com'; // Replace with real data
        $customerPhone = '9999999999'; // Replace with real data

        $orderPayload = [
            "order_id" => $orderId,
            "order_amount" => $amount,
            "order_currency" => "INR",
            "customer_details" => [
                "customer_id" => "cust_" . time(),
                "customer_email" => $customerEmail,
                "customer_phone" => $customerPhone,
                "customer_name" => $customerName,
            ],
            "order_meta" => [
                "return_url" => site_url('payment-response') . "?order_id={order_id}"
            ]
        ];

        // Create Cashfree session
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($orderPayload),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "x-client-id: " . getenv('CASHFREE_CLIENT_ID'),
                "x-client-secret: " . getenv('CASHFREE_CLIENT_SECRET'),
                "x-api-version: 2022-09-01"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return $this->response->setJSON(['error' => $err]);
        }

        $resData = json_decode($response, true);

        if (isset($resData['payment_session_id'])) {
            return view('customer/payment_ui', [
                'session_id' => $resData['payment_session_id'],
                'order_id' => $orderId
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to generate payment session.',
                'details' => $resData
            ]);
        }
    }

    public function paymentResponse()
{
    $orderId = $this->request->getGet('order_id');

    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://sandbox.cashfree.com/pg/orders/$orderId",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "x-client-id: " . getenv('CASHFREE_CLIENT_ID'),
            "x-client-secret: " . getenv('CASHFREE_CLIENT_SECRET'),
            "x-api-version: 2022-09-01"
        ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return "Error: $err";
    }

    $paymentDetails = json_decode($response, true);

    // Save to database
    $paymentModel = new \App\Models\PaymentModel();
    $paymentModel->save([
        'order_id' => $paymentDetails['order_id'],
        'cf_order_id' => $paymentDetails['cf_order_id'],
        'payment_session_id' => $paymentDetails['payment_session_id'] ?? null,
        'order_amount' => $paymentDetails['order_amount'],
        'currency' => $paymentDetails['order_currency'],
        'status' => $paymentDetails['order_status'],
        'payment_info' => json_encode($paymentDetails)
    ]);

    // Render success/failure message
    return view('customer/payment_success', [
        'status' => $paymentDetails['order_status'],
        'order_id' => $paymentDetails['order_id']
    ]);
}

}
