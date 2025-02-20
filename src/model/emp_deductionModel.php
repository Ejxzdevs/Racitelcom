<?php
require_once '../../config/database.php';

class Emp_deductionModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO emp_deductions 
                        (employee_id,deduction_id) 
                        VALUES (?,?)");
            $stmt->bindParam(1, $data['employee_id']);
            $stmt->bindParam(2, $data['deduction_id']);
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
            $stmt = $connection->prepare("UPDATE emp_deductions   
                            SET deduction_id = ? , emp_deduction_status = ?
                            WHERE emp_deduction_id = ? AND is_deleted = 0");
            $stmt->bindParam(1, $data['deduction_id']);
            $stmt->bindParam(2, $data['emp_deduction_status']);
            $stmt->bindParam(3, $data['emp_deduction_id'], PDO::PARAM_INT);
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
            $stmt = $connection->prepare("UPDATE emp_deductions SET is_deleted = 1 WHERE emp_deduction_id = ? ");
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
