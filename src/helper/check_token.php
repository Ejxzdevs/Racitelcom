<?php 
require __DIR__ . '/../../vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
date_default_timezone_set('Asia/Manila');
$key = $_ENV['SECRET_KEY'];

if(isset($_COOKIE['token'])) {
    // AUTHORIZED
    try {
        $token_decoded = JWT::decode($_COOKIE['token'], new Key($key, 'HS256'));
        // echo "token expiration:" . date("h:i:s a", $token_decoded->exp) . '<br>';
    } catch (Exception $e) {
         // Expire the cookie to delete it
        setcookie('token', '', time() - 3600, "/", "", true, true);
        echo '<script>alert("Your session has expired. Please login again.");</script>';
        echo '<script>setTimeout(function() { window.location.href = "../../index.php"; }, 2000);</script>';
    }
} else {
    header("Location: ../../index.php");
    exit; 
}
