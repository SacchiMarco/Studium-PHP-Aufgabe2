<?php 
require_once("fpdf.php");
class pdf extends FPDF
{
	protected $seitentitel;
	
	public function setSeitentitel($text = "Online-Shop")
	{
		$this->seitentitel = $text;
	}
	
	public function Header()
	{
		$this->SetFont("arial", "B",15);
		$this->Cell(80);
		$this->Image("baumbluete.jpg",10,5,20,15);
		$this->Cell(30,10,$this->seitentitel,0,0,"C");
		$this->Line(5,23,205,23);
		$this->Ln(20);
	}
	public function Footer()
	{
    // Go to 1.5 cm from bottom
    $this->SetY(-15);
		$this->Line(5,280,205,280);
    // Select Arial italic 8
    $this->SetFont('Arial','b',8);
    // Print centered page number
    $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}
	
	
	public function setText($text,$marg)
	{
		$this->SetLeftMargin($marg); 
		$this->Write(5,iconv('UTF-8','ISO-8859-15',$text));
		$this->Ln();
	}
}

/*$pdf = new pdf("p","mm","a4");
$pdf->setSeitentitel("Dies ist die Kopfzeile");
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont("arial", "b",16);
$pdf->Cell(45,10,"PDF-Dokument mit Kopfzeile.");
$pdf->Output();*/
?>