<?php
require "vendor/autoload.php";

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$csv_file = 'countries.csv';
$handle = fopen($csv_file, 'r');
$row_index = 0; 
$headers = [];
$data = [];

while (($row_data = fgetcsv($handle, 1000, ',')) !== FALSE)
{
	if ($row_index++ < 1)
	{
		foreach ($row_data as $col)
		{
			array_push($headers, $col);
		}
		continue;
	}

	$tmp = [];
	for ($index = 0; $index < count($headers); $index++)
	{
		$tmp[$headers[$index]] = $row_data[$index];
	}
	array_push($data, $tmp);
}

fclose($handle);

class MC_TCPDF extends TCPDF 
{
// Load data
function LoadData($file)
{
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(',',trim($line));
    return $data;
}

function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(30,12,$col,1,0);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        $country = array_slice($row, 1, 1, true);

			foreach($row as $col) 
				$this->Cell(35,20,$col,1,0,'C');
				$x = $this->GetX();
				$y = $this->GetY();

			foreach($country as $baqrcode)
					$brstyle = array(
						'position' => '',
						'align' => 'C',
						'stretch' => false,
						'fitwidth' => true,
						'cellfitalign' => '',
						'border' => true,
						'hpadding' => 'auto',
						'vpadding' => 'auto',
						'fgcolor' => array(0,0,0),
						'bgcolor' => array(255,255,64),
						'text' => true,
						'font' => 'helvetica',
						'fontsize' => 6,
						'stretchtext' => 3);

					$qrstyle = array(
                        'position' => '',
                        'align' => '',
                        'stretch' => true,
                        'fitwidth' => false,
                        'cellfitalign' => '',
                        'border' => true,
                        'hpadding' => 'auto',
                        'vpadding' => 'auto',
                        'fgcolor' => array(0,0,128),
                        'bgcolor' => array(255,255,128),
                        'text' => true,
                        'label' => 'CUSTOM LABEL',
                        'font' => 'helvetica',
                        'fontsize' => 6,
                        'stretchtext' => 3
					);
					$this->write1DBarcode($baqrcode, 'C93', '', '', 35, 20, 0.4, $brstyle, '');
					$this->write2DBarcode($baqrcode, 'QRCODE, M', $x+43, $y, 20, 20, $qrstyle);
					$this->Ln();
		}
		
	}
    }

$pdf = new MC_TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$header = array('id', 'Country', 'Population', 'Bar Code', 'QR Code');
$data = $pdf->LoadData('countries.csv');
$pdf->SetFont('','',8);
$pdf->AddPage();
$pdf->BasicTable($header,$data);
$pdf->Output();
?>