<?php
require_once '../../config/database.php';

class DeductionModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO deductions 
                        (deduction_name,deduction_rate) 
                        VALUES (?,?)");
            $stmt->bindParam(1, $data['deduction_name']);
            $stmt->bindParam(2, $data['deduction_rate']);
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
            $stmt = $connection->prepare("UPDATE deductions  
                            SET deduction_name = ? ,  deduction_rate = ? , deduction_status = ?
                            WHERE deduction_id = ?");
            $stmt->bindParam(1, $data['deduction_name']);
            $stmt->bindParam(2, $data['deduction_rate']);
            $stmt->bindParam(3, $data['deduction_status']);
            $stmt->bindParam(4, $data['deduction_id'], PDO::PARAM_INT);
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
            $stmt = $connection->prepare("UPDATE deductions SET is_deleted = 1 WHERE deduction_id = ? ");
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
