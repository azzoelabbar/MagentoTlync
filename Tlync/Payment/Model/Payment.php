<?php
namespace Tlync\Payment\Model;

use Magento\Payment\Model\Method\AbstractMethod;
use Magento\Payment\Model\MethodInterface;

class Payment extends AbstractMethod implements MethodInterface
{
    protected $_code = 'tlync_payment'; // Unique code for the payment method

    // Check if the payment method is available
    public function isAvailable($quote = null)
    {
        return true; // Logic to determine availability can be added here
    }

    // Initiate payment with specified parameters
    public function initiatePayment($amount, $phone, $email)
    {
        $url = 'https://c7drkx2ege.execute-api.eu-west-2.amazonaws.com/';
        $token = 'KmLbJzUoeRa4xK3XcvhsaWCk4QmuRIwOil4h8O5E'; // Replace with your actual access token

        // Prepare the data to send in the request
        $data = [
            'id' => 'zdlAmNry26YxeXg3qE0AlWdjRzMkJOZ1zb81mVaN497Ln5GyBwbroQPKD2K0g6wQ', // Replace with your actual store ID
            'amount' => $amount,
            'phone' => $phone,
            'email' => $email,
            'backend_url' => 'https://your_backend_url', // Replace with your actual backend URL
            'frontend_url' => 'https://your_frontend_url', // Replace with your actual frontend URL
            'custom_ref' => uniqid() // Generate a unique reference ID
        ];

        // Initialize cURL session
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
        curl_setopt($ch, CURLOPT_POST, true); // Set method to POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Attach data
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token // Authorization header
        ]);

        // Execute cURL session and handle response
        $response = curl_exec($ch);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            // Log the error or handle it accordingly
            error_log('cURL error: ' . curl_error($ch));
            return null; // Or handle error response
        }

        curl_close($ch); // Close cURL session
        
        // Decode and return the JSON response
        return json_decode($response, true);
    }
}
