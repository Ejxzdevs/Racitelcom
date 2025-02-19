<?php
require_once '../../vendor/autoload.php';
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/attendanceModel.php';

class Process_attendance extends SanitizeInput { 
    private $model;

    public function __construct(AttendanceModel $model) {
        $this->model = $model;
    }

    public function create($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->insert($dataSanitized);
    }
}

use PhpOffice\PhpSpreadsheet\IOFactory;

function formatTime($timeString) {
    // Check if the time is a valid time string (e.g., "13:15:00")
    if (strtotime($timeString) === false) {
        return "Invalid Time: " . $timeString;
    }
    // Convert the time string into a formatted time string
    return date("H:i:s", strtotime($timeString));
}

// Helper function to format the date
function formatDate($excelDate) {
    // Check if the date is numeric
    if (!is_numeric($excelDate)) {
        return "Invalid Date"; 
    }
    // Excel date format starts at 1900-01-01, so we use the PHP DateTime class to format it
    $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelDate);
    return $date->format('Y-m-d H:i:s'); 
}

if (isset($_POST['submit']) && isset($_FILES['attendance_file']) && $_FILES['attendance_file']['error'] == 0) {
    if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
        http_response_code(403);
        echo "<script>alert('Invalid CSRF token!')</script>";
        echo "<script>window.location.href='../view/main.php?route=attendance'</script>";
        exit();
    }
    CsrfHelper::regenerateToken();
    $Model = new AttendanceModel();
    $attendance = new Process_attendance($Model);

    $fileTmpName = $_FILES['attendance_file']['tmp_name'];
    $fileName = $_FILES['attendance_file']['name'];
    $fileType = $_FILES['attendance_file']['type'];
    $fileSize = $_FILES['attendance_file']['size'];

    // Check if the file is an Excel file
    $allowedTypes = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel'];
    if (!in_array($fileType, $allowedTypes)) {
        die('Please upload a valid Excel file.');
    }

    // Load the Excel file
    try {
        $spreadsheet = IOFactory::load($fileTmpName);
        $sheet = $spreadsheet->getActiveSheet();

        // Iterate through the rows of the spreadsheet
        foreach ($sheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(FALSE);

            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue(); // Collect cell values
            }

            // Skip the header row by checking the row index (Start from row 2 onwards)
            if ($row->getRowIndex() >= 2) {
                $employee_id = $rowData[0];
                $time_in_1 = formatTime($rowData[1]);
                $time_out_1 = formatTime($rowData[2]);
                $time_in_2 = formatTime($rowData[3]);
                $time_out_2 = formatTime($rowData[4]);
                $attendance_date = formatDate($rowData[5]);

                $data = [
                    'employee_id' => $employee_id,
                    'time_in_1' => $time_in_1,
                    'time_out_1' => $time_out_1,
                    'time_in_2' => $time_in_2,
                    'time_out_2' => $time_out_2,
                    'attendance_date' => $attendance_date
                ];

                $status = $attendance->create($data);
                echo $status === 200 
                    ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=attendance'</script>"
                    : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/main.php?route=attendance'</script>";
            }
        }

    } catch (Exception $e) {
        die('Error loading the file: ' . $e->getMessage());
    }
} else {
    echo "No file uploaded or there was an error with the upload.";
}
