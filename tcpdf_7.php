<?php
require "vendor/autoload.php";
// use TCPDF;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

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
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 14, '', true);
$pdf->AddPage();

// set colors for gradients (r,g,b) or (grey 0-255)
$red = array(255, 0, 0);
$blue = array(0, 0, 200);
$yellow = array(255, 255, 0);
$green = array(0, 255, 0);
$white = array(255);
$black = array(0);

// first patch: f = 0
$patch_array[0]['f'] = 0;
$patch_array[0]['points'] = array(
    0.00,0.00, 0.33,0.00,
    0.67,0.00, 1.00,0.00, 1.00,0.33,
    0.8,0.67, 1.00,1.00, 0.67,0.8,
    0.33,1.80, 0.00,1.00, 0.00,0.67,
    0.00,0.33);
$patch_array[0]['colors'][0] = array('r' => 255, 'g' => 255, 'b' => 0);
$patch_array[0]['colors'][1] = array('r' => 0, 'g' => 0, 'b' => 255);
$patch_array[0]['colors'][2] = array('r' => 0, 'g' => 255,'b' => 0);
$patch_array[0]['colors'][3] = array('r' => 255, 'g' => 0,'b' => 0);

// second patch - above the other: f = 2
$patch_array[1]['f'] = 2;
$patch_array[1]['points'] = array(
    0.00,1.33,
    0.00,1.67, 0.00,2.00, 0.33,2.00,
    0.67,2.00, 1.00,2.00, 1.00,1.67,
    1.5,1.33);
$patch_array[1]['colors'][0]=array('r' => 0, 'g' => 0, 'b' => 0);
$patch_array[1]['colors'][1]=array('r' => 255, 'g' => 0, 'b' => 255);

// third patch - right of the above: f = 3
$patch_array[2]['f'] = 3;
$patch_array[2]['points'] = array(
    1.33,0.80,
    1.67,1.50, 2.00,1.00, 2.00,1.33,
    2.00,1.67, 2.00,2.00, 1.67,2.00,
    1.33,2.00);
$patch_array[2]['colors'][0] = array('r' => 0, 'g' => 255, 'b' => 255);
$patch_array[2]['colors'][1] = array('r' => 0, 'g' => 0, 'b' => 0);

// fourth patch - below the above, which means left(?) of the above: f = 1
$patch_array[3]['f'] = 1;
$patch_array[3]['points'] = array(
    2.00,0.67,
    2.00,0.33, 2.00,0.00, 1.67,0.00,
    1.33,0.00, 1.00,0.00, 1.00,0.33,
    0.8,0.67);
$patch_array[3]['colors'][0] = array('r' => 0, 'g' => 0, 'b' => 0);
$patch_array[3]['colors'][1] = array('r' => 0, 'g' => 0, 'b' => 255);

$coords_min = 0;
$coords_max = 2;

$pdf->CoonsPatchMesh(10, 45, 190, 200, '', '', '', '', $patch_array, $coords_min, $coords_max);
// 
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 234, 0));
//$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(255, 234, 0));

$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
$style4 = array('L' => 0,
                'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
                'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
                'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 64, 128));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
$style7 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 128, 0));



// set colors for gradients (r,g,b) or (grey 0-255)
$red = array(255, 0, 0);
$blue = array(0, 0, 200);
$yellow = array(255, 255, 0);
$green = array(0, 255, 0);
$white = array(255);
$black = array(0);

$pdf->SetTextColor(255, 255, 254);
$pdf->SetFont('times', '', 30);
$html = <<<EOD
<br>
<br>
<br>
<h1 style="text-align:center">We Wish You an Amazing Holiday</h1>
<h3 style="text-align:center">And</h3>
<h1 style="text-align:center">A Happy New Year</h1>
EOD;
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

$pdf->Ln(20);
// set general stretching (scaling) value
$pdf->Cell(0, 0, 'Enjoy the Holidays!', 1, 1, 'C', 0, '', 2);



// Star polygon
$pdf->SetLineStyle($style6);
$pdf->StarPolygon(22, 230, 15, 20, 3, 30, 1, 'F');
$pdf->StarPolygon(55, 230, 15, 12, 5);

$pdf->StarPolygon(55, 230, 7, 12, 5, 45, 0, 'DF', array('all' => $style3), array(220, 220, 200), 'F', array(255, 200, 200));
$pdf->StarPolygon(90, 230, 15, 20, 6, 0, 1, 'DF', array('all' => $style5), array(220, 220, 200), 'F', array(255, 200, 200));

$pdf->StarPolygon(125, 230, 15, 5, 2, 30, 1, null, array('all' => $style), null, null, $style6);
$pdf->StarPolygon(160, 230, 15, 10, 3);

$pdf->StarPolygon(160, 230, 7, 50, 26);;



$pdf->Output('example_009.pdf', 'I');