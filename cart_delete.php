<?php
	include 'includes/session.php';

	//$conn = $pdo->open();

	$output = array('error'=>false);
	$id = $_POST['id'];

	if(isset($_SESSION['user'])){
		try{

			$sql = " DELETE FROM sps.cart WHERE id= '".$id."' ";

		    $stmt = sqlsrv_query( $conn, $sql );

			// $stmt = $conn->prepare("DELETE FROM cart WHERE id=:id");
			// $stmt->execute(['id'=>$id]);
			$output['message'] = 'Deleted';
			
		}
		catch(PDOException $e){
			$output['message'] = $e->getMessage();
		}
	}
	else{
		foreach($_SESSION['cart'] as $key => $row){
			if($row['productid'] == $id){
				unset($_SESSION['cart'][$key]);
				$output['message'] = 'Deleted';
			}
		}
	}

	//$pdo->close();
	sqlsrv_free_stmt( $stmt);

	echo json_encode($output);

?>