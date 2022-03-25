
<?php include 'conn.php';  ?>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<script type="text/javascript" src="../DataTables/DataTables-1.10.23/js"></script>
  <meta charset="utf-8">
    <title>Summary Order History</title>

 

<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php

require('../fpdf/fpdf.php');


class PDF extends FPDF
{


// Page header
function Header()
{
    // Logo
    $this->Image('../assets/img/favicon.png',10,6,30);
    $this->Ln(15);

/*set font to arial, bold, 14pt*/
$this->SetFont('Arial','B',20);

/*Cell(width , height , text , border , end line , [align] )*/
$this->Cell(40 ,10,'',0,0);
$this->Cell(40 ,10,'CELESTICA ELECTRONICS SDN BHD',0,1);

$this->Cell(59,10,'',0,0);
$this->SetFont('Arial','B',17);
$this->Cell(30 ,10,'     Spare Part Order History',0,1);
$this->Ln(10);

$this->SetFont('Arial','B',12);
$this->Cell(71 ,5,strtoupper('Usage Report'),0,0,'R');

$this->SetFont('Arial','I',12);
$this->Cell(80 ,5,date('d-m-Y', strtotime( $_GET['var1'])),0,0,'R');

$this->SetFont('Arial','B',14);
$this->Cell(8 ,5,'TO ' ,0,0);

$this->SetFont('Arial','I',12);
$this->Cell(10 ,5,date('d-m-Y', strtotime( $_GET['var2'])),0,1);

 parent::Header();

    $this->Ln(8);


}




// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);



    // Arial italic 8
    $this->SetFont('Arial','I',9);
    // Page number
    $this->Write(12,'Think Bigger, Reach Further',0,0,'R');
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');

}
}


$pdf = new PDF('L','mm','A4');
// $pdf -> Ln(3);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
//set width for each column (6 columns)
$pdf->SetWidths(Array(10,25,20,20,20,50,20,15,15,25,30,30));

//set alignment
//$pdf->SetAligns(Array('','R','C','','',''));



//load json data
$json = file_get_contents('../fpdf/MOCK_DATA.json');
$data = json_decode($json,true);

//add table heading using standard cells
$pdf->SetFont('Helvetica','',10);
$pdf->SetFillColor(235,236,236);


//set font to bold
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,5,"#",1,0);
$pdf->Cell(25,5,"S/N",1,0);
$pdf->Cell(20,5,"SAP",1,0);
$pdf->Cell(20,5,"Part No.",1,0);
$pdf->Cell(20,5,"Brand",1,0);
$pdf->Cell(50,5,"Part Description",1,0);
$pdf->Cell(20,5,"Date",1,0);
$pdf->Cell(15,5,"Line",1,0);
$pdf->Cell(15,5,"Quantity",1,0);
$pdf->Cell(25,5,"Cost",1,0);
$pdf->Cell(30,5,"Total Cost",1,0);
$pdf->Cell(30,5,"Currency",1,0);



$pdf->Ln();


$start = $_GET['var1'];
$end = $_GET['var2'];
$reportid = $_GET['var3'];

//reset font
$pdf->SetFont('Helvetica','',10);

try{

 $query="SELECT *, category.name AS catname, products.name AS prodname  FROM details JOIN products ON products.id=details.product_id JOIN category ON category.id=products.category_id
  JOIN sales on details.sales_id=sales.id
  JOIN users1 ON users1.id=sales.user_id
  WHERE sales_date BETWEEN '$start' AND  '$end'  AND detail_status = 1
  ORDER BY sales_date DESC";




$id=1;

 foreach ($conn->query($query) as $item) {
     $statusCode = $item['detail_status'];
        if($statusCode == 1){
        $statusCode = "Approved";
    }


    $total = $item['price']*$item['qtyok'];
    $currency = "Malaysian Ringgit (MYR)" ;

$pdf->Row(Array(

        $id,
        $item['noSerial'],
        $item['noSAP'],
        $item['noParts'],
        $item['catname'],
        $item['prodname'],
        date('d.M.y', strtotime($item['sales_date'])),
        $item['line'],
        $item['qtyok'],
        $item['price'],
        $total,
        $currency,

 


    ));

 $id++;
}

}

catch(PDOException $e){
                      echo $e->getMessage();
                    }





$pdf->Output();
?>