<?php

namespace BacByTouch;

use Exception;
use InvalidArgumentException;

class BaseApiClient
{
    protected $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function callApi($url, $method = "GET", $headers = [], $data = [])
    {
        // Check if method is valid
        if (!in_array($method, ["GET", "POST", "PUT", "DELETE"])) {
            throw new InvalidArgumentException("Invalid HTTP method: $method");
        }

        $ch = curl_init();

        // Set the URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Set the request method
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Set the API key in the headers
        $headers[] = 'Authorization: Bearer ' . $this->apiKey;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Set the request data if provided
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        // Set options to return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if ($response === false) {
            throw new Exception('Error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        return $response;
    }
}
