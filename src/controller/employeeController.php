<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/employeeModel.php';

class EmployeeController extends SanitizeInput { 
    private $model;
    public function __construct(EmployeeModel $model) {
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
        echo "<script>window.location.href='../view/main.php?route=employee'</script>";
        exit();
    }
    CsrfHelper::regenerateToken();
    $Model = new EmployeeModel();
    $employee = new EmployeeController($Model);

    try {
        if (isset($_POST['insert'])) {
            $status = $employee->create($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=employee'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/main.php?route=employee'</script>";
        }

        if (isset($_POST['update'])) {
            
           $status = $employee->update($_POST);
           echo $status === 200 
           ? "<script>alert('Data Updated Successfully')</script><script>window.location.href='../view/main.php?route=employee'</script>"
           : "<script>alert('Data updating failed')</script><script>window.location.href='../view/main.php?route=employee'</script>";
        }

        if (isset($_POST['delete'])) {
            $status = $employee->delete($_POST['id']);
            echo $status === 200 
                ? "<script>alert('Data deleted Successfully')</script><script>window.location.href='../view/main.php?route=employee'</script>"
                : "<script>alert('Data deleted failed')</script><script>window.location.href='../view/main.php?route=employee'</script>";
            
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}