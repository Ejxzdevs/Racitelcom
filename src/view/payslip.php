<?php
require_once('../../vendor/autoload.php');

// Create new TCPDF object
$pdf = new TCPDF();
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Loop to add 10 pages
for ($i = 1; $i <= 10; $i++) {
    if ($i > 1) {
        // Add a new page for all pages except the first
        $pdf->AddPage();
    }
    // Write content to each page
    $pdf->Cell(0, 10, 'Hello World - Page ' . $i, 0, 1, 'C');
}

// Output the PDF
$pdf->Output('example.pdf', 'I');
?>
