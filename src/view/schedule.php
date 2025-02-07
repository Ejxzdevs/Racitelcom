<?php 
require_once '../services/scheduleApi.php';
require_once '../helper/csrf.php';
$csrf_token = CsrfHelper::generateToken();
$getData = new ScheduleApi();
$data = $getData->getAll();
?>
<div class="container flex flex-col"  style="padding: 0 2rem;">
    <div class="h-[3rem] flex items-center justify-between ">
        <label class="text-gray-800 text-[1.5rem] font-bold font-inter">
            Schedule List
        </label>
        <button id="openModal" class="bg-blue-500 text-white hover:bg-blue-700 rounded-sm" style="padding: 2px 4px;">
            Add Schedule
        </button>
    </div>
    <div class="overflow-x-auto" >
      <table class="min-w-full table-auto rounded-lg bg-white shadow-md overflow-hidden">
        <thead class="bg-gray-200">
          <tr class="text-gray-700 border-b">
            <th class="px-4 py-2 text-left">Id</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Time Start</th>
            <th class="px-4 py-2 text-left">Time End</th>
            <th class="px-4 py-2 text-left">Action</th>
          </tr>
        </thead>
      <tbody>
        <?php foreach ($data as $display): ?>
        <tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="px-4 py-2"><?php echo htmlspecialchars($display['schedule_id']); ?></td>
            <td class="px-4 py-2"><?php echo htmlspecialchars($display['schedule_name']); ?></td>
            <td class="px-4 py-2"><?php echo htmlspecialchars((new DateTime($display['time_start']))->format('g:i A')); ?></td>
            <td class="px-4 py-2"><?php echo htmlspecialchars((new DateTime($display['time_end']))->format('g:i A')); ?></td>
            <td class="px-4 py-2">
              <form action="../controller/scheduleController.php" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
                <input type="hidden" name="delete">
                <input type="text" name="id" value="<?php echo htmlspecialchars( $display['schedule_id'] );?>" hidden>
                <button class="text-blue-500 hover:text-blue-700 focus:outline-none">Delete</button>
              </form>
              <a href="javascript:void(0);" class="edit-link" data-schedule="<?php echo htmlspecialchars(json_encode($data)); ?>">edit</a>
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
    <h2 class="text-2xl mb-4">New Schedule</h2>
    <form id="popupForm" action="../controller/scheduleController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="insert">
        <label for="schedule_name" class="block text-sm font-medium text-gray-700">Schedule Name</label>
        <input type="text" id="schedule_name" name="schedule_name" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Schedule Name:" required>
      </div>
      <div class="mb-4">
        <label for="time_start" class="block text-sm font-medium text-gray-700">Time Start</label>
        <input type="time" id="time_start" name="time_start" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="time_end" class="block text-sm font-medium text-gray-700">Time End</label>
        <input type="time" id="time_end" name="time_end" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <!-- Submit Button -->
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
          Submit
        </button>
        <button type="button" id="closeModal" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700">
          Close
        </button>
      </div>
    </form>
  </div>
</div>


<!-- EDIT -->

<div id="editmodal" class="fixed inset-0 bg-opacity-50 flex justify-center items-center hidden" style="background-color: rgba(0, 0, 0, 0.5);">
  <div class="bg-white p-6 rounded-lg w-96 max-h-[80vh] overflow-y-auto">
    <h2 class="text-2xl mb-4">Edit Schedule</h2>
    <form id="popupForm" action="../controller/scheduleController.php" method="POST">
      <!-- Input Field -->
      <div class="mb-4">
        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token ?>">
        <input type="hidden" name="update">
        <label for="schedule_name" class="block text-sm font-medium text-gray-700">Schedule Name</label>
        <input type="text" id="edit_schedule_name" name="schedule_name" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Schedule Name:" required>
      </div>
      <div class="mb-4">
        <label for="time_start" class="block text-sm font-medium text-gray-700">Time Start</label>
        <input type="time" id="edit_time_start" name="time_start" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <div class="mb-4">
        <label for="time_end" class="block text-sm font-medium text-gray-700">Time End</label>
        <input type="time" id="edit_time_end" name="time_end" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
      </div>
      <!-- Submit Button -->
      <div class="flex justify-between items-center">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">
          Submit
        </button>
        <button type="button" id="closeEditModal" class="cursor-pointer bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700">
          Close
        </button>
      </div>
    </form>
  </div>
</div>
<script src="../assets/js/popUpform.js"></script>
<script>
    const editModal = document.getElementById("editmodal");
    document.querySelectorAll('.edit-link').forEach(link => {
        link.addEventListener('click', function(event) {
            const getData = JSON.parse(event.target.getAttribute('data-schedule'));
            const data = getData[0];

            document.getElementById('edit_schedule_name').value = data.schedule_id;
            document.getElementById('edit_time_start').value = data.time_start;
            document.getElementById('edit_time_end').value = data.time_end;
    
            editModal.classList.remove("hidden");
            
            console.log(data);
        });
    });

    const closeEditModal = document.getElementById("closeEditModal");
    
    closeEditModal.addEventListener("click", function() {
        editModal.classList.add("hidden");
    });
</script>

