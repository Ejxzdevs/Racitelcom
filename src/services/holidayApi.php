<?php 
require_once '../../config/database.php';

class HolidayApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM holidays WHERE is_deleted = 0");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function countIncomingHolidays() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
                SELECT COUNT(*) as holiday_count 
                FROM holidays 
                WHERE is_deleted = 0 
                AND holiday_date > CURRENT_DATE()
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['holiday_count'];
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return 0;
        } finally {
            parent::closeConnection();
        }
    }
    
    

}
