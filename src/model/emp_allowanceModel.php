<?php
require_once '../../config/database.php';

class Emp_allowanceModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO emp_allowances 
                        (employee_id,allowance_id) 
                        VALUES (?,?)");
            $stmt->bindParam(1, $data['employee_id']);
            $stmt->bindParam(2, $data['allowance_id']);
            $stmt->execute();
            $connection->commit();
            return 200;
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }

    
    public function update($data) {
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("UPDATE emp_allowances   
                            SET allowance_id = ? , emp_allowance_status = ?
                            WHERE emp_allowance_id = ? AND is_deleted = 0");
            $stmt->bindParam(1, $data['allowance_id']);
            $stmt->bindParam(2, $data['emp_allowance_status']);
            $stmt->bindParam(3, $data['emp_allowance_id'], PDO::PARAM_INT);
            $stmt->execute();
            $connection->commit();
            return 200;
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            parent::closeConnection();
        }
    }
    

    public function delete($id){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("UPDATE emp_allowances SET is_deleted = 1 WHERE emp_allowance_id = ? ");
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            $stmt->execute();
            return 200;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

}
