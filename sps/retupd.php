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
$qnty = $_POST['qnty'];
$detailid = $_POST['dID'];
$retqty = $_POST['retqty'];
$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');

$newqnty = $qnty - $retqty;
// echo $detailid;
	

// $conn = $pdo->open();



	$int = 3;







try{

	$sql = "UPDATE sps.details SET detail_status='".$int."' WHERE detailid='".$detailid."' " ;
	$stmt = sqlsrv_query($conn , $sql);


				// $stmt = $conn->prepare("UPDATE details SET detail_status=:itemret WHERE detailid=:detailid");
				// $stmt->execute(['itemret'=>$int,  'detailid'=>$detailid]);


	$sql1 = " INSERT INTO sps.rdetails ([detailid], [sales_id], [product_id], [retqty], [time] ) VALUES ('".$detailid."', '".$sales_id."', '".$product_id."', '".$retqty."', '".$date."') ";
	$stmt1 = sqlsrv_query($conn , $sql1);

	//echo $sql1;
				

					 // $stmt = $conn->prepare("INSERT INTO rdetails (detailid, sales_id, product_id, retqty, time ) VALUES (:detailid, :sales_id, :product_id, :retqty, :time)");
					 // $stmt->execute(['detailid'=>$detailid, 'sales_id'=>$sales_id, 'product_id'=>$product_id,  'retqty'=>$retqty, 'time'=>$date]);
					
				}
			
			
		


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		// $pdo->close();
		 sqlsrv_free_stmt($stmt);
         sqlsrv_close($conn);



 header("location:item_ret.php");

?>