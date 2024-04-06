<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

use GuzzleHttp\Client;

$client = new Client();

$response = $client->request('GET', 'https://api.techspecs.io/api/v1/products', [
    'headers' => [
        'Authorization' => 'Bearer ' . API_KEY,
        'Accept' => 'application/json',
    ],
]);

$data = json_decode($response->getBody(), true);

// Process and store the data in your MySQL database
// ...
?>