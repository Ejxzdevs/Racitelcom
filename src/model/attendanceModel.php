<?php 
require_once '../../config/database.php';
class AttendanceModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $getSchedule = $connection->prepare('SELECT * FROM employees
                INNER JOIN schedules on employees.schedule_id = schedules.schedule_id
                WHERE employees.employee_id = ?
            ');
            $getSchedule->bindParam(1, $data['employee_id']);
            $getSchedule->execute();
            $employee_schedule = $getSchedule->fetchAll(PDO::FETCH_ASSOC); 

            // declaration
            $schedule_start = new DateTime($employee_schedule[0]['time_start']);
            $time_in_1 = new DateTime($data['time_in_1']);
            $time_out_1 = new DateTime($data['time_out_1']);
            $time_in_2 = new DateTime($data['time_in_2']);
            $time_out_2 = new DateTime($data['time_out_2']);

            if($time_in_1 < $schedule_start){
                $status = "Present";
            }else{
                $status = "Late";
            }

            if($time_in_1 < $schedule_start){
                $late_minutes = 0 ;
            }else{
                $interval_1 = $schedule_start->diff(  $time_in_1);
                $totalHours_late = $interval_1->h + ($interval_1->i / 60);
                $late_minutes =  $totalHours_late * 60;
            }
            
            // TIME ENTRY 1
            $interval_1 = $time_in_1->diff( $time_out_1);
            $totalHours_1 = $interval_1->h + ($interval_1->i / 60);
            $totalMinutes_1 = $totalHours_1 * 60;
            // TIME ENTRY 2
            $interval_2 = $time_in_2->diff( $time_out_2);
            $totalHours_2 = $interval_2->h + ($interval_2->i / 60);
            $totalMinutes_2 = $totalHours_2 * 60;
            // TOTAL MINUTES 
            $minutes_worked = $totalMinutes_1 + $totalMinutes_2;


            $stmt = $connection->prepare("INSERT INTO attendances 
                        (employee_id,time_in_1,time_out_1,time_in_2,time_out_2,attendance_status,total_worked_minutes,attendance_date,total_late_minutes) 
                        VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1,$data['employee_id']);
            $stmt->bindParam(2,$data['time_in_1']);
            $stmt->bindParam(3,$data['time_out_1']);
            $stmt->bindParam(4,$data['time_in_2']);
            $stmt->bindParam(5,$data['time_out_2']);
            $stmt->bindParam(6,$status);
            $stmt->bindParam(7,$minutes_worked);
            $stmt->bindParam(8,$data['attendance_date']);
            $stmt->bindParam(9,$late_minutes);
            $stmt->execute();
            $connection->commit();
            return 200;
        } catch (PDOException $e) {
            $connection->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        } finally {
            // parent::closeConnection();
        }
    }    

    public function delete($id){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("DELETE FROM attendances WHERE attendance_id = ? ");
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