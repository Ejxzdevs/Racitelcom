<?php 
require_once '../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '../../');
$dotenv->load();
class Database {
    private $host,$username,$password,$dbname;
    protected $conn;
    public function __construct() {
        $this->host = $_ENV['DB_HOST'];
        $this->username = $_ENV['DB_USER']; 
        $this->password = $_ENV['DB_PASS']; 
        $this->dbname = $_ENV['DB_NAME']; 
        try {
            $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create the database if it doesn't exist
            $create_database = "CREATE DATABASE IF NOT EXISTS $this->dbname";
            $this->conn->exec($create_database);
            $this->conn->exec("USE $this->dbname");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    // OPEN CONNECTION
    protected function OpenConnection() {
        return $this->conn;
    }
    // CLOSE CONNECTION
    protected function CloseConnection() {
        echo '<script>console.log("connection close");</script>';
        $this->conn = null;
    }
}
