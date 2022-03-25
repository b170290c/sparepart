<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		//$conn = $pdo->open();

		try{
			// $stmt = $conn->prepare("DELETE FROM vendor WHERE id=:id");
			// $stmt->execute(['id'=>$id]);

			$sql = " DELETE FROM sps.vendor WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);

			$_SESSION['success'] = 'Vendor deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select vendor to delete first';
	}

	header('location: vendor.php');
	
?>