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
                                        SET employee_id = ?, leave_id = ?, start_date = ?, end_date = ?, reason = ? , file_status = ?
                                        WHERE file_leave_id = ?");

            $stmt->bindParam(1, $data['employee_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $data['leave_id'], PDO::PARAM_INT);
            $stmt->bindParam(3, $data['start_date']);
            $stmt->bindParam(4, $data['end_date']);
            $stmt->bindParam(5, $data['reason']);
            $stmt->bindParam(6, $data['file_status']);
            $stmt->bindParam(7, $data['file_leave_id'], PDO::PARAM_INT);
            $stmt->execute();

            if($data['file_status'] === 'approved'){
                // Retrieve the leave information
                $getLeave = $connection->prepare("SELECT * FROM leaves WHERE leave_id = ?");
                $getLeave->bindParam(1, $data['leave_id'], PDO::PARAM_INT);
                $getLeave->execute();
                $Leave = $getLeave->fetch(PDO::FETCH_ASSOC); // Use fetch instead of fetchAll for a single row
            
                $attendance = $connection->prepare("INSERT INTO attendances 
                (employee_id, time_in_1, time_out_1, time_in_2, time_out_2, attendance_status, total_worked_minutes, attendance_date, total_late_minutes, Overtime) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
                $default_int = 0;
                $default_time = '00:00:00';
            
                $startDate = new DateTime($data['start_date']);
                $endDate = new DateTime($data['end_date']);
                $endDate->modify('+1 day');
            
                while ($startDate < $endDate) {
                    $attendance_date = $startDate->format('Y-m-d');
        
                    $attendance->bindParam(1, $data['employee_id']);
                    $attendance->bindParam(2, $default_time);
                    $attendance->bindParam(3, $default_time);
                    $attendance->bindParam(4, $default_time);
                    $attendance->bindParam(5, $default_time);
                    $attendance->bindParam(6, $Leave['leave_name']);
                    $attendance->bindParam(7, $default_int, PDO::PARAM_INT);
                    $attendance->bindParam(8, $attendance_date);
                    $attendance->bindParam(9, $default_int, PDO::PARAM_INT);
                    $attendance->bindParam(10, $default_int, PDO::PARAM_INT);
                    $attendance->execute();
                    
                    $startDate->modify('+1 day');
                }
            }
            

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
            $stmt = $connection->prepare("UPDATE filed_leaves SET is_deleted = 1 WHERE file_leave_id = ? ");
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
