<?php 
require_once '../../config/database.php';

class FileLeaveApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
            SELECT * 
                FROM filed_leaves 
                INNER JOIN employees 
                    ON employees.employee_id = filed_leaves.employee_id  
                INNER JOIN leaves 
                    ON leaves.leave_id = filed_leaves.leave_id  
                WHERE filed_leaves.is_deleted = 0; 
            ");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function countCurrentLeave() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
                SELECT COUNT(*) as total_leave 
                FROM filed_leaves
                WHERE is_deleted = 0 
                AND start_date = CURRENT_DATE()
            ");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_leave'];
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return 0;
        } finally {
            parent::closeConnection();
        }
    }

}
