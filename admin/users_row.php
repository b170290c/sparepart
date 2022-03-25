<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		//$conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT * FROM users1 WHERE id=:id");
		// $stmt->execute(['id'=>$id]);
		// $row = $stmt->fetch();
		
		// $pdo->close();

		 $sql = " SELECT * FROM sps.users1 WHERE id = '".$id."' ";
        
         $stmt = sqlsrv_query( $conn, $sql  );
         $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);



		echo json_encode($row);
	}
?>