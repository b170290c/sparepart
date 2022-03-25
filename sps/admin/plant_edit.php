<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];

		try{
			// $stmt = $conn->prepare("UPDATE plant SET name=:name WHERE id=:id");
			// $stmt->execute(['name'=>$name, 'id'=>$id]);

			$sql = " UPDATE sps.plant SET name='".$name."' WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);


			$_SESSION['success'] = 'Plant updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit plant form first';
	}

	header('location: plant.php');

?>