


   <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<script type="text/javascript" src="../DataTables/DataTables-1.10.23/js"></script>
  <meta charset="utf-8">
    <title>Stock Out By Line</title>

 

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
$this->Cell(71 ,5,strtoupper('Stock Out Report By Line'),0,0,'R');

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



$pdf = new PDF('P','mm','A4');
// $pdf -> Ln(3);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(false);
//set width for each column (6 columns)
$pdf->SetWidths(Array(10,25,20,20,35,30));

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
$pdf->Cell(25,5,"Line",1,0);
$pdf->Cell(20,5,"Quantity",1,0);
$pdf->Cell(20,5,"Total Cost",1,0);
$pdf->Cell(35,5,"Currency",1,0);
$pdf->Cell(30,5,"PIC",1,0);


$pdf->Ln();


$start = $_GET['var1'];
$end = $_GET['var2'];
$reportid = $_GET['var3'];

//reset font
$pdf->SetFont('Helvetica','',10);


$servername = "localhost";
$username = "root";
$password = "root";

try {
  $conn = new PDO("mysql:host=$servername;dbname=sps", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}


try{

 $query="SELECT  users1.line as uline, sales.sales_date, Sum(details.qtyok) as quantity, Sum(products.price*details.qtyok) AS total, users1.firstname as firstname , users1.lastname as lastname FROM details  JOIN products ON details.product_id=products.id  JOIN sales ON sales.id=details.sales_id  JOIN users1 ON users1.id=sales.user_id WHERE sales.sales_date BETWEEN '$start' AND  '$end' AND details.detail_status=1  GROUP BY users1.line";




$id=1;

 foreach ($conn->query($query) as $item) {
   

      $fullname = $item['firstname'].' '.$item['lastname'];
      $currency = "Malaysian Ringgit (RM)";
    


$pdf->Row(Array(

        $id, 
        $item['uline'],
        $item['quantity'],
        number_format($item['total'],2),
        $currency,
        $fullname, 

 

    ));

 $id++;


}

}

catch(PDOException $e){
                      echo $e->getMessage();
                    }





$pdf->Output();
?>


