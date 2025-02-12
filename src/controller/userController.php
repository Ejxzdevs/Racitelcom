<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/userModel.php';
require_once '../../vendor/autoload.php';

use \Firebase\JWT\JWT;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class UserController extends SanitizeInput {
    private $model;
    private $key;
    public function __construct(UserModel $model) {
        $this->model = $model;
        $this->key = $_ENV['SECRET_KEY'];
    }
    // LOG IN
    public function loginUser($data) {
        $dataSanitized = $this->sanitizeInput($data);
        $user = $this->model->login($dataSanitized);

        if ($user) {
            $_SESSION['user_type'] = $user['user_type'];

            $issuedAt = time();
            $expirationTime = $issuedAt + 3600;
            $payload = array(
                "iat" => $issuedAt,
                "exp" => $expirationTime,
                "id" => $user['id'],
                "email" => $user['user_email'],
                "user_type" => $user['user_type']
            );

            // Encode the JWT
            $jwt = JWT::encode($payload, $this->key, 'HS256');
            setcookie('token', $jwt, $expirationTime, "/", "", true, true);
            return true;
        } else {
            return false;
        }
    }

    // LOG OUT
    public function logoutUser(){
        setcookie('token', '', time() - 3600, "/", "", true, true);
        return 200;
    }

    // REGISTER
    public function registerUser($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->register($dataSanitized);
    }   
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Model = new userModel();
    $user = new userController($Model);

    try {
        if (isset($_POST['login'])) {
            $status = $user->loginUser($_POST);
            echo $status === true 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=dashboard'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/login.php'</script>";
        }
        if (isset($_POST['logout'])) {
            $status = $user->logoutUser();
            echo $status === 200 
                ? "<script>alert('Logged Out Successfully')</script><script>window.location.href='../view/login.php'</script>"
                : "<script>alert('Logged Out failed')</script>";
        }
        if (isset($_POST['register'])) {
            $status = $user->registerUser($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/register.php'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/register.php'</script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}