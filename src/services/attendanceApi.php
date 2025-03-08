<?php
require_once '../../config/database.php';

class AttendanceApi extends Database {
    public function getAll() {
        $connection = parent::openConnection();
        try {
            $currentDate = date('Y-m-d');
            $stmt = $connection->prepare("
            		SELECT * 
                        FROM attendances 
                        INNER JOIN employees ON attendances.employee_id = employees.employee_id
                        WHERE attendances.is_deleted = 0 AND attendances.attendance_date = :current_date");
            $stmt->bindParam(':current_date', $currentDate, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            parent::closeConnection();  
        }
    }

    public function getFilteredAttendance($data) {
        $connection = parent::openConnection();
        try {
            $stmt = $connection->prepare("
                SELECT * 
                FROM attendances 
                INNER JOIN employees ON attendances.employee_id = employees.employee_id
                WHERE attendances.attendance_date BETWEEN :startDate AND :endDate 
                AND attendances.is_deleted = 0;");
            
            $stmt->bindParam(':startDate', $data['startDate']);
            $stmt->bindParam(':endDate', $data['endDate']);
            
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
        } finally {
            // parent::closeConnection();  
        }
    }
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle the filter request and redirect
if (isset($_POST['filter'])) {
    $attendance = new AttendanceApi();
    $filter_attendance = $attendance->getFilteredAttendance($_POST);
    $no_filter_attendance = $attendance->getAll();

    $filters = [
        'start_date' => $_POST['startDate'],
        'end_date' => $_POST['endDate'],
    ];

    $_SESSION['filters'] = $filters;

    // Check if startDate or endDate is null or empty
    if (empty($_POST['startDate']) && empty($_POST['endDate'])) {
        // If no date filter is provided, use the "no filter" attendance
        $_SESSION['attendance'] = $no_filter_attendance;
    } else {
        // If date filter is provided, use the filtered attendance
        $_SESSION['attendance'] = $filter_attendance;
    }
}

