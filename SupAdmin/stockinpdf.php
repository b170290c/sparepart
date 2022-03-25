
<?php include 'session.php';  ?>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<script type="text/javascript" src="../DataTables/DataTables-1.10.23/js"></script>
  <meta charset="utf-8">
     <title>Stock In History</title>

 

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
$this->Cell(71 ,5,strtoupper('Stock In Report'),0,0,'R');

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
$pdf->SetWidths(Array(10,17,18,20,15,15,29,20,15,15,15,20,15,15,20,23));

//set alignment
//$pdf->SetAligns(Array('','R','C','','',''));



//load json data
$json = file_get_contents('../fpdf/MOCK_DATA.json');
$data = json_decode($json,true);

//add table heading using standard cells
$pdf->SetFont('Arial','',9);
$pdf->SetFillColor(235,236,236);


//set font to bold
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,5,"#",1,0);
$pdf->Cell(17,5,"S/N",1,0);
$pdf->Cell(18,5,"SAP",1,0);
$pdf->Cell(20,5,"Part No.",1,0);
$pdf->Cell(15,5,"Vendor",1,0);
$pdf->Cell(15,5,"Brand",1,0);
$pdf->Cell(29,5,"Part Description",1,0);
$pdf->Cell(20,5,"Date In",1,0);
$pdf->Cell(15,5,"ROP",1,0);
$pdf->Cell(15,5,"MLS",1,0);
$pdf->Cell(15,5,"ROQ",1,0);
$pdf->Cell(20,5,"Lead Time",1,0);
$pdf->Cell(15,5,"Quantity",1,0);
$pdf->Cell(15,5,"Cost",1,0);
$pdf->Cell(20,5,"Total Cost",1,0);
$pdf->Cell(23,5,"Currency",1,0);



$pdf->Ln();


$start1 = $_GET['var1'];
$end1 = $_GET['var2'];
$reportid = $_GET['var3'];



$start = $start1.' 00:00:00';
$end = $end1.' 23:59:59';
//reset font
$pdf->SetFont('Helvetica','',10);

$servername = "localhost";
$username = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$servername;dbname=sps", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


try{

 $query="SELECT products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts, products.recdate AS recdate, products.minqnty AS ROP, products.mls AS MLS, products.roq AS ROQ, products.leadtime AS leadtime, products.qnty AS quantity, products.price as price, products.id AS prodid, products.name AS prodname, category.name AS catname, vendor.name AS vename FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id WHERE recdate BETWEEN '$start' AND '$end' ORDER BY recdate DESC";




$id=1;

 foreach ($conn->query($query) as $item) {
    $total = $item['price']*$item['quantity'];
    $total = number_format($total,2);
     $currency = "Malaysian Ringgit (MYR)" ;
    


    

$pdf->Row(Array(

    
   $id,
        $item['noSerial'],
        $item['noSAP'],
        $item['noParts'],
        $item['vename'],
        $item['catname'],
        
        $item['prodname'],
        date('d.M.y', strtotime($item['recdate'])),
        $item['ROP'],
        $item['MLS'],
        $item['ROQ'],
        $item['leadtime'],
        $item['quantity'],
        number_format($item['price'],2),
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