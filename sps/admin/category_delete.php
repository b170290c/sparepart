<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];

	
		
		//$conn = $pdo->open();

		
			// $stmt = $conn->prepare("DELETE FROM category WHERE id=:id");
			// $stmt->execute(['id'=>$id]);

			$sql = " DELETE FROM sps.category WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);

			$_SESSION['success'] = 'Brand deleted successfully';
		
		}

		//$pdo->close();
	
	else{
		$_SESSION['error'] = 'Select brand to delete first';
	}

	header('location: category.php');
	
?>