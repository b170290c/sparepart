<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT * FROM line WHERE id=:id");
		// $stmt->execute(['id'=>$id]);
		// $row = $stmt->fetch();
		
		// $pdo->close();

		$sql = " SELECT * FROM sps.line WHERE id='".$id."' ";
		$stmt = sqlsrv_query($conn , $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		echo json_encode($row);
	}
?>