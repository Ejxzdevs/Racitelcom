<?php
require_once '../helper/base64.php';
require_once '../services/payrollApi.php';
$getData = new PayrollApi();

if (isset($_GET['data'])) {
    // Get the encrypted data from the URL
    $encryptedData = urldecode($_GET['data']);
    $decryptedData = EncryptionHelper::decryptArrayData($encryptedData);

    if ($decryptedData !== null) {
        $data = [
            'startDate' => $decryptedData['start_date'],
            'endDate' => $decryptedData['end_date'],
            'id' => $decryptedData['payroll_id']
        ];
        $dataResult = $getData->getPayrollInfo($data);
        
        // Initialize an array to track displayed employee IDs to prevent duplicates
        $displayedEmployeeIds = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media (max-width: 768px) {
            table {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="container mx-auto px-4 py-6">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-800">
                Payroll Interval: 
                <?php 
                    echo htmlspecialchars(date('M d, Y', strtotime($decryptedData['start_date']))); 
                    echo ' to ';
                    echo htmlspecialchars(date('M d, Y', strtotime($decryptedData['end_date']))); 
                ?>
            </h1>
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full table-auto border-separate border-spacing-0">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Full Name</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Department</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Position</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Worked Days</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Basic Salary</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">OT Salary</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Allowances</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Gross Salary</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Deductions</th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-600">Net Salary</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php foreach($dataResult as $display): ?>
                            <?php 
                            // Check if employee ID has already been displayed
                            if (in_array($display['employee_id'], $displayedEmployeeIds)) {
                                continue;
                            }
                            $displayedEmployeeIds[] = $display['employee_id'];
                            ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['fullname']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['department_name']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['position_name']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['worked_days']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['basic_salary']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['ot_pay']); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['total_allowance'] ?? 0); ?></td>
                                <td class="px-4 py-3 text-sm"><?= htmlspecialchars($display['total_allowance'] ?? 0) +  htmlspecialchars($display['basic_salary']) + htmlspecialchars($display['ot_pay']); ?></td>
                                <td class="px-4 py-3 text-sm">
                                    <?php 
                                    $total_allowance = $display['total_allowance'] ?? 0;
                                    $basic_salary = $display['basic_salary'] ?? 0;
                                    $ot_pay = $display['ot_pay'] ?? 0;
                                    $total_deduction = $display['total_deduction'] ?? 0;
                                    $total_salary = $total_allowance + $basic_salary + $ot_pay;
    
                                    if ($total_deduction != 0) {
                                        $result = $total_salary / $total_deduction;
                                    } else {
                                        $result = 0;
                                     }
                                    echo number_format(htmlspecialchars($result), 2);
                                    ?>
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <?php 
                                    $total_allowance = $display['total_allowance'] ?? 0;
                                    $basic_salary = $display['basic_salary'] ?? 0;
                                    $ot_pay = $display['ot_pay'] ?? 0;
                                    $total_deduction = $display['total_deduction'] ?? 0;
                                    $total_salary = $total_allowance + $basic_salary + $ot_pay;
    
                                    if ($total_deduction != 0) {
                                        $result = $total_salary / $total_deduction;
                                    } else {
                                        $result = 0;
                                     }
                                     echo number_format(htmlspecialchars($total_salary) - htmlspecialchars($result), 2);
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="10" class="text-center text-red-500 py-4">Invalid or corrupted data.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
<?php } ?>
