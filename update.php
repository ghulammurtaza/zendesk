<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once './client.php';

// Check if the request is a POST request and the API key is present, this api key is not ZD api key
if ($_SERVER['REQUEST_METHOD'] == 'POST' 
    && isset($_SERVER['HTTP_API_KEY'])
    && isset($_POST['id'])) {
    // Extract the API key from the Authorization header
    $key = $_SERVER['HTTP_API_KEY'];

    // Check if the API key is valid
    if ($key !== $api_key) {
        // Send a 401 Unauthorized response for requests with an invalid API key
        header('WWW-Authenticate: Basic realm="API Authentication"');
        header('HTTP/1.0 401 Unauthorized');
        echo 'Invalid API key.';
        exit;
    }
    
    try {
        
        $data = [];
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                if ($field == 'body'){
                    $data['comment']['body'] = $_POST[$field];
                } else {
                    $data[$field] = $_POST[$field];
                }
            }
        }
            
        $ticket = $client->tickets()->update((int)$_POST['id'],$data);
        
        header('Content-Type: application/json');
        echo json_encode(array('success' => true, 'ticket' => $ticket));

    } catch (Exception $exception) {
        header('Content-Type: application/json');
        echo json_encode(array('success' => false, 'error' => $exception->getMessage()));
    }
    
} else {
    // Send a 401 Unauthorized response for requests without a valid API key
    header('WWW-Authenticate: Basic realm="API Authentication"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'API key required.';
}
