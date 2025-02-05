<?php 

class Database {
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'payroll';
    protected $conn;
    public function __construct() {
    
        try {
            $this->conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Create the database if it doesn't exist
            $create_database = "CREATE DATABASE IF NOT EXISTS $this->dbname";
            $this->conn->exec($create_database);

            // Select the database for future operations
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
