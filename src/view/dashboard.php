<?php 
    require_once '../services/EmployeeApi.php';
    require_once '../services/departmentApi.php';
    require_once '../services/deductionApi.php';
    require_once '../services/allowanceApi.php';
    require_once '../services/reportApi.php';
    require_once '../services/holidayApi.php';

    require_once '../services/earningApi.php';

    require_once '../services/attendanceApi.php';

    $getEmps = new EmployeeApi();
    $employees = $getEmps->getAll();

    $getDepartments = new DepartmentApi();
    $departments = $getDepartments->getAll();

    $getDeductions = new deductionApi();
    $deductions = $getDeductions->getAll();

    $getallowances = new AllowanceApi();
    $allowances = $getallowances->getAll();

    $getReport = new ReportApi();
    $total_report = $getReport->getReportsForCurrentMonth();

    $getIncomingHoliday = new HolidayApi();
    $total_incoming_holiday = $getIncomingHoliday->countIncomingHolidays();

    // For Revenue Overview 
    $getTotalPayrollPerMonth = new  EarningApi();
    $data = $getTotalPayrollPerMonth->getPayrollDataPerMonth();
    $payrollJson = json_encode($data);

    // Get Latest Attendance
    $getAttendance = new AttendanceApi();
    $attendance = $getAttendance->getAll();
    


?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container mx-auto py-6 px-7 block overflow-y-auto max-h-[100vh] shadow-md rounded-xl border border-gray-200">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">Dashboard</h1>
    </div>

    <!-- Total Section -->
    <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 cursor-pointer">
        <!-- Total Employees -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-blue-600 mb-3">
                <i class="fas fa-users"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Total Employees</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo count($employees) ?></p>
        </div>

         <!-- Total Departments -->
         <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-green-600 mb-3">
                <i class="fas fa-building"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Total Department</p>
            <p class="text-2xl font-bold text-gray-900"><?php  echo count( $departments )?></p>
        </div>

        <!-- Total Allowances -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-yellow-500 mb-3">
                <i class="fas fa-gift"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Total Allowances</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo count( $allowances); ?></p>
        </div>

        <!-- Total Deductions -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-red-600 mb-3">
                <i class="fas fa-minus-circle"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Total Deductions</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo count($deductions) ?></p>
        </div>

        <!-- Total Reports -->
        <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-red-600 mb-3">
                <i class="fas fa-chart-bar"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Montly Reports</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo count( $total_report) ?></p>
        </div>

         <!-- Incoming Montly Holiday -->
         <div class="bg-white shadow-md rounded-xl p-6 flex flex-col items-center border border-gray-200">
            <div class="text-4xl text-red-600 mb-3">
                <i class="fas fa-calendar-day"></i>
            </div>
            <p class="text-lg font-semibold text-gray-700">Incoming Holiday</p>
            <p class="text-2xl font-bold text-gray-900"><?php echo $total_incoming_holiday ?></p>
        </div>



    </div>

    <!-- Sum of each Payroll per Month -->
    <div class="mt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Payroll Each Month</h2>
        <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <!-- Latest Attendance (Scrollable) -->
    <div class="mt-6 mb-6 pb-10">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Latest Attendance</h2>

        <div class="overflow-y-auto max-h-[300px] bg-white shadow-md rounded-xl border border-gray-200">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="bg-gray-100 sticky top-0">
                    <tr>
                        <th class="px-4 py-3">Employee</th>
                        <th class="px-4 py-3">Check-In</th>
                        <th class="px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($attendance as $display): ?>
                    <tr class="border-t">
                        <td class="px-4 py-3 font-medium"><?php echo htmlspecialchars($display['fullname']); ?></td>
                        <td class="px-4 py-3"> <?php echo date("h:i A", strtotime($display['time_in_1'])); ?></td>
                        <td class="px-4 py-3 font-semibold <?php echo ($display['attendance_status'] == 'Late') ? 'text-red-600' : 'text-green-600'; ?>"><?php echo htmlspecialchars($display['attendance_status']); ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script Section -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const payrollData = <?php echo $payrollJson; ?>;
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const payrollValues = months.map((month, index) => {
            const found = payrollData.find(item => item.month === `2025-${String(index + 1).padStart(2, '0')}`);
            return found ? found.total_payroll : 0;
        });

        const ctx = document.getElementById("revenueChart").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: months,
                datasets: [{
                    label: "Total Payroll Monthly)",
                    data: payrollValues,
                    backgroundColor: "#141B24",
                    borderColor: "#141B24",
                    borderWidth: 2,
                    fill: false,
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: "Payroll Amount (PHP)" }
                    },
                    x: {
                        title: { display: true, text: "Months" }
                    },
                },
            },
        });
    });
</script>