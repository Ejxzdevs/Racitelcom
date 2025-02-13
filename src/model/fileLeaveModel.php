<?php
require_once '../../config/database.php';

class FileLeaveModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO filed_leaves
                        (employee_id,leave_id,start_date,end_date,reason) 
                        VALUES (?,?,?,?,?)");
            $stmt->bindParam(1, $data['employee_id'],PDO::PARAM_INT);
            $stmt->bindParam(2, $data['leave_id'],PDO::PARAM_INT);
            $stmt->bindParam(3, $data['start_date']);
            $stmt->bindParam(4, $data['end_date']);
            $stmt->bindParam(5, $data['reason']);
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
            $stmt = $connection->prepare("UPDATE filed_leaves 
                                        SET employee_id = ?, leave_id = ?, start_date = ?, end_date = ?, reason = ? 
                                        WHERE file_leave_id = ?");

            $stmt->bindParam(1, $data['employee_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['leave_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['start_date']);
            $stmt->bindParam(4, $data['end_date']);
            $stmt->bindParam(5, $data['reason']);
            $stmt->bindParam(6, $data['file_leave_id'], PDO::PARAM_INT);
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
            $stmt = $connection->prepare("DELETE FROM filed_leaves WHERE file_leave_id = ? ");
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
