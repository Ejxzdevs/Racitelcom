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
                    ON employees.employee_id = filed_leaves.employee_id  -- Join filed_leaves with employees based on employee_id
                INNER JOIN leaves 
                    ON leaves.leave_id = filed_leaves.leave_id  -- Join filed_leaves with leaves based on leave_id
                WHERE filed_leaves.is_deleted = 0;  -- Filter to only show records where is_deleted is 0 (not deleted)
            ");
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
