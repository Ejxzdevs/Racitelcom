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
        ];
        $dataResult = $getData->getPayrollInfo($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payroll Information</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <label class="text-xl font-semibold text-gray-700">
            Payroll for 
            <?php 
            echo htmlspecialchars(date('M d, Y', strtotime($decryptedData['start_date']))); 
            echo ' to ';
            echo htmlspecialchars(date('M d, Y', strtotime($decryptedData['end_date']))); 
            ?>
        </label>
        <div class="overflow-x-auto bg-white shadow-md rounded-lg mt-5">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Full Name</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Department</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Position</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Gross Salary</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Worked Days</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php foreach($dataResult as $display): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2 text-center text-sm"><?= htmlspecialchars($display['employee_id']); ?></td>
                            <td class="px-4 py-2 text-center text-sm"><?= htmlspecialchars($display['department_name']); ?></td>
                            <td class="px-4 py-2 text-center text-sm"><?= htmlspecialchars($display['position_name']); ?></td>
                            <td class="px-4 py-2 text-center text-sm">
                                <?= htmlspecialchars(number_format($display['total_minutes'] * ($display['hourly_rate'] / 60), 2)); ?>
                            </td>
                            <td class="px-4 py-2 text-center text-sm"><?= htmlspecialchars($display['worked_days']); ?></td>
                            <td class="px-4 py-2 text-center text-sm">
                                <button onclick='openModal(<?php echo json_encode($display); ?>)' class="bg-blue-500 text-white py-1 px-3 rounded hover:bg-blue-600">
                                    Details
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="6" class="text-center text-red-500 py-4">Invalid or corrupted data.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<!-- Modal -->
<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-4/5 h-4/5 max-w-full max-h-full relative"> <!-- 80% width and height -->
        <div class="text-center mb-8"> <!-- Added margin-bottom to give space for close button -->
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Employee Details</h2>
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">ID</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Working Hours</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Salary</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-center text-sm">1</td>
                        <td class="px-4 py-2 text-center text-sm">2</td>
                        <td class="px-4 py-2 text-center text-sm">3</td>
                        <td class="px-4 py-2 text-center text-sm">4</td>
                        <td class="px-4 py-2 text-center text-sm">5</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="absolute bottom-4 right-4">
            <button onclick="closeModal()" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                Close
            </button>
        </div>
    </div>
</div>




</body>
    <script>
        // Function to open the modal with details
        function openModal($id) {
         

            // Show the modal
            document.getElementById('modal').classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</html>
<?php } ?>
