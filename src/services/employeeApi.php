<?php 
require_once '../../config/database.php';

class EmployeeApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare(
                "SELECT * FROM employees 
                INNER JOIN departments ON employees.department_id = departments.department_id
                INNER JOIN positions ON employees.position_id = positions.position_id
                INNER JOIN schedules ON employees.schedule_id = schedules.schedule_id where employees.is_deleted = 0"
            );
            
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

    public function getAllReport($date) {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare(
                "SELECT * FROM employees 
                INNER JOIN departments ON employees.department_id = departments.department_id
                INNER JOIN positions ON employees.position_id = positions.position_id
                INNER JOIN schedules ON employees.schedule_id = schedules.schedule_id
                WHERE date_hired <= :date AND employees.is_deleted = 0"
            );
            $stmt->bindParam(":date", $date);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

}
