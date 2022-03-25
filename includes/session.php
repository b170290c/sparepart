<?php
	include 'includes/conn1.php';
	session_start();

	if(isset($_SESSION['admin'])){
		header('location: admin/home.php');
	}

	if(isset($_SESSION['user'])){
	//	$conn = $pdo->open();

	

			$sql = "SELECT * FROM sps.users1 WHERE id='".$_SESSION['user']."' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

			$stmt = sqlsrv_query( $conn, $sql , $params, $options );


			$user = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

			// $stmt = $conn->prepare("SELECT * FROM users1 WHERE id=:id");
			// $stmt->execute(['id'=>$_SESSION['user']]);
			// $user = $stmt->fetch();


	

	//	$pdo->close();
	}
?>