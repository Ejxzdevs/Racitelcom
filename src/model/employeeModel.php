<?php
require_once '../../config/database.php';

class EmployeeModel extends Database {

    public function insert($data){
        $connection = parent::openConnection();
        try {
            $connection->beginTransaction();
            $stmt = $connection->prepare("INSERT INTO employees 
                        (fullname,email,contact_number,address,gender,department_id,position_id,hourly_rate,schedule_id) 
                        VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->bindParam(1, $data['fullname']);
            $stmt->bindParam(2, $data['email']);
            $stmt->bindParam(3, $data['number']);
            $stmt->bindParam(4, $data['address']);
            $stmt->bindParam(5, $data['gender']);
            $stmt->bindParam(6, $data['department_id']);
            $stmt->bindParam(7, $data['position_id']);
            $stmt->bindParam(8, $data['salary']);
            $stmt->bindParam(9, $data['schedule_id']);
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
            $stmt = $connection->prepare(
            "UPDATE employees SET 
            fullname = ?, 
            email = ?, 
            contact_number = ?, 
            address = ?, 
            gender = ?, 
            department_id = ?, 
            position_id = ?, 
            hourly_rate = ?, 
            schedule_id = ? 
            WHERE employee_id = ?"
        );
        
        $stmt->bindValue(1, $data['fullname']);
        $stmt->bindValue(2, $data['email']);
        $stmt->bindValue(3, $data['number']);
        $stmt->bindValue(4, $data['address']);
        $stmt->bindValue(5, $data['gender']);
        $stmt->bindValue(6, $data['department_id']);
        $stmt->bindValue(7, $data['position_id']);
        $stmt->bindValue(8, $data['salary']);
        $stmt->bindValue(9, $data['schedule_id']);
        $stmt->bindParam(10, $data['employee_id'], PDO::PARAM_INT);

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
            $stmt = $connection->prepare("DELETE FROM employees WHERE employee_id = ? ");
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
