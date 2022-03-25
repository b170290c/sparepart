<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		//$conn = $pdo->open();

		try{
			// $stmt = $conn->prepare("DELETE FROM plant WHERE id=:id");
			// $stmt->execute(['id'=>$id]);

			$sql = " DELETE FROM sps.plant WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);

			$_SESSION['success'] = 'Plant deleted successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Select plant to delete first';
	}

	header('location: plant.php');
	
?>