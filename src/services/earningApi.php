<?php 
require_once '../../config/database.php';

class EarningApi extends Database {
    
    public function getPayrollDataPerMonth() {
        $connection = $this->openConnection();
        
        try {
            $stmt = $connection->prepare("
                WITH months AS (
                    SELECT DATE_FORMAT(DATE_ADD(DATE_FORMAT(NOW(), '%Y-01-01'), INTERVAL n MONTH), '%Y-%m') AS month
                    FROM (
                        SELECT 0 AS n UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3 
                        UNION ALL SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL SELECT 7 
                        UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL SELECT 10 UNION ALL SELECT 11
                    ) AS numbers
                )
                SELECT 
                    m.month, 
                    COALESCE(SUM(e.daily_wages + e.Overtime_pay), 0) AS total_payroll
                FROM months m
                LEFT JOIN earnings e ON DATE_FORMAT(e.earning_date, '%Y-%m') = m.month
                GROUP BY m.month
                ORDER BY m.month;
            ");

            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC); 

            return $data;
        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());
            return [];
        } finally {
            $this->closeConnection();
        }
    }
}
