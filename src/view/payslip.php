<?php
ob_start();

require_once '../../vendor/autoload.php';
require_once '../services/payrollApi.php';
require_once '../helper/base64.php';
$getData = new PayrollApi();

$encryptedData = urldecode($_GET['data']);
$decryptedData = EncryptionHelper::decryptArrayData($encryptedData);

$data = [
    'startDate' => $decryptedData['start_date'],
    'endDate' => $decryptedData['end_date'],
    'id' => $decryptedData['payroll_id']
];

$dataResult = $getData->getPayrollInfo($data);
$deductions = $getData->getAllowances($decryptedData['payroll_id']);

ob_clean();

$pdf = new TCPDF();
$pdf->SetFont('helvetica', '', 12);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Payslip');

$printedEmployeeIds = [];

foreach ($dataResult as $display) {
    // Check if employee has already been printed
    if (!in_array($display['employee_id'], $printedEmployeeIds)) {
        $pdf->AddPage();
        $pdf->Ln(2);
        $pdf->SetFont('helvetica', 'B', 18);
        $pdf->Cell(0, 10, 'PAYSLIP', 0, 1, 'C');
        $pdf->SetFont('helvetica', ' ', 12);
        $pdf->Cell(0, 5, 'Pay Period: ' . $decryptedData['start_date'] . " - " . $decryptedData['end_date'], 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 7, 'Name: ' . $display['fullname'], 0, 1, 'L');
        $pdf->Cell(0, 7, 'Employee ID: ' . $display['employee_id'], 0, 1, 'L');
        $pdf->Cell(0, 7, 'Department: ' . $display['department_name'], 0, 1, 'L');
        $pdf->Cell(0, 7, 'Position: ' . $display['position_name'], 0, 1, 'L');
        $pdf->Cell(0, 7, 'Days: ' . $display['worked_days'], 0, 1, 'L');
        $pdf->Ln(10);

        // Earnings table
        $pdf->Cell(83, 10, 'Earnings', 1, 0, 'C');
        $pdf->Cell(83, 10, 'Amount', 1, 1, 'C');
        $pdf->SetFont('helvetica', ' ', 12);
        $pdf->Cell(83, 10, 'Basic Salary', 1, 0, 'C');
        $pdf->Cell(83, 10, $display['basic_salary'], 1, 1, 'C');
        $pdf->Cell(83, 10, 'Overtime Pay', 1, 0, 'C');
        $pdf->Cell(83, 10, $display['ot_pay'], 1, 1, 'C');
        $pdf->Cell(83, 10, 'Allowance', 1, 0, 'C');
        $pdf->Cell(83, 10, $display['total_allowance'], 1, 1, 'C');
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(83, 10, 'Gross Salary', 1, 0, 'C');
        $pdf->SetFont('helvetica', ' ', 12);
        $pdf->Cell(83, 10, $display['total_allowance'] + $display['basic_salary'] + $display['ot_pay'], 1, 1, 'C');
        
        // Deduction table
        $pdf->Ln(8);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(83, 10, 'Deduction Name', 1, 0, 'C');
        $pdf->Cell(83, 10, 'Rate', 1, 1, 'C');
        $pdf->SetFont('helvetica', '', 12);
        
        $total_deduction = 0;

        foreach ($deductions as $deduction) {
            if ($deduction['employee_id'] == $display['employee_id'] && !empty($deduction['deduction_name']) && !empty($deduction['deduction_rate'])) {
            // Calculate individual deduction
            $deduction_amount = $display['basic_salary'] * ($deduction['deduction_rate'] / 100);
        
            // Add to total deduction
            $total_deduction += $deduction_amount;
        
            $pdf->Cell(83, 10, $deduction['deduction_name'], 1, 0, 'C');
            $pdf->Cell(83, 10, number_format($deduction_amount, 2), 1, 1, 'C');
    }
}

            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(83, 10, 'Total Deduction', 1, 0, 'C');
            $pdf->Cell(83, 10, number_format($total_deduction, 2), 1, 1, 'C');
            $pdf->Ln(10); 

            $pdf->Cell(83, 10, 'Net Pay', 1, 0, 'C');
            $pdf->Cell(83, 10, 'Amount', 1, 1, 'C');
            $pdf->SetFont('helvetica', ' ', 12);
            $pdf->Cell(83, 10, 'Net Pay', 1, 0, 'C');
            $pdf->Cell(83, 10, number_format(($display['total_allowance'] + $display['basic_salary'] + $display['ot_pay']) - $total_deduction, 2), 1, 1, 'C');
        $printedEmployeeIds[] = $display['employee_id'];
    }
}

$pdf->Output('example.pdf', 'I');
ob_end_flush();
