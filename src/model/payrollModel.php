<?php
require_once '../../config/database.php';

class PayrollModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
    
            // Insert into payrolls
            $stmt = $connection->prepare("INSERT INTO payrolls 
                        (payroll_type, start_date, end_date, pay_date) 
                        VALUES (?, ?, ?, ?)");
            $stmt->bindParam(1, $data['payroll_type']);
            $stmt->bindParam(2, $data['start_date']);
            $stmt->bindParam(3, $data['end_date']);
            $stmt->bindParam(4, $data['pay_date']);
            $stmt->execute();
    
            // Get the last inserted ID
            $lastInsertId = $connection->lastInsertId();
    
            // Fetch allowances
            $getAllowance = $connection->prepare("SELECT allowance_id,employee_id 
                                                  FROM emp_allowances 
                                                  WHERE is_deleted = 0 
                                                  AND emp_allowance_status = 'ON'");
            $getAllowance->execute();
            $allowances = $getAllowance->fetchAll(PDO::FETCH_ASSOC);
    
            // Insert into emp_payroll_allowances for each allowance of employees
            $insertAllowances = $connection->prepare('INSERT INTO emp_payroll_allowances 
                                                      (payroll_id, employee_id, allowance_id) 
                                                      VALUES (?, ?, ?)');
    
            // Loop through each allowance and insert
            foreach ($allowances as $allowance) {
                $insertAllowances->bindParam(1, $lastInsertId);
                $insertAllowances->bindParam(2, $allowance['employee_id']);
                $insertAllowances->bindParam(3, $allowance['allowance_id']);
                $insertAllowances->execute();
            }

             // Fetch allowances
             $getDeduction= $connection->prepare("SELECT deduction_id,employee_id 
                                                FROM emp_deductions 
                                                WHERE is_deleted = 0 
                                                AND emp_deduction_status = 'ON'");
             $getDeduction->execute();
             $deductions = $getDeduction->fetchAll(PDO::FETCH_ASSOC);

            // Insert into emp_payroll_deduction for each deduction of employees
            $insertdeduction = $connection->prepare('INSERT INTO emp_payroll_deductions 
                 (payroll_id, employee_id, deduction_id) 
                 VALUES (?, ?, ?)');

            foreach ($deductions as $deduction) {
                        $insertdeduction->bindParam(1, $lastInsertId);
                        $insertdeduction->bindParam(2, $deduction['employee_id']);
                        $insertdeduction->bindParam(3, $deduction['deduction_id']);
                        $insertdeduction->execute();
            }
    
            // Commit transaction
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
            $stmt = $connection->prepare("UPDATE payrolls set is_deleted = 1 WHERE payroll_id = ? ");
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
