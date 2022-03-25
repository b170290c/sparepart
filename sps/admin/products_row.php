<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		
		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, products.id AS prodid, products.name AS prodname, category.name AS catname, vendor.name AS vename FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id WHERE products.id=:id");
		// $stmt->execute(['id'=>$id]);
		// $row = $stmt->fetch();
		
		// $pdo->close();

		$sql = " SELECT *, products.id AS prodid, products.name AS prodname, category.name AS catname, vendor.name AS vename FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.vendor ON vendor.id= products.vendor_id WHERE products.id='".$id."' ";
		$params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $conn, $sql , $params, $options );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		echo json_encode($row);
	}
?>