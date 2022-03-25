<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$id = $_POST['id'];
		$filename = $_FILES['photo']['name'];

		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
		// $stmt->execute(['id'=>$id]);
		// $row = $stmt->fetch();

		$sql = " SELECT * FROM sps.products WHERE id='".$id."' ";
		$stmt = ($conn , $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		if(!empty($filename)){
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			$new_filename = $row['slug'].'_'.time().'.'.$ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
		}
		
		try{
			// $stmt = $conn->prepare("UPDATE products SET photo=:photo WHERE id=:id");
			// $stmt->execute(['photo'=>$new_filename, 'id'=>$id]);
			$sql = " UPDATE sps.products SET photo='".$new_filename."' WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn , $sql);


			$_SESSION['success'] = 'Product photo updated successfully';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		//$pdo->close();

	}
	else{
		$_SESSION['error'] = 'Select product to update photo first';
	}

	header('location: products.php');
?>