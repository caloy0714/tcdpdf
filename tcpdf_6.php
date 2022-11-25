<?php
require "vendor/autoload.php";
// use TCPDF;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage('L');

// -----------------------------------------------------------------------------

// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = K_PATH_IMAGES.'jan1.jpg';
$pdf->Image($img_file, 15, 50, 35, 9, '', '', '', false, 300, '', false, false, 0);

$img_file = K_PATH_IMAGES.'jan2.jpg';
$pdf->Image($img_file, 50, 50, 34, 9, '', '', '', false, 300, '', false, false, 0);

// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


$tbl = <<<EOD
<table border="1" cellpadding="3" cellspacing="2" align="center">
 <tr nobr="true">
  <th width="850" align="center" style="font-size:28; color:#000000;">January</th>
 </tr>
 <tr nobr="true">
  <td width="120" align="center"><b>SUN</b></td>
  <td width="120" align="center"><b>MON</b></td>
  <td width="120" align="center"><b>TUES</b></td>
  <td width="120" align="center"> <b>WED</b></td>
  <td width="120" align="center"><b>THURS</b></td>
  <td width="120" align="center"><b>FRI</b></td>
  <td width="120" align="center"><b>SAT</b></td>
 </tr>
 <tr nobr="true" >
  <td width="120"><FONT COLOR="#ff0000"><b>1</b></FONT></td>
  <td width="120"><FONT COLOR="#FFFF99"><b>2</b></FONT></td>
  <td width="120">3</td>
  <td width="120">4</td>
  <td width="120">5</td>
  <td width="120">6</td>
  <td width="120">7</td>
 </tr>
 <tr nobr="true">
  <td width="120">8</td>
  <td width="120">9</td>
  <td width="120">10</td>
  <td width="120">11</td>
  <td width="120">12</td>
  <td width="120">13</td>
  <td width="120">14</td>
 </tr>
 <tr nobr="true">
 <td width="120">15</td>
 <td width="120">16</td>
 <td width="120">17</td>
 <td width="120">18</td>
 <td width="120">19</td>
 <td width="120">20</td>
 <td width="120">21</td>
</tr>
<tr nobr="true">
<td width="120">22</td>
<td width="120">23</td>
<td width="120">24</td>
<td width="120">25</td>
<td width="120">26</td>
<td width="120">27</td>
<td width="120">28</td>
</tr>
<tr nobr="true">
<td width="120">29</td>
<td width="120">30</td>
<td width="120">31</td>
</tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');
$pdf->Output();
