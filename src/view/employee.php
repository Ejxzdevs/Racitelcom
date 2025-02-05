<div class="container flex flex-col"  style="padding: 0 2rem;">
    <div class="h-[3rem] flex items-center justify-between ">
        <label class="text-gray-800 text-[1.5rem] font-bold font-inter">
            Employee List
        </label>
        <button id="openModal" class="bg-blue-500 text-white hover:bg-blue-700 rounded-sm" style="padding: 2px 4px;">
            Add Employee
        </button>
    </div>
    <div>
        <table class="min-w-full table-auto rounded-lg bg-gray-100 text-sm text-center px-4 py-8">
            <thead>
                <tr class="h-[3rem] border">
                    <th>Id</th>
                    <th>Fullname</th>
                    <th>Date Hired</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr class="h-[2rem] border">
                    <td><p>s</p></td>
                    <td><p>s</p></td>
                    <td><p>s</p></td>
                    <td><p>s</p></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


<!-- POP UP -->
<div id="modal" class="fixed inset-0 bg-opacity-50 flex justify-center items-center hidden" style="background-color: rgba(0, 0, 0, 0.5);">
  <div class="bg-white p-6 rounded-lg w-96 max-h-[80vh] overflow-y-auto">
    <h2 class="text-2xl mb-4">New Employee</h2>
    <form id="popupForm">
      <!-- Input Field -->
      <div class="mb-4">
        <label for="fullname" class="block text-sm font-medium text-gray-700">fullname</label>
        <input type="text" id="fullname" name="fullname" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Fullname:" required>
      </div>
      <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" id="email" name="email" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Email:" required>
      </div>
      <div class="mb-4">
        <label for="number" class="block text-sm font-medium text-gray-700">Contact Number</label>
        <input type="text" id="number" name="number" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Number:" required>
      </div>
      <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
        <input type="address" id="address" name="address" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Address:" required>
      </div>
      <div class="mb-4">
        <label for="employeeType" class="block text-sm font-medium text-gray-700">Department</label>
        <select id="employeeType" name="employeeType" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Department</option>
          <option value="Day Shift">Day Shift</option>
          <option value="Night Shift">Night Shift</option>
          <option value="Graveyard">Graveyard</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="employeeType" class="block text-sm font-medium text-gray-700">Position</label>
        <select id="employeeType" name="employeeType" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Position</option>
          <option value="Day Shift">Day Shift</option>
          <option value="Night Shift">Night Shift</option>
          <option value="Graveyard">Graveyard</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="employeeType" class="block text-sm font-medium text-gray-700">Schedule</label>
        <select id="employeeType" name="employeeType" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select Schedule</option>
          <option value="Day Shift">Day Shift</option>
          <option value="Night Shift">Night Shift</option>
          <option value="Graveyard">Graveyard</option>
        </select>
      </div>
      <div class="mb-4">
        <label for="employeeType" class="block text-sm font-medium text-gray-700">Employee Type</label>
        <select id="employeeType" name="employeeType" class="mt-1 p-2 w-full border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
          <option value="" disabled selected>Select employee type</option>
          <option value="full-time">Full-Time</option>
          <option value="part-time">Part-Time</option>
          <option value="contractor">Contractor</option>
        </select>
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
<script src="../assets/js/popUpform.js"></script>
