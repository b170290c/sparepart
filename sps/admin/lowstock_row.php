<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		//$conn = $pdo->open();

		//$stmt = $conn->prepare("SELECT *, products.id AS prodid, products.name AS prodname, category.name AS catname FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id WHERE products.id=:id");
		//$stmt->execute(['id'=>$id]);
		//$row = $stmt->fetch();
		
		//$pdo->close();
		
		$sql = " SELECT *, products.id AS prodid, products.name AS prodname, category.name AS catname FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id WHERE products.id= '".$id."' ";
		$stmt = sqlsrv_query($conn , $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		echo json_encode($row);
	}
?>