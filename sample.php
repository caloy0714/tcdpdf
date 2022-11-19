<?php
require "vendor/autoload.php";

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}
$pdf->setFontSubsetting(true);
$pdf->SetFont('freeserif', '', 12);
$pdf->AddPage();

// get external file content
$utf8text = file_get_contents('chapter_1.txt', false);
$pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
$pdf->AddPage();

$utf8text = file_get_contents('chapter_2.txt', false);
$pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);
$pdf->AddPage();

$utf8text = file_get_contents('chapter_3.txt', false);
$pdf->Write(5, $utf8text, '', 0, '', false, 0, false, false, 0);

//Close and output PDF document
$pdf->Output('example_008.pdf', 'I');
