<?php
	include 'includes/session.php';

	if(isset($_SESSION['user'])){
		//$conn = $pdo->open();

		$sql = " SELECT * FROM sps.cart LEFT JOIN sps.products on products.id=cart.product_id WHERE user_id= '".$user['id']."' ";
		$stmt = sqlsrv_query($conn , $sql);

		//$stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products on products.id=cart.product_id WHERE user_id=:user_id");
		//$stmt->execute(['user_id'=>$user['id']]);

		$total = 0;

		while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
			
			$subtotal = $row['price'] * $row['quantity'];
			$total += $subtotal;
		}

		//$pdo->close();

		echo json_encode($total);
	}
?>