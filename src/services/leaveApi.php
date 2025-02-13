<?php 
require_once '../../config/database.php';

class LeaveApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM leaves");
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
