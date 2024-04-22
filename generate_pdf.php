<?php
require_once('tcpdf/tcpdf.php');

$jsonData = json_decode(file_get_contents('php://input'));

// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('dejavusans', '', 12);

// Add the graph image
$graphDataUrl = $jsonData->graphDataUrl;
$imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $graphDataUrl));
$pdf->Image('@' . $imageData, 10, 10, 190);

// Add the item list
$data = $jsonData->data;
$pdf->SetXY(10, 220);
$pdf->MultiCell(0, 10, implode("\n", $data));

// Close and output the PDF
$pdf->Output('SalesReport.pdf', 'D');
?>
