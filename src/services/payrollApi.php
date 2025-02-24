<?php 
require_once '../../config/database.php';

class PayrollApi extends Database {

    public function getAll() {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT * FROM payrolls where is_deleted = 0");
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function getPayrollInfo($data){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT DISTINCT  * FROM
                    (SELECT DISTINCT employee_id,department_id,position_id,fullname,hourly_rate FROM employees) AS employees
            INNER JOIN
                    (SELECT employee_id, SUM(total_worked_minutes) AS total_minutes,COUNT(CASE WHEN attendances.attendance_status = 'Present' THEN 1 END) AS worked_days
            FROM attendances WHERE attendance_date BETWEEN :startDate AND :endDate
                GROUP BY employee_id) AS attendances
                ON employees.employee_id = attendances.employee_id
                INNER JOIN
            (SELECT employee_id AS eid,SUM(daily_wages) AS basic_salary,sum(overtime_pay) AS ot_pay FROM earnings WHERE earning_date BETWEEN :startDate AND :endDate GROUP BY employee_id) AS earnings
                ON employees.employee_id = earnings.eid
                INNER JOIN
	        (SELECT department_id,department_name FROM departments) AS departments
                ON employees.department_id = departments.department_id
                RIGHT JOIN
	        (SELECT position_id,position_name FROM positions) AS positions
                ON employees.position_id = positions.position_id
                LEFT JOIN
	        (SELECT emp_payroll_allowance_id,allowance_id,employee_id 
	        ,(SELECT sum(allowance_rate) FROM allowances WHERE is_deleted = 0 AND allowance_status = 'on') AS total_allowance
	        FROM emp_payroll_allowances WHERE payroll_id = :id) AS emp_payroll_allowances
                ON employees.employee_id = emp_payroll_allowances.employee_id
                LEFT JOIN
	        (SELECT emp_payroll_deduction_id,deduction_id,employee_id,(SELECT sum(deduction_rate) FROM deductions WHERE is_deleted = 0 AND deduction_status = 'on') AS total_deduction FROM emp_payroll_deductions WHERE payroll_id = :id) AS emp_payroll_deductions
            ON employees.employee_id = emp_payroll_deductions.employee_id
            ");
            $stmt->bindParam(':startDate', $data['startDate']);
            $stmt->bindParam(':endDate', $data['endDate']);
            $stmt->bindParam(':id', $data['id']);
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
 
        }
    }

    public function getAllowances($id){
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("SELECT 
                e.fullname,
                epd.payroll_id,
                epd.deduction_id,
                epd.employee_id,
            (SELECT d.deduction_name 
                FROM deductions d 
                WHERE d.deduction_id = epd.deduction_id) AS deduction_name,
                  (SELECT d.deduction_rate 
                FROM deductions d 
                WHERE d.deduction_id = epd.deduction_id) AS deduction_rate
            FROM 
                employees e
            LEFT JOIN 
                emp_payroll_deductions epd ON epd.employee_id = e.employee_id AND epd.payroll_id = ?
            ");
            $stmt->bindParam(1, $id);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }


    }

}
