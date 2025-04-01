<?php 
require_once '../services/employeeApi.php';
require_once '../services/positionApi.php';
require_once '../services/departmentApi.php';
require_once '../services/scheduleApi.php';
require_once '../helper/csrf.php';

$csrf_token = CsrfHelper::generateToken();
$getData = new EmployeeApi();
$data = $getData->getAll();
$getDepartment = new departmentApi();
$dataDepartment = $getDepartment->getAll();
$getPosition = new positionApi();
$dataPosition = $getPosition->getAll();
$getSchedule = new scheduleApi();
$dataSchedule = $getSchedule->getAll();
?>
<div class="container flex flex-col gap-2 text-[14px]"  style="padding: 0 2rem;">
    <div class="h-[4rem] flex items-center justify-between ">
        <label class="text-gray-800 text-[1.3rem] font-bold">
            Employee List
        </label>
        <button id="openModal" class="py-[5px] px-2 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
            <i class="fas fa-plus fa"></i>
            Employee
        </button>
    </div>
    <div class="overflow-x-auto" >
      <table class="w-full table-fixed rounded-lg bg-white shadow-md overflow-hidden" >
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="py-2 text-center">Id</th>
            <th class="py-2 text-center">Name</th>
            <th class="py-2 text-center">Department</th>
            <th class="py-2 text-center">Date Hired</th>
            <th class="py-2 text-center">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['employee_id']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['fullname']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['department_name']); ?></td>
            <td class="py-2 text-center">
                <?php echo htmlspecialchars(date('M d Y ', strtotime($display['date_hired']))); ?>
            </td>
            <td class="py-2 flex flex-row justify-center gap-4">
              <form action="../controller/EmployeeController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['employee_id'] );?>" hidden>
                <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              <a href="javascript:void(0);" class="edit-link text-blue-500 hover:text-blue-700 cursor-pointer" data='<?php echo htmlspecialchars(json_encode($display), ENT_QUOTES, 'UTF-8'); ?>'>
                <i class="fas fa-edit"></i>
              </a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
</div>
<!-- POP UP SECTION-->

<!-- ADD FORM -->
<div id="modal" class="fixed inset-0 bg-opacity-50 flex justify-center items-center hidden" style="background-color: rgba(0, 0, 0, 0.5);">
  <div class="bg-white p-6 rounded-lg w-96 max-h-[80vh] overflow-y-auto">
    <h2 class="text-[20px] mb-4">Create Employee</h2>
    <form id="addForm" action="../controller/EmployeeController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
        <label for="Employee_name" class="block text-sm font-medium text-gray-700">Employee Name</label>
        <input type="text" id="Employee_name" name="fullname" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Employee Name:" required>
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Email:" required>
      </div>
      <div class="mb-4">
        <label for="number" class="block text-sm font-medium text-gray-700">Number</label>
        <input type="text" id="number" name="number" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Number:" required>
      </div>
      <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" id="address" name="address" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Address:" required>
      </div>
      <div class="mb-4">
        <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
        <select id="gender" name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Gender</option>
          <option value="Male">Male</option>
          <option value="Male">Female</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
        <select id="department_id" name="department_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Department</option>
          <?php foreach($dataDepartment as $data): ?>
            <option value="<?php echo $data['department_id'] ?>"><?php echo $data['department_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="position_id" class="block text-sm font-medium text-gray-700">Positon</label>
        <select id="position_id" name="position_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Position</option>
          <?php foreach($dataPosition as $data): ?>
            <option value="<?php echo $data['position_id'] ?>"><?php echo $data['position_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="salary" class="block text-sm font-medium text-gray-700">Salary Rate per hour</label>
        <input type="text" id="salary" name="salary" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Salary:" required>
      </div>
      <div class="mb-4">
        <label for="schedule_id" class="block text-sm font-medium text-gray-700">Schedule</label>
        <select id="schedule_id" name="schedule_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Schedule</option>
          <?php foreach($dataSchedule as $data): ?>
            <option value="<?php echo $data['schedule_id'] ?>"><?php echo $data['schedule_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <!-- Submit Button -->
      <div class="flex justify-between items-center">
        <button type="submit" class="py-[5px] px-4 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
          Submit
        </button>
        <button type="button" id="closeModal" class="py-[5px] px-4 border-1 border-gray-300 text-red-500 hover:text-red-700 cursor-pointer shadow-md rounded-sm">
          Close
        </button>
      </div>
    </form>
  </div>
</div>


<!-- EDIT -->
<div id="editmodal" class="fixed inset-0 bg-opacity-50 flex justify-center items-center hidden" style="background-color: rgba(0, 0, 0, 0.5);">
  <div class="bg-white p-6 rounded-lg w-96 max-h-[80vh] overflow-y-auto">
    <h2 class="text-[20px] mb-4">Update Employee</h2>
    <form id="editForm" action="../controller/EmployeeController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="update">
        <input type="hidden" id="id" name="employee_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Schedule Id:" required>
        <label for="edit_employee_name" class="block text-sm font-medium text-gray-700">Employee Name</label>
        <input type="text" id="edit_employee_name" name="fullname" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Schedule Name:" required>
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="edit_email" name="email" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Email:" required>
      </div>
      <div class="mb-4">
        <label for="edit_number" class="block text-sm font-medium text-gray-700">Number</label>
        <input type="text" id="edit_number" name="number" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Number:" required>
      </div>
      <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="text" id="edit_address" name="address" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Address:" required>
      </div>
      <div class="mb-4">
        <label for="edit_gender" class="block text-sm font-medium text-gray-700">Gender</label>
        <select id="edit_gender" name="gender" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Gender</option>
          <option value="Male">Male</option>
          <option value="Male">Female</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="edit_department_id" class="block text-sm font-medium text-gray-700">Department</label>
        <select id="edit_department_id" name="department_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Department</option>
          <?php foreach($dataDepartment as $data): ?>
            <option value="<?php echo $data['department_id'] ?>"><?php echo $data['department_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="edit_position_id" class="block text-sm font-medium text-gray-700">Positon</label>
        <select id="edit_position_id" name="position_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Position</option>
          <?php foreach($dataPosition as $data): ?>
            <option value="<?php echo $data['position_id'] ?>"><?php echo $data['position_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="edit_salary" class="block text-sm font-medium text-gray-700">Salary Rate per hour</label>
        <input type="text" id="edit_salary" name="salary" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Salary:" required>
      </div>
      <div class="mb-4">
        <label for="edit_schedule_id" class="block text-sm font-medium text-gray-700">Schedule</label>
        <select id="edit_schedule_id" name="schedule_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Schedule</option>
          <?php foreach($dataSchedule as $data): ?>
            <option value="<?php echo $data['schedule_id'] ?>"><?php echo $data['schedule_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <!-- Submit Button -->
      <div class="flex justify-between items-center">
        <button type="submit" class="py-[5px] px-4 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
          Submit
        </button>
        <button type="button" id="closeEditModal" class="py-[5px] px-4 border-1 border-gray-300 text-red-500 hover:text-red-700 cursor-pointer shadow-md rounded-sm">
          Close
        </button>
      </div>
    </form>
  </div>
</div>
<script src="../assets/js/employee.js"></script>
