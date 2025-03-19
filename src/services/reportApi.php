<?php 
require_once '../../config/database.php';

class ReportApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM reports where is_deleted = 0");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function getReportsForCurrentMonth() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
                SELECT * FROM reports 
                    WHERE is_deleted = 0 
                    AND created_at BETWEEN DATE_FORMAT(CURRENT_DATE, '%Y-%m-01') 
                    AND CONCAT(CURRENT_DATE, ' 23:59:59')
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        } finally {
            parent::closeConnection();  
        }
    }

}
