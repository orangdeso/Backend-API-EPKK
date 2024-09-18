<?php

// $cek = null;
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db = "tifz1761_epkk";

// $koneksi = mysqli_connect($host, $user, $pass, $db) or die("Database MYSQL Tidak Terhubung"); 

// Mengambil variabel lingkungan dari file .env
header('Content-Type: application/json');
require_once __DIR__ . '/../vendor/autoload.php'; 

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$db = $_ENV['DB_NAME'];

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $koneksi = new mysqli($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    error_log("Connection error: " . $e->getMessage());
    http_response_code(500); // Set HTTP response code untuk error
    die(json_encode([
        'status' => 'error',
        'message' => 'Database connection failed.'
    ]));
}
