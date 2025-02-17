<?php 
require_once '../services/payrollApi.php';
require_once '../helper/csrf.php';
require_once '../helper/base64.php';
$csrf_token = CsrfHelper::generateToken();
$getData = new payrollApi();
$data = $getData->getAll();
?>
<div class="container flex flex-col gap-2 text-[14px]"  style="padding: 0 2rem;">
    <div class="h-[4rem] flex items-center justify-between ">
        <label class="text-gray-800 text-[1.3rem] font-bold">
            Payroll List
        </label>
        <button id="openModal" class="py-[5px] px-2 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
            <i class="fas fa-plus fa"></i>
            Generate Payroll
        </button>
    </div>
    <div class="overflow-x-auto" >
      <table class="w-full table-fixed rounded-lg bg-white shadow-md overflow-hidden" >
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="py-2 text-center">Id</th>
            <th class="py-2 text-center">Type</th>
            <th class="py-2 text-center">Interval</th>
            <th class="py-2 text-center">Generate At</th>
            <th class="py-2 text-center">Status</th>
            <th class="py-2 text-center">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['payroll_id']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['payroll_type']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars(date('M d ', strtotime($display['start_date']))); ?> - <?php echo htmlspecialchars(date('M d Y ', strtotime($display['end_date']))); ?></td>
            <td class="py-2 text-center">
                <?php echo htmlspecialchars(date('M d Y ', strtotime($display['created_at']))); ?>
            </td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['payroll_status']); ?></td>
            <td class="py-2 flex flex-row justify-center gap-4">
              <form action="../controller/payrollController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['payroll_id'] );?>" hidden>
                <button class="text-red-500 hover:text-red-700 focus:outline-none cursor-pointer">
                  <i class="fas fa-trash"></i>
                </button>
              </form>
                <a href="salary.php?data=<?php echo urlencode(EncryptionHelper::encryptArrayData($display)); ?>" class="text-blue-500 hover:text-blue-700 cursor-pointer" target="_blank">
                    <i class="fas fa-eye"></i>
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
    <h2 class="text-[20px] mb-4">Generate Payroll</h2>
    <form id="addForm" action="../controller/payrollController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
      </div>
      <div class="mb-4">
        <label for="payroll_type" class="block text-sm font-medium text-gray-700">Type</label>
        <select id="payroll_type" name="payroll_type" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Payroll Type</option>
            <option value="ALL EMPLOYEES">All Employees</option>
            <option value="SPECIFIC EMPLOYEE">Specific Employee</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="start_date" class="block text-sm font-medium text-gray-700">Date Start</label>
        <input type="date" id="start_date" name="start_date" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
      <div class="mb-4">
        <label for="end_date" class="block text-sm font-medium text-gray-700">Date End</label>
        <input type="date" id="end_date" name="end_date" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
      </div>
      <div class="mb-4">
        <label for="deduction_status" class="block text-sm font-medium text-gray-700">Type</label>
        <select id="deduction_status" name="deduction_status" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Deduction</option>
            <option value="all">On</option>
            <option value="specific">Off</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="pay_date" class="block text-sm font-medium text-gray-700">Pay Date</label>
        <input type="date" id="pay_date" name="pay_date" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" >
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
<script src="../assets/js/payroll.js"></script>


