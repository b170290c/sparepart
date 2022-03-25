
<?php include 'includes/session.php';  ?>
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
$this->Cell(71 ,5,strtoupper('Scrap Report'),0,0,'R');

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
$pdf->SetWidths(Array(10,20,20,20,50,20,15,15,25,25,30));

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

$pdf->Cell(20,5,"SAP",1,0);
$pdf->Cell(20,5,"Part No.",1,0);
$pdf->Cell(20,5,"Brand",1,0);
$pdf->Cell(50,5,"Part Description",1,0);
$pdf->Cell(20,5,"Date",1,0);
$pdf->Cell(15,5,"Line",1,0);
$pdf->Cell(15,5,"Quantity",1,0);
$pdf->Cell(25,5,"Cost",1,0);
$pdf->Cell(25,5,"Total Cost",1,0);
$pdf->Cell(30,5,"Currency",1,0);



$pdf->Ln();


$start1 = $_GET['var1'];
$end1 = $_GET['var2'];
$reportid = $_GET['var3'];
 $start = $start1.' 00:00:00';
$end = $end1.' 23:59:59';
//reset font
$pdf->SetFont('Helvetica','',10);

try{

 $query="SELECT p.name as prodname, r.badqty as quantity, p.price as price,  u.line as line , r.time as date, p.noSerial as noSerial, p.noSAP as noSAP , p.noParts as noParts, c.name AS brand  FROM sps.rdetails r LEFT JOIN sps.sales s ON s.id=r.sales_id LEFT JOIN sps.users1 u ON u.id=s.user_id LEFT JOIN sps.products p ON p.id=r.product_id LEFT JOIN sps.category c ON c.id=p.category_id WHERE r.time BETWEEN '$start' AND '$end' AND r.retstat=3 AND r.badqty<>3   ORDER BY r.time DESC";

 $params = array();
 $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
 $stmt = sqlsrv_query( $conn, $query , $params, $options ); 




$id=1;

 while($item = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
     $statusCode = $item['detail_status'];
        if($statusCode == 1){
        $statusCode = "Approved";
    }


    $total = $item['price']*$item['quantity'];
    $currency = "Malaysian Ringgit (MYR)" ;

$pdf->Row(Array(

        $id,
        
        $item['noSAP'],
        $item['noParts'],
        $item['brand'],
        $item['prodname'],
        $item['date']->format("d/M/y"),
        $item['line'],
        $item['quantity'],
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