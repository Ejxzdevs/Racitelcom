<?php
require_once '../../config/database.php';

class PositionModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO positions
                        (position_name,department_id) 
                        VALUES (?,?)");
            $stmt->bindParam(1, $data['position_name']);
            $stmt->bindParam(2, $data['department_id']);
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
            $stmt = $connection->prepare("UPDATE positions
                            SET position_name = ? , department_id = ?
                            WHERE position_id = ?");

            $stmt->bindParam(1, $data['position_name']);
            $stmt->bindParam(2, $data['department_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['position_id'], PDO::PARAM_INT);

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
            $stmt = $connection->prepare("DELETE FROM positions WHERE position_id = ? ");
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
