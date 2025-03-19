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
                $status = "On time";
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
            if($minutes_worked > 480){
                $overtime = $minutes_worked - 480;
                $regular_hr = $minutes_worked - $overtime;
            }else{
                $overtime = 0; 
                $regular_hr =  $minutes_worked;
            }


            // ATTENDANCES
            $attendance = $connection->prepare("INSERT INTO attendances 
                        (employee_id,time_in_1,time_out_1,time_in_2,time_out_2,attendance_status,total_worked_minutes,attendance_date,total_late_minutes,Overtime) 
                        VALUES (?,?,?,?,?,?,?,?,?,?)");
            $attendance->bindParam(1,$data['employee_id']);
            $attendance->bindParam(2,$data['time_in_1']);
            $attendance->bindParam(3,$data['time_out_1']);
            $attendance->bindParam(4,$data['time_in_2']);
            $attendance->bindParam(5,$data['time_out_2']);
            $attendance->bindParam(6,$status);
            $attendance->bindParam(7,$regular_hr);
            $attendance->bindParam(8,$data['attendance_date']);
            $attendance->bindParam(9,$late_minutes);
            $attendance->bindParam(10,$overtime);
            $attendance->execute();

            // SELECT HOLIDAY
            $getholidays = $connection->prepare('SELECT rate,holiday_date FROM holidays where holiday_date = CURDATE() AND is_deleted = 0');
            $getholidays->execute();
            $holidays = $getholidays->fetchAll(PDO::FETCH_ASSOC);
     
            if (!empty($holidays)) {
                $holiday_rate = ($holidays[0]['rate'] / 100);
            } else {
                $holiday_rate = 1;
            }
            
            $daily_wage = $regular_hr * (($employee_schedule[0]['hourly_rate'] / 60) * $holiday_rate);
            $overtime_pay = $overtime * (($employee_schedule[0]['hourly_rate'] / 60) * 1.3 * $holiday_rate);
            $earning = $connection->prepare("INSERT INTO earnings 
            (employee_id,daily_wages,earning_date,Overtime_pay) 
            VALUES (?,?,?,?)");
            $earning->bindParam(1,$data['employee_id']);
            $earning->bindParam(2,$daily_wage);
            $earning->bindParam(3,$data['attendance_date']);
            $earning->bindParam(4,$overtime_pay);
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
            $stmt = $connection->prepare("UPDATE attendances SET is_deleted = 1 WHERE attendance_id = ? ");
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