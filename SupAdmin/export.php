   <?php include 'session.php';  ?>
   <?php include 'conn.php'; ?>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">   
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<script type="text/javascript" src="../DataTables/DataTables-1.10.23/js"></script>
  <meta charset="utf-8">
    <title>Celestica's Spare Part</title>

 

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
$this->Cell(71 ,5,strtoupper($_POST['report_id']),0,0);

$this->SetFont('Arial','I',12);
$this->Cell(80 ,5,date('d-m-Y', strtotime($_POST['startdate'])),0,0,'R');

$this->SetFont('Arial','B',14);
$this->Cell(8 ,5,'TO ' ,0,0);

$this->SetFont('Arial','I',12);
$this->Cell(10 ,5,date('d-m-Y', strtotime($_POST['enddate'])),0,1);

 parent::Header();

    $this->Ln(8);


}




// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);



    // Arial italic 8
    $this->SetFont('Arial','I',8);
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
$pdf->SetWidths(Array(8,40,30,40,55,20));

//set alignment
//$pdf->SetAligns(Array('','R','C','','',''));



//load json data
$json = file_get_contents('../fpdf/MOCK_DATA.json');
$data = json_decode($json,true);

//add table heading using standard cells
$pdf->SetFont('Helvetica','',12);
$pdf->SetFillColor(235,236,236);


//set font to bold
$pdf->SetFont('Arial','B',12);
$pdf->Cell(8,5,"#",1,0);
$pdf->Cell(40,5,"Emp Info",1,0);
$pdf->Cell(30,5,"Status",1,0);
$pdf->Cell(40,5,"Product Name",1,0);
$pdf->Cell(55,5,"Product Info",1,0);
$pdf->Cell(20,5,"Quantity",1,0);




$pdf->Ln();



//reset font
$pdf->SetFont('Helvetica','',10);


$start1 = $_POST['startdate'];
$end1 = $_POST['enddate'];

$start = $start1.' 00:00:00';
$end = $end1.' 23:59:59';

if($_POST['report_id'] == 'stock in') {

  $reportid = $_POST['report_id'];
  


header('Location: stockinpdf.php?var1='.$start.'&var2='.$end.'&var3='.$reportid);
}




elseif($_POST['report_id'] == 'stock out' ){




   $reportid = $_POST['report_id'];
  


header('Location: stockoutpdf.php?var1='.$start.'&var2='.$end.'&var3='.$reportid);
}




elseif($_POST['report_id'] == 'rejected parts' ){





try {



//dquery conn
 $query="SELECT * FROM details INNER JOIN products ON products.id=details.product_id
 INNER JOIN sales on details.sales_id=sales.id
 INNER JOIN users1 ON users1.id=sales.user_id
 WHERE sales_date BETWEEN '$start' AND '$end' AND detail_status = 2
 ORDER BY sales_date DESC";




$id=1;

 foreach ($conn->query($query) as $item) {
     $statusCode = $item['detail_status'];

    if($statusCode == 2){
        $statusCode= "Rejected";
    }


    $total = $item['price']*$item['qtyok'];

$pdf->Row(Array(

  $id,
'Requested Date:'.chr(10).date('d-m-Y H:i ', strtotime($item['sales_date'])).
  chr(10).'Requester Info:'.chr(10).$item['firstname'] .' '. $item['lastname'].chr(10).'('.$item['empid'].')',

  $statusCode.' '.
   'Collected By:'.chr(10).$item['empName'].chr(10).'('.$item['empID'].')' ,
  strtoupper($item['name']),
 'ID Location: '.chr(10).$item['idLoc'].
 chr(10).'SAP#: '.chr(10).$item['noSAP'].
  chr(10).'Serial#: '.$item['noSerial'].
  chr(10).'Receive Date: '.date('d-m-y', strtotime($item['recdate'])).
  chr(10).'Price: RM '. $item['price'].
  chr(10).'Subtotal: RM '. $total,

          '      '.$item['qtyok'],

    ));

 $id++;


}
}
catch(PDOException $e){
                      echo $e->getMessage();
                    }

}



elseif($_POST['report_id'] == 'all order history') {






try {




//dquery conn
 $query="SELECT * FROM details INNER JOIN products ON products.id=details.product_id
 INNER JOIN sales on details.sales_id=sales.id
 INNER JOIN users1 ON users1.id=sales.user_id
 WHERE sales_date BETWEEN '$start' AND '$end'
 ORDER BY sales_date DESC";




$id=1;

 foreach ($conn->query($query) as $item) {
     $statusCode = $item['detail_status'];
        if($statusCode == 1){
        $statusCode = "Approved";
    }
    elseif($statusCode == 2){
        $statusCode= "Rejected";
    }
    elseif($statusCode == 3){
        $statusCode= "Item Returned";
    }
     elseif($statusCode == 0){
        $statusCode= "Pending Request";
    }

    $total = $item['price']*$item['qtyok'];


$pdf->Row(Array(

  $id,
 'Requested Date:'.chr(10).date('d-m-Y H:i ', strtotime($item['sales_date'])).
  chr(10).'Requester Info:'.chr(10).$item['firstname'] .' '. $item['lastname'].chr(10).'('.$item['empid'].')' ,

  $statusCode.' '.
   'Collected By:'.chr(10).$item['empName'].chr(10).'('.$item['empID'].')' ,
  strtoupper($item['name']),
 'ID Location: '.$item['idLoc'].
 chr(10).'SAP#: '.$item['noSAP'].
  chr(10).'Serial#: '.$item['noSerial'].
  chr(10).'Receive Date: '.date('d-m-y', strtotime($item['recdate'])).
  chr(10).'Price: RM '. $item['price'].
  chr(10).'Subtotal: RM '. $total,

          '      '.$item['qtyok'],

    ));






 $id++;

}
}

catch(PDOException $e){
                      echo $e->getMessage();
                    }

}




elseif($_POST['report_id'] == 'summary') {

  $reportid = $_POST['report_id'];
  


header('Location: summarypdf.php?var1='.$start.'&var2='.$end.'&var3='.$reportid);
}

// try {




// //dquery conn
//  $query="SELECT * FROM details INNER JOIN products ON products.id=details.product_id
//  INNER JOIN sales on details.sales_id=sales.id
//  INNER JOIN users1 ON users1.id=sales.user_id
//  WHERE sales_date BETWEEN '$start' AND '$end' AND detail_status= 1
//  ORDER BY sales_date DESC";




// $id=1;

//  foreach ($conn->query($query) as $item) {
//      $statusCode = $item['detail_status'];
//         if($statusCode == 1){
//         $statusCode = "Approved";
//     }
//     elseif($statusCode == 2){
//         $statusCode= "Rejected";
//     }
//     elseif($statusCode == 3){
//         $statusCode= "Item Returned";
//     }
//      elseif($statusCode == 0){
//         $statusCode= "Pending Request";
//     }

//     $total = $item['price']*$item['quantity'];


// $pdf->Row(Array(

//   $id,
//  'Requested Date:'.chr(10).date('d-m-Y H:i ', strtotime($item['sales_date'])).
//   chr(10).'Requester Info:'.chr(10).$item['firstname'] .' '. $item['lastname'].chr(10).'('.$item['empid'].')' ,

//   $statusCode.' '.
//    'Collected By:'.chr(10).$item['empName'].chr(10).'('.$item['empID'].')' ,
//   strtoupper($item['name']),
//  'ID Location: '.$item['idLoc'].
//  chr(10).'SAP#: '.$item['noSAP'].
//   chr(10).'Serial#: '.$item['noSerial'].
//   chr(10).'Receive Date: '.date('d-m-y', strtotime($item['recdate'])).
//   chr(10).'Price: RM '. $item['price'].
//   chr(10).'Subtotal: RM '. $total,

//           '      '.$item['quantity'],

//     ));






//  $id++;

// }
// }

// catch(PDOException $e){
//                       echo $e->getMessage();
//                     }









// elseif($_POST['report_id'] == 'returned parts' ){





// try {



// //dquery conn
//  $query="SELECT * FROM details INNER JOIN products ON products.id=details.product_id
//  LEFT JOIN sales on details.sales_id=sales.id
//  LEFT JOIN users1 ON users1.id=sales.user_id
//  WHERE sales_date BETWEEN '$start' AND '$end' AND detail_status = 3
//  ORDER BY sales_date DESC";




// $id=1;

//  foreach ($conn->query($query) as $item) {
//      $statusCode = $item['detail_status'];
//         if($statusCode == 1){
//         $statusCode = "Accepted";
//     }
//     elseif($statusCode == 2){
//         $statusCode= "Rejected";
//     }
//     elseif($statusCode == 3){
//         $statusCode= "Item Returned";
//     }
//      elseif($statusCode == 0){
//         $statusCode= "Pending Request";
//     }

//     $total = $item['price']*$item['quantity'];

// $pdf->Row(Array(

//   $id,
// 'Requested Date:'.chr(10).date('d-m-Y H:i ', strtotime($item['sales_date'])).
//   chr(10).'Requester Info:'.chr(10).$item['firstname'] .' '. $item['lastname'].chr(10).'('.$item['empid'].')',
//   $statusCode.' '.
//    'Collected By:'.chr(10).$item['empName'].chr(10).'('.$item['empID'].')' ,
//   strtoupper($item['name']),
//  'ID Location: '.chr(10).$item['idLoc'].
//  chr(10).'SAP#: '.chr(10).$item['noSAP'].
//   chr(10).'Serial#: '.$item['noSerial'].
//   chr(10).'Receive Date: '.date('d-m-y', strtotime($item['recdate'])).
//   chr(10).'Price: RM '. $item['price'].
//   chr(10).'Subtotal: RM '. $total,

//           '      '.$item['quantity'],
//     ));

//  $id++;


// }
// }
// catch(PDOException $e){
//                       echo $e->getMessage();
//                     }

// }



$pdf->Output();
?>
