<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/userModel.php';
require '../../vendor/autoload.php';

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
    public function loginUser($data) {
        $dataSanitized = $this->sanitizeInput($data);
        $user = $this->model->login($dataSanitized);

        if ($user) {
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600;
            $payload = array(
                "iat" => $issuedAt,
                "exp" => $expirationTime,
                "id" => $user['id'],
                "email" => $user['user_email']
            );

            // Encode the JWT
            $jwt = JWT::encode($payload, $this->key, 'HS256');
            setcookie('token', $jwt, $expirationTime, "/", "", true, true);
            return true;
        } else {
            return false;
        }
    }

    public function registerUser($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->register($dataSanitized);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Model = new userModel();
    $schedule = new userController($Model);

    try {
        if (isset($_POST['login'])) {
            $status = $schedule->loginUser($_POST);
            echo $status === true 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=dashboard'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/login.php'</script>";
        }
        if (isset($_POST['register'])) {
            $status = $schedule->registerUser($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/register.php'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/register.php'</script>";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}