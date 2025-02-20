<?php 
require_once '../services/attendanceApi.php';
require_once '../helper/csrf.php';
$csrf_token = CsrfHelper::generateToken();

if (isset($_SESSION['attendance'])) {
    $data = $_SESSION['attendance'];
    $filter = $_SESSION['filters'];
} else {
    $getData = new AttendanceApi();
    $data = $getData->getAll();
}
?>

<div class="container flex flex-col gap-2 text-[14px]"  style="padding: 0 2rem;">
    <div class="my-2" >
      <label class="text-gray-800 text-[1.3rem] font-bold">
            Time Entry List
      </label>
    </div>
    <div class="h-[4rem] flex flex-row ">
      <div class="w-1/2 flex justify-start items-center" >
        <form action="" method="POST" class="space-y-4 flex flex-row gap-2">
          <div>
            <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date</label>
            <input type="date" id="startDate" name="startDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
          </div>
          <div>
            <label for="endDate" class="block text-sm font-medium text-gray-700">End Date</label>
            <input type="date" id="endDate" name="endDate" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required />
          </div>
          <div class="flex items-center justify-center pt-2" >
            <button type="submit" name="filter" class="w-[120px] py-[7px] border-1 border-gray-300 px-2 border-[#19B37E] text-gray-700 hover:text-blue-500 cursor-pointer shadow-md rounded-sm">
              Filter
            </button>
          </div>
        </form>
    </div>
      <div class="w-1/2 flex flex-row justify-end gap-3" >
      <form class="flex justify-end items-center gap-3" action="../controller/process_attendance.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
          <label id="file_choose" for="file" class="cursor-pointer text-blue-500">Choose File</label> 
          <input type="file" name="attendance_file" id="file" required style="display:none;" onchange="updateFileName();">
          <button type="submit" name="submit" class="w-[120px] py-[7px] border-1 border-gray-300 px-2 border-[#19B37E] text-[#19B37E] hover:text-[#107754] cursor-pointer shadow-md rounded-sm">
              <i class="fas fa-upload"></i> Import
          </button>
      </form>
        <div class="pe-3 flex justify-center items-center">
        <button id="openModal" class="w-[120px] py-[7px] px-2 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
            <i class="fas fa-plus fa"></i>
            Time Entry
        </button>
        </div>
      </div>
    </div>
    <div class="overflow-y-scroll" style="max-height: 400px;" >
      <table class="w-full table-fixed rounded-lg bg-white shadow-md overflow-hidden">
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="py-2 text-center">Id</th>
            <th class="py-2 text-center">Name</th>
            <th class="py-2 text-center">Date</th>
            <th class="py-2 text-center">Status</th>
            <th class="py-2 text-center">Total Hrs Worked</th>
            <th class="py-2 text-center">Overtime</th>
            <th class="py-2 text-center">Late</th>
            <th class="py-2 text-center">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
         
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['attendance_id']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['fullname']); ?></td>
            <td class="py-2 text-center"> <?php echo htmlspecialchars(date('M d Y ', strtotime($display['attendance_date']))); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['attendance_status']) ?></td>
            <td class="py-2 text-center">
                 <?php echo htmlspecialchars($display['total_worked_minutes']/60); ?>
            </td>
            <td class="py-2 text-center">
                <?php echo htmlspecialchars(number_format($display['Overtime'] / 60, 2)); ?>
            </td>
            <td class="py-2 text-center">
                 <?php echo htmlspecialchars($display['total_late_minutes']/60); ?>
            </td>
            <td class="py-2 flex flex-row justify-center gap-4">
              <form action="../controller/attendanceController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['attendance_id'] );?>" hidden>
                <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
            </td>
        </tr>
    
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
</div>


<!-- POP UP -->
<!-- ADD FORM -->
<div id="modal" class="fixed inset-0 bg-opacity-50 flex justify-center items-center hidden" style="background-color: rgba(0, 0, 0, 0.5);">
  <div class="bg-white p-6 rounded-lg w-96 max-h-[80vh] overflow-y-auto">
    <h2 class="text-[20px] mb-4">Time Entry</h2>
    <form id="addForm" action="../controller/attendanceController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
        <label for="employee_id" class="block text-[14px]  font-medium text-gray-700">Employee ID</label>
        <input type="text" id="employee_id" name="employee_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Employee ID:" required>
      </div>
      <div class="mb-4">
        <label for="time_start_1" class="block text-sm font-medium text-gray-700">Time In 1</label>
        <input type="time" id="time_start_1" name="time_in_1" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
         <div class="mb-4">
        <label for="time_out_1" class="block text-sm font-medium text-gray-700">Time Out 1</label>
        <input type="time" id="time_out_1" name="time_out_1" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
         <div class="mb-4">
        <label for="time_start_2" class="block text-sm font-medium text-gray-700">Time In 2</label>
        <input type="time" id="time_start_2" name="time_in_2" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
      <div class="mb-4">
        <label for="time_out_2" class="block text-sm font-medium text-gray-700">Time Out 2</label>
        <input type="time" id="time_out_2" name="time_out_2" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
      <div class="mb-4">
        <label for="attendance_date" class="block text-sm font-medium text-gray-700">Date</label>
        <input type="date" id="attendance_date" name="attendance_date" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
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

<script src="../assets/js/attendance.js"></script>
<script>
  document.getElementById('startDate').value = "<?php echo $filter['start_date']; ?>";
  document.getElementById('endDate').value = "<?php echo $filter['end_date']; ?>";
</script>

