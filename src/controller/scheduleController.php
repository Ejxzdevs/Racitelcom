<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/scheduleModel.php';

class ScheduleController extends SanitizeInput { 
    private $model;
    public function __construct(ScheduleModel $model) {
        $this->model = $model;
    }
    public function createSchedule($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->insert($dataSanitized);
    }

    public function deleteSchedule($id){
        $idSanitized = filter_var($id, FILTER_VALIDATE_INT);
        return $this->model->delete(   $idSanitized);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
        http_response_code(403);
        echo "<script>alert('Invalid CSRF token!')</script>";
        echo "<script>window.location.href='../view/main.php?route=schedule'</script>";
        exit();
    }
    CsrfHelper::regenerateToken();
    $Model = new ScheduleModel();
    $schedule = new ScheduleController($Model);

    try {
        if (isset($_POST['insert'])) {
            $status = $schedule->createSchedule($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=schedule'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/main.php?route=schedule'</script>";
        }

        if (isset($_POST['update'])) {
            
           $status = $inventoryController->updateInventory($_POST);
            echo $status === 200 
                ? "<script>alert('Inventory Update Successfully')</script><script>window.location.href='main.php?route=schedule'</script>"
                : "<script>alert('Failed to insert property')</script>";
        }

        if (isset($_POST['delete'])) {
            $status = $schedule->deleteSchedule($_POST['id']);
            echo $status === 200 
                ? "<script>alert('Data deleted Successfully')</script><script>window.location.href='../view/main.php?route=schedule'</script>"
                : "<script>alert('Data deleted failed')</script><script>window.location.href='../view/main.php?route=schedule'</script>";
            
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}