<?php 
require_once '../../config/database.php';
class AttendanceModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            // EMPLOYEES
            $connection->beginTransaction();
            $getSchedule = $connection->prepare('SELECT * FROM employees
                INNER JOIN schedules on employees.schedule_id = schedules.schedule_id
                WHERE employees.employee_id = ?
            ');
            $getSchedule->bindParam(1, $data['employee_id']);
            $getSchedule->execute();
            $employee_schedule = $getSchedule->fetchAll(PDO::FETCH_ASSOC); 

            // DECLARATIONS
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


            // ATTENDANCES
            $attendance = $connection->prepare("INSERT INTO attendances 
                        (employee_id,time_in_1,time_out_1,time_in_2,time_out_2,attendance_status,total_worked_minutes,attendance_date,total_late_minutes) 
                        VALUES (?,?,?,?,?,?,?,?,?)");
            $attendance->bindParam(1,$data['employee_id']);
            $attendance->bindParam(2,$data['time_in_1']);
            $attendance->bindParam(3,$data['time_out_1']);
            $attendance->bindParam(4,$data['time_in_2']);
            $attendance->bindParam(5,$data['time_out_2']);
            $attendance->bindParam(6,$status);
            $attendance->bindParam(7,$minutes_worked);
            $attendance->bindParam(8,$data['attendance_date']);
            $attendance->bindParam(9,$late_minutes);
            $attendance->execute();

            $daily_wage = $minutes_worked * ($employee_schedule[0]['hourly_rate'] / 60);
            $earning = $connection->prepare("INSERT INTO earnings 
            (employee_id,daily_wages,earning_date) 
            VALUES (?,?,?)");
            $earning->bindParam(1,$data['employee_id']);
            $earning->bindParam(2,$daily_wage);
            $earning->bindParam(3,$data['attendance_date']);
            $earning->execute();

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