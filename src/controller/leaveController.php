<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/leaveModel.php';

class LeaveController extends SanitizeInput { 
    private $model;
    public function __construct(LeaveModel $model) {
        $this->model = $model;
    }
    public function create($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->insert($dataSanitized);
    }

    public function update($data){
        $dataSanitized = $this->sanitizeInput($data);
        return $this->model->update($dataSanitized);
    }

    public function delete($id){
        $idSanitized = filter_var($id, FILTER_VALIDATE_INT);
        return $this->model->delete(   $idSanitized);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['csrf_token']) || !CsrfHelper::validateToken($_POST['csrf_token'])) {
        http_response_code(403);
        echo "<script>alert('Invalid CSRF token!')</script>";
        echo "<script>window.location.href='../view/main.php?route=leave'</script>";
        exit();
    }
    CsrfHelper::regenerateToken();
    $Model = new LeaveModel();
    $leave = new LeaveController($Model);

    try {
        if (isset($_POST['insert'])) {
            $status = $leave->create($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=leave'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/main.php?route=leave'</script>";
        }

        if (isset($_POST['update'])) {
            
           $status = $leave->update($_POST);
           echo $status === 200 
           ? "<script>alert('Data Updated Successfully')</script><script>window.location.href='../view/main.php?route=leave'</script>"
           : "<script>alert('Data updating failed')</script><script>window.location.href='../view/main.php?route=leave'</script>";
        }

        if (isset($_POST['delete'])) {
            $status = $leave->delete($_POST['id']);
            echo $status === 200 
                ? "<script>alert('Data deleted Successfully')</script><script>window.location.href='../view/main.php?route=leave'</script>"
                : "<script>alert('Data deleted failed')</script><script>window.location.href='../view/main.php?route=leave'</script>";
            
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}