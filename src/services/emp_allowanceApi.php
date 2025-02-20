<?php 
require_once '../../config/database.php';

class Emp_allowanceApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM emp_allowances where is_deleted = 0");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            $connection->rollBack();
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

}
