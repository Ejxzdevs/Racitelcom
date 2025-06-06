<?php 
require_once '../services/deductionApi.php';
require_once '../helper/csrf.php';
$csrf_token = CsrfHelper::generateToken();
$getData = new deductionApi();
$data = $getData->getAll();
?>
<div class="container flex flex-col gap-2 text-[14px]"  style="padding: 0 2rem;">
    <div class="h-[4rem] flex items-center justify-between">
        <label class="text-gray-800 text-[1.3rem] font-bold">
            Deduction List
        </label>
        <button id="openModal" class="py-[5px] px-2 border-1 border-gray-300 text-blue-500 hover:text-blue-700 cursor-pointer shadow-md rounded-sm">
            <i class="fas fa-plus fa"></i>
            Deduction
        </button>
    </div>
    <div class="overflow-x-auto" >
      <table class="w-full table-fixed rounded-lg bg-white shadow-md overflow-hidden" >
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="py-2 text-center">Id</th>
            <th class="py-2 text-center">Name</th>
            <th class="py-2 text-center">Rate %</th>
            <th class="py-2 text-center">Created At</th>
            <th class="py-2 text-center">Status</th>
            <th class="py-2 text-center">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['deduction_id']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['deduction_name']); ?></td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['deduction_rate']); ?></td>
            <td class="py-2 text-center">
                <?php echo htmlspecialchars(date('M d Y ', strtotime($display['created_at']))); ?>
            </td>
            <td class="py-2 text-center"><?php echo htmlspecialchars($display['deduction_status']); ?></td>
            <td class="py-2 flex flex-row justify-center gap-4">
              <form action="../controller/deductionController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['deduction_id'] );?>" hidden>
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
    <h2 class="text-[20px] mb-4">Create deduction</h2>
    <form id="addForm" action="../controller/deductionController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
        <label for="deduction_name" class="block text-sm font-medium text-gray-700">Deduction Name</label>
        <input type="text" id="deduction_name" name="deduction_name" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Name:" required>
      </div>
      <div class="mb-4">
        <label for="deduction_rate" class="block text-sm font-medium text-gray-700">Rate</label>
        <input type="text" id="deduction_rate" name="deduction_rate" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Percentage:" required>
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
    <h2 class="text-[20px] mb-4">Update deduction</h2>
    <form id="editForm" action="../controller/deductionController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="update">
        <input type="hidden" id="id" name="deduction_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
        <label for="edit_deduction_name" class="block text-sm font-medium text-gray-700">Deduction Name</label>
        <input type="text" id="edit_deduction_name" name="deduction_name" class="text-[14px] mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Name:" required>
      </div>
      <div class="mb-4">
        <label for="edit_deduction_rate" class="block text-sm font-medium text-gray-700">Rate %</label>
        <input type="text" id="edit_deduction_rate" name="deduction_rate" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Percentage:" required>
      </div>
      <div class="mb-4">
        <label for="edit_deduction_status" class="block text-sm font-medium text-gray-700">Status</label>
        <select id="edit_deduction_status" name="deduction_status" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <option value="off">OFF</option>
            <option value="on">ON</option>
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
<script src="../assets/js/deduction.js"></script>