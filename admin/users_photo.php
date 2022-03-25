<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$filename = $_FILES['photo']['name'];
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		
		//$conn = $pdo->open();

		try{
			// $stmt = $conn->prepare("UPDATE users1 SET photo=:photo WHERE id=:id");
			// $stmt->execute(['photo'=>$filename, 'id'=>$id]);
			$sql = " UPDATE sps.users1 SET photo='".$filename."' WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn, $sql);


			$_SESSION['success'] = 'User photo updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		//$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select user to update photo first';
	}

	header('location: users.php');
?>