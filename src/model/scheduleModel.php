<?php
require_once '../../config/database.php';

class ScheduleModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO schedules 
                        (schedule_name, time_start, time_end) 
                        VALUES (?, ?, ?)");
            $stmt->bindParam(1, $data['schedule_name']);
            $stmt->bindParam(2, $data['time_start']);
            $stmt->bindParam(3, $data['time_end']);
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
            $stmt = $connection->prepare("UPDATE schedules 
                            SET schedule_name = ?, time_start = ?, time_end = ? 
                            WHERE schedule_id = ?");

            $stmt->bindParam(1, $data['schedule_name']);
            $stmt->bindParam(2, $data['time_start']);
            $stmt->bindParam(3, $data['time_end']);
            $stmt->bindParam(4, $data['schedule_id'], PDO::PARAM_INT);

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
            $stmt = $connection->prepare("UPDATE Schedules SET is_deleted = 1 WHERE schedule_id = ? ");
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
