<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

try {
    // Buat instance GuzzleHttp\Client
    $client = new Client();

    // Definisikan URL yang ingin diakses
    $url = 'http://103.176.78.115:8092/';

    // Lakukan permintaan GET ke URL
    $response = $client->get($url);

    // Dapatkan kode status HTTP dari respons
    $statusCode = $response->getStatusCode();

    // Dapatkan isi respons dalam bentuk string
    $body = $response->getBody()->getContents();

    // Tampilkan hasil
    echo "Status Code: $statusCode\n";
    echo "Response Body:\n$body\n";
} catch (GuzzleHttp\Exception\RequestException $e) {
    // Tangani kesalahan permintaan jika terjadi
    echo "Error: " . $e->getMessage() . "\n";
}