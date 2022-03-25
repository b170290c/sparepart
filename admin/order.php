<?php
include 'includes/session.php';


$pid = $_POST['pID'];
$did = $_POST['dID'];
$sid = $_POST['sID'];
$order = $_POST['order'];
$blnc = $_POST['blnc'];
$blnc1 = $_POST['blnc1'];


$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');


// echo $blnc;

//$conn = $pdo->open();



	$code = 1;





try{
				  

	$sql = " UPDATE sps.ongoing SET quantity='".$blnc."' , orderstat='".$code."', dates='".$order."' WHERE detailid='".$did."' ";
		$stmt = sqlsrv_query($conn , $sql);

	


			
			}


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		


 header("location:ongoing.php");
 
 ?>





























?>