<?php 
require_once '../../config/database.php';

class PayrollApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM payrolls where is_deletd - 0");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            $connection->rollBack();
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function getPayrollInfo($data){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
                SELECT employees.employee_id, 
                    employees.fullname,
                    departments.department_name,
                    positions.position_name,
                    COUNT(CASE WHEN attendances.attendance_status = 'Present' THEN 1 END) AS worked_days,
                    SUM(attendances.total_worked_minutes) AS total_minutes,
                    employees.hourly_rate
                FROM attendances
                    INNER JOIN employees ON attendances.employee_id = employees.employee_id
                    INNER JOIN departments ON employees.department_id = departments.department_id
                    INNER JOIN positions ON employees.position_id = positions.position_id
                WHERE attendances.attendance_date BETWEEN :startDate AND :endDate
                    AND attendances.is_deleted = 0
                GROUP BY employees.employee_id, employees.fullname, departments.department_name, positions.position_name, employees.hourly_rate;
            ");
            
            $stmt->bindParam(':startDate', $data['startDate']);
            $stmt->bindParam(':endDate', $data['endDate']);
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            $connection->rollBack();
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

}
