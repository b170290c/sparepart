<?php include 'includes/session.php';
include 'includes/header.php';
?>
<head>
<script type="text/javascript" src="js/jquery-3.5.1"></script>


</head>
<body>
<?php

$empName = $_POST['eName'];
$empID = $_POST['eID'];
$detailid = $_POST['dID'];
$itemRec = $_POST['itemrec'];

$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');



	

//$conn = $pdo->open();



	$code = 1;





try{
				// $stmt = $conn->prepare("UPDATE details SET itemRec=:itemrec, empName=:eName, empID=:eID, dates=:time WHERE detailid=:detailid");
				// $stmt->execute(['itemrec'=>$code, 'eName'=>$empName, 'eID'=>$empID, 'time'=>$date, 'detailid'=>$detailid]);

	$sql = " UPDATE sps.details SET itemRec='".$code."', empName='".$empName."', empID='".$empID."', dates='".$date."' WHERE detailid='".$detailid."' ";
	$stmt = sqlsrv_query($conn,$sql);

			
			}


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		//$pdo->close();



 header("location:sales.php");

?>