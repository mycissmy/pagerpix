<?php
require_once 'vendor/autoload.php';



use Endroid\QrCode\QrCode;
use GuzzleHttp\Client;

// Replace with your API key
$api_key = 'ak_test_pj9JRAqXesH0kSLuMbZxJ9gcDS7ish';

// PIX payment request data
$request_data = [
    'items' => [
        [
            'amount' => 2990,
            'description' => 'Chaveiro do Tesseract',
            'quantity' => 1,
        ],
    ],
    'customer' => [
        'name' => 'Kilvish Nowaste',
        'email' => 'klivish@ligadajustica.com.br',
        'type' => 'individual',
        'document' => '01234567890',
        'phones' => [
            'home_phone' => [
                'country_code' => '55',
                'number' => '22180513',
                'area_code' => '21',
            ],
        ],
    ],
    'payments' => [
        [
            'payment_method' => 'pix',
            'pix' => [
                'expires_in' => '52134613',
                'additional_information' => [
                    [
                        'name' => 'Quantidade',
                        'value' => '2',
                    ],
                ],
            ],
        ],
    ],
];

// Convert the request data to JSON
$json_data = json_encode($request_data);

// Create a QR code with the JSON data
$qrCode = new QrCode($json_data);

// Save the QR code to a file (optional)
$qrCode->writeFile('pix_qr_code.png');

// Display the QR code (optional)
header('Content-Type: ' . $qrCode->getContentType());
echo $qrCode->writeString();

// Make an HTTP request to your PIX payment API (replace with your actual API endpoint)
$client = new Client();
$response = $client->request('POST', 'https://api.pagar.me/core/v5/orders', [
    'headers' => [
        'Authorization' => 'Bearer ' . $api_key,
        'Content-Type' => 'application/json',
    ],
    'body' => $json_data,
]);

// Handle the API response as needed
$responseData = json_decode($response->getBody(), true);
print_r($responseData);

