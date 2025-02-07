<?php
require_once '../helper/csrf.php';
require_once '../helper/sanitizeInput.php';
require_once '../model/departmentModel.php';

class DepartmentController extends SanitizeInput { 
    private $model;
    public function __construct(DepartmentModel $model) {
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
        echo "<script>window.location.href='../view/main.php?route=department'</script>";
        exit();
    }
    CsrfHelper::regenerateToken();
    $Model = new DepartmentModel();
    $department = new DepartmentController($Model);

    try {
        if (isset($_POST['insert'])) {
            $status = $department->create($_POST);
            echo $status === 200 
                ? "<script>alert('Data Added Successfully')</script><script>window.location.href='../view/main.php?route=department'</script>"
                : "<script>alert('Data insertion failed')</script><script>window.location.href='../view/main.php?route=department'</script>";
        }

        if (isset($_POST['update'])) {
            
           $status = $department->update($_POST);
           echo $status === 200 
           ? "<script>alert('Data Updated Successfully')</script><script>window.location.href='../view/main.php?route=department'</script>"
           : "<script>alert('Data updating failed')</script><script>window.location.href='../view/main.php?route=department'</script>";
        }

        if (isset($_POST['delete'])) {
            $status = $department->delete($_POST['id']);
            echo $status === 200 
                ? "<script>alert('Data deleted Successfully')</script><script>window.location.href='../view/main.php?route=department'</script>"
                : "<script>alert('Data deleted failed')</script><script>window.location.href='../view/main.php?route=department'</script>";
            
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }

}