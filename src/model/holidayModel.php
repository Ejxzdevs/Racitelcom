<?php
require_once '../../config/database.php';

class HolidayModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO holidays 
                        (holiday_name,holiday_date,rate) 
                        VALUES (?,?,?)");
            $stmt->bindParam(1, $data['holiday_name']);
            $stmt->bindParam(2, $data['holiday_date']);
            $stmt->bindParam(3, $data['rate']);
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
            $stmt = $connection->prepare("UPDATE holidays 
                            SET holiday_name = ?,
                                holiday_date = ?,
                                rate = ?
                            WHERE holiday_id = ?");

            $stmt->bindParam(1, $data['holiday_name']);
            $stmt->bindParam(2, $data['holiday_date']);
            $stmt->bindParam(3, $data['rate']);
            $stmt->bindParam(4, $data['holiday_id'], PDO::PARAM_INT);

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
            $stmt = $connection->prepare("DELETE FROM holidays WHERE holiday_id = ? ");
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
