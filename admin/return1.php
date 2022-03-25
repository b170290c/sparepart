<?php include 'includes/session.php';
include 'includes/header.php';
?>
<head>
<script type="text/javascript" src="js/jquery-3.5.1"></script>


</head>
<body>
<?php
$product_id = $_POST['pID'];
$sales_id = $_POST['sID'];
$detailid = $_POST['dID'];
$qtyok = $_POST['qtyok'];
$quantity = $_POST['quantity'];
$retqty = $_POST['retqty'];

$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');





$qtyok1 = $qtyok - $retqty;
$quantity1 = $quantity - $retqty; 

// echo $qtyok1;
// echo '<br>';
// echo $quantity1;



if(isset($_POST['status']) == 'Collected'){

	$int = 2;


				$sql = " UPDATE sps.rdetails SET retstat='".$int."' , time='".$date."' WHERE detailid = '".$detailid."' ";
				$stmt = sqlsrv_query($conn , $sql);
				

				$sql = " UPDATE sps.details SET quantity= '".$quantity1."' , qtyok='".$qtyok1."' WHERE detailid='".$detailid."' ";
				$stmt = sqlsrv_query($conn , $sql);
				

				
	
}


if(isset($_POST['status']) == 'Received'){



	$int = 2;


				$sql = " UPDATE sps.rdetails SET retstat='".$int."' , time='".$date."' WHERE detailid = '".$detailid."' ";
				$stmt = sqlsrv_query($conn , $sql);

			
				
				$sql = " UPDATE sps.details SET quantity= '".$quantity1."' , qtyok='".$qtyok1."' WHERE detailid='".$detailid."' ";
				$stmt = sqlsrv_query($conn , $sql);

	
					
	

}

//$pdo->close();



 header("location:return.php");

?>