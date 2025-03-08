<?php
require_once '../../config/database.php';

class ReportModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO reports
                        (report_type) 
                        VALUES (?)");
            $stmt->bindParam(1, $data['report_type']);
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
            $stmt = $connection->prepare("UPDATE reports
                            SET report_type = ?
                            WHERE report_id = ?");

            $stmt->bindParam(1, $data['report_type']);
            $stmt->bindParam(2, $data['report_id'], PDO::PARAM_INT);
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
            $stmt = $connection->prepare("UPDATE reports set is_deleted = 1 WHERE report_id = ? ");
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
