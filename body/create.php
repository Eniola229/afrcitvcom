<?php

// Allow cross-origin requests from any origin
header('Access-Control-Allow-Origin: *');
// Set the content type to JSON
header('Content-Type: application/json');
// Specify allowed HTTP method (POST)
header('Access-Control-Allow-Method: POST');
// Specify allowed headers
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, x-Request-With');

// Check if the request method is OPTIONS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Respond with HTTP OK status (200) for preflight requests
    http_response_code(200);
    exit;
}


include "function.php";

// Retrieve the HTTP request method
$requestMethod = $_SERVER["REQUEST_METHOD"];

// Check if the request method is POST
if ($requestMethod == "POST") {
    // Decode JSON data from the request body
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    // Check if the JSON decoding was successful
    if (empty($inputData)) {
        // Handle empty request data
        $storeNewsResponse = storeNews($_POST);
    } else {
        // Call the storeAds function with the decoded JSON data
        $storeNewsResponse = storeAds($inputData);
    }

    // Output the response
    echo $storeNewsResponse;
} else {
    // Handle unsupported HTTP methods
    $data = [
        'status' => 405,
        'message' => $requestMethod . " Method not Allowed",
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
