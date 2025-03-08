<?php
ob_start();

require_once '../../vendor/autoload.php';
require_once '../services/EmployeeApi.php';
$getData = new EmployeeApi();
$data = $getData->getAllReport($_GET['date']);
$totalEmp = count($data);

ob_clean();
$pdf = new TCPDF();
$pdf->SetFont('helvetica', '', 12);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle($_GET['data']);
$pdf->AddPage();
$pdf->Ln(2);
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 7, $_GET['data'], 0, 1, 'C');
$pdf->SetFont('helvetica', ' ', 10);
$pdf->Cell(0, 5, 'XYZ Corporation', 0, 1, 'C');
$pdf->Cell(0, 5, '123 Business Rd, Philippines, 10001  ', 0, 1, 'C');
$pdf->Ln(10);

if($_GET['data'] === 'All Employees'){
    $pdf->Cell(30, 7, 'Total Employees: ' . $totalEmp, 0, 0, 'L');
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', '', 10);
    $pdf->Cell(50, 8, 'Fullname', 1, 0, 'C');
    $pdf->Cell(45, 8, 'Department', 1, 0, 'C');
    $pdf->Cell(45, 8, 'Position', 1, 0, 'C');
    $pdf->Cell(45, 8, 'Date Hired', 1, 1, 'C');
    foreach($data as $display):
        $pdf->Cell(50, 7, $display['fullname'] , 1, 0, 'C');
        $pdf->Cell(45, 7, $display['department_name'] , 1, 0, 'C');
        $pdf->Cell(45, 7, $display['position_name'] , 1, 0, 'C');
        $pdf->Cell(45, 7, date('F j, Y', strtotime($display['created_at'])), 1, 1, 'C');
    endforeach;
}else{
    $pdf->Cell(50, 8, 'NO DATA', 0, 0, 'C');
}
$type = $_GET['type'];
$type === 'view' ? $pdf->Output('employee.pdf', 'I') : ($type === 'download' ? $pdf->Output('employee.pdf', 'D') : null);
ob_end_flush();