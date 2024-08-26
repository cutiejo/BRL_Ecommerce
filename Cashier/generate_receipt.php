<?php
require_once('tcpdf/tcpdf.php');

function generateReceipt($companyName, $companyAddress, $companyNumber, $products, $footer) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('BRL Trading');
    $pdf->SetTitle('Receipt');
    $pdf->SetSubject('Receipt');

    // Add a page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Company details
    $pdf->Cell(0, 10, $companyName, 0, 1);
    $pdf->Cell(0, 10, $companyAddress, 0, 1);
    $pdf->Cell(0, 10, $companyNumber, 0, 1);

    // Table header
    $pdf->Ln();
    $pdf->Cell(60, 10, 'Product Name', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Total', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Paid', 1, 1, 'C');

    // Table data
    foreach ($products as $product) {
        $pdf->Cell(60, 10, $product['name'], 1, 0, 'C');
        $pdf->Cell(40, 10, $product['total'], 1, 0, 'C');
        $pdf->Cell(40, 10, $product['paid'], 1, 1, 'C');
    }

    // Footer
    $pdf->Ln();
    $pdf->Cell(0, 10, 'Thank you for choosing BRL Trading', 0, 1, 'C');
    $pdf->Cell(0, 10, 'Hope you liked it', 0, 1, 'C');

    // Close and output PDF
    $pdf->Output('receipt.pdf', 'I');
}

// Sample data
$companyName = 'BRL Trading';
$companyAddress = '123 Street, City, Country';
$companyNumber = '123-456-789';
$products = array(
    array('name' => 'Product 1', 'total' => '$10', 'paid' => '$10'),
    array('name' => 'Product 2', 'total' => '$20', 'paid' => '$20')
);
$footer = '';

// Generate receipt
generateReceipt($companyName, $companyAddress, $companyNumber, $products, $footer);
?>
