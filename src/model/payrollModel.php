<?php
require_once '../../config/database.php';

class PayrollModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO payrolls 
                        (payroll_type,start_date,end_date,deduction_status,pay_date) 
                        VALUES (?,?,?,?,?)");
            $stmt->bindParam(1, $data['payroll_type']);
            $stmt->bindParam(2, $data['start_date']);
            $stmt->bindParam(3, $data['end_date']);
            $stmt->bindParam(4, $data['deduction_status']);
            $stmt->bindParam(5, $data['pay_date']);
            $stmt->execute();

            $getAttendance = $connection->prepare('SELECT * FROM attendances
                INNER JOIN employees on employees.employee_id = attendances.employee_id 
                WHERE attendances.attendance_date BETWEEN ? AND ?
            ');
            $stmt->bindParam(1, $data['start_date']);
            $stmt->bindParam(2, $data['end_date']);
            $getAttendance->execute();
            $employee_attendance = $getAttendance->fetchAll(PDO::FETCH_ASSOC); 
            print_r($employee_attendance);

            $connection->commit();
            // return 200;
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
            $stmt = $connection->prepare("DELETE FROM payrolls WHERE payroll_id = ? ");
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
