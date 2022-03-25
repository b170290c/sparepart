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
$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');
$date1 = date('l jS \of F Y h:i A');

//$conn = $pdo->open();



	$int = 1;






try{

	$sql = " UPDATE sps.rdetails SET retstat= '".$int."' , time='".$date."' ";
	$stmt = sqlsrv_query($conn , $sql);
				// $stmt = $conn->prepare("UPDATE rdetails SET retstat=:retstat, time=:time WHERE detailid=:detailid");
				// $stmt->execute(['retstat'=>$int, 'detailid'=>$detailid, 'time'=>$date]);
				

		
				}
			
			
		


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}





 					 sqlsrv_free_stmt($stmt);
                      sqlsrv_close($conn);

		//$pdo->close();

echo '<script type="text/javascript">'; 
echo 'alert("Ping Admin Successfully on '.$date1.'!");';
echo 'window.location.href = "item_ret.php";';
echo '</script>';


?>