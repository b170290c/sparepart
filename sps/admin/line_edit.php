<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];

		try{
			// $stmt = $conn->prepare("UPDATE line SET name=:name WHERE id=:id");
			// $stmt->execute(['name'=>$name, 'id'=>$id]);
			$sql = " UPDATE sps.line SET name='".$name."' WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);
			$_SESSION['success'] = 'Line updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit line form first';
	}

	header('location: line.php');

?>