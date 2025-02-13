<?php 
require_once '../services/fileLeaveApi.php';
require_once '../helper/csrf.php';
$csrf_token = CsrfHelper::generateToken();
$getData = new fileLeaveApi();
$data = $getData->getAll();

require_once '../services/leaveApi.php';
$getLeave = new LeaveApi();
$dataLeave = $getLeave->getAll();
?>
<div class="container flex flex-col gap-2 text-[14px]"  style="padding: 0 2rem;">
    <div class="h-[4rem] flex items-center justify-between ">
        <label class="text-gray-800 text-[1.3rem] font-bold">
            File Leave List
        </label>
        <button id="openModal" class="py-[5px] px-2 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
            <i class="fas fa-plus fa"></i>
            File Leave
        </button>
    </div>
    <div class="overflow-x-auto" >
      <table class="w-full table-fixed rounded-lg bg-white shadow-md overflow-hidden" >
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="py-2 text-center">Id</th>
            <th class="py-2 text-center" >Employee name</th>
            <th class="py-2 text-center">Date File</th>
            <th class="py-2 text-center">Days</th>
            <th class="py-2 text-center">Status</th>
            <th class="py-2 text-center">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['file_leave_id']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['fullname']); ?></td>
            <td class="py-2 text-center">
                <?php echo htmlspecialchars(date('M d Y ', strtotime($display['created_at']))); ?>
            </td>
            <td class="py-2 text-center">
            <?php echo htmlspecialchars(date('M d ', strtotime($display['start_date']))); ?> - 
            <?php echo htmlspecialchars(date('M d ', strtotime($display['end_date']))); ?>
            </td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['file_status']); ?></td>
            <td class="py-2 flex flex-row justify-center gap-4">
              <form action="../controller/fileLeaveController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['file_leave_id'] );?>" hidden>
                <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
              <a href="javascript:void(0);" class="edit-link text-blue-500 hover:text-blue-700 cursor-pointer"  data='<?php echo htmlspecialchars(json_encode($display), ENT_QUOTES, 'UTF-8'); ?>'>
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
    <h2 class="text-[20px] mb-4">Create file Leave</h2>
    <form id="addForm" action="../controller/fileLeaveController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
        <label for="employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
        <input type="text" id="employee_id" name="employee_id" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Employee ID:" required>
      </div>
      <div class="mb-4">
        <label for="leave_id" class="block text-sm font-medium text-gray-700">Leave Type</label>
        <select id="leave_id" name="leave_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Leave</option>
          <?php foreach($dataLeave as $data): ?>
          <option value="<?php echo $data['leave_id']?>"><?php echo $data['leave_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
        <input type="date" id="start_date" name="start_date" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
        <input type="date" id="end_date" name="end_date" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="reason" class="block text-sm font-medium text-gray-700">Reason for leave</label>
        <textarea id="reason" name="reason" class="text-[12px] w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 !p-1" cols="50" rows="5" required></textarea>
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
    <h2 class="text-[20px] mb-4">Update file Leave</h2>
    <form id="editForm" action="../controller/fileLeaveController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="update">
        <input type="hidden" id="id" name="file_leave_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        <label for="edit_employee_id" class="block text-sm font-medium text-gray-700">Employee ID</label>
        <input type="text" id="edit_employee_id" name="employee_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="edit_leave_id" class="block text-sm font-medium text-gray-700">Leave Type</label>
        <select id="edit_leave_id" name="leave_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Leave</option>
          <?php foreach($dataLeave as $data): ?>
          <option value="<?php echo $data['leave_id']?>"><?php echo $data['leave_name'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="mb-4">
        <label for="edit_start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
        <input type="date" id="edit_start_date" name="start_date" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="edit_end_date" class="block text-sm font-medium text-gray-700">End Date</label>
        <input type="date" id="edit_end_date" name="end_date" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="edit_reason" class="block text-sm font-medium text-gray-700">Reason for leave</label>
        <textarea id="edit_reason" name="reason" class="text-[12px] w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 !p-1" cols="50" rows="5" required></textarea>
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
<script src="../assets/js/fileLeave.js"></script>


