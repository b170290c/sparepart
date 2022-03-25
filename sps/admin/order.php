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

$conn = $pdo->open();



	$code = 1;





try{
				  

					 	$stmt = $conn->prepare("UPDATE ongoing SET quantity=:quantity, orderstat=:orderstat , dates=:dates  WHERE detailid=:did");
						$stmt->execute(['quantity'=>$blnc, 'orderstat'=>$code, 'dates'=>$order, 'did'=>$did ]);

			
			}


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		$pdo->close();



 header("location:ongoing.php");
 
 ?>





























?>