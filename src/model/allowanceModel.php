<?php
require_once '../../config/database.php';

class AllowanceModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO allowances 
                        (allowance_name,allowance_rate) 
                        VALUES (?,?)");
            $stmt->bindParam(1, $data['allowance_name']);
            $stmt->bindParam(2, $data['allowance_rate']);
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
            $stmt = $connection->prepare("UPDATE allowances  
                            SET allowance_name = ? ,  allowance_rate = ? , allowance_status = ?
                            WHERE allowance_id = ?");
            $stmt->bindParam(1, $data['allowance_name']);
            $stmt->bindParam(2, $data['allowance_rate']);
            $stmt->bindParam(3, $data['allowance_status']);
            $stmt->bindParam(4, $data['allowance_id'], PDO::PARAM_INT);
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
            $stmt = $connection->prepare("DELETE FROM allowances WHERE allowance_id = ? ");
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
