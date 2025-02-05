<?php
require_once '../../config/database.php';

class ScheduleModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO schedules (schedule_name, time_start, time_end) 
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

}
