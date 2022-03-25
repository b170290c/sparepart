<?php

	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$qnty = $_POST['qnty'];
		$ownqnty = $_POST['ownqnty'];
		$qnty1 = $_POST['qnty1'];



		//$conn = $pdo->open();

		$newqnty = $qnty + $qnty1;
		$ownqnty1 = $ownqnty + $qnty1;


		try{
			//echo $newqnty;
			$sql = " UPDATE sps.products SET qnty='".$newqnty."' , ownqnty='".$ownqnty1."' , recdate = GETDATE() WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);

			// $stmt = $conn->prepare("UPDATE products SET qnty=:qnty, ownqnty=:ownqnty, recdate=now() WHERE id=:id");
			// $stmt->execute(['qnty'=>$newqnty, 'ownqnty'=>$ownqnty1, 'id'=>$id]);
			$_SESSION['success'] = 'Quantity updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up the quantity first';
	}

	header('location: lowstock.php');

?>