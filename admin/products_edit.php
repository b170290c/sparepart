<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		$slug = slugify($name);
		$category = $_POST['category'];
		$vendor = $_POST['vendor'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$recdate = $_POST['recdate'];
		$idLoc = $_POST['idLoc'];
		$noSAP = $_POST['noSAP'];
		$noParts = $_POST['noParts'];
		
		$qnty = $_POST['qnty'];
		$minqnty = $_POST['minqnty'];
		$minqnty1 = $_POST['minqnty1'];
		$roq = $_POST['roq'];
		$leadtime = $_POST['leadtime'];

// echo $qnty; echo '<br>'; echo $minqnty; echo '<br>'; echo $minqnty1; 

		//$conn = $pdo->open();

			// $stmt = $conn->prepare("UPDATE products SET name=:name, slug=:slug, category_id=:category, vendor_id=:vendor,  price=:price, description=:description, recdate=:recdate, idLoc=:idLoc, noSAP=:noSAP, noParts=:noParts, noSerial=:noSerial, qnty=:qnty, minqnty=:minqnty, mls=:minqnty1, roq=:roq, leadtime=:leadtime WHERE id=:id");
			// $stmt->execute(['name'=>$name, 'slug'=>$slug, 'category'=>$category, 'vendor'=>$vendor,  'price'=>$price, 'description'=>$description, 'recdate'=>$recdate, 'idLoc'=>$idLoc, 'noSAP'=>$noSAP, 'noParts'=>$noParts, 'noSerial'=>$noSerial, 'qnty'=>$qnty, 'minqnty'=>$minqnty, 'minqnty1'=>$minqnty1, 'roq'=>$roq, 'leadtime'=>$leadtime, 'id'=>$id]);

			$sql = " UPDATE sps.products SET name='".$name."' , slug='".$slug."' , category_id='".$category."', vendor_id='".$vendor."',  price='".$price."', description='".$description."' , recdate='".$recdate."', idLoc='".$idLoc."', noSAP='".$noSAP."', noParts='".$noParts."',  qnty='".$qnty."', minqnty='".$minqnty."', mls='".$minqnty1."', roq='".$roq."', leadtime='".$leadtime."' WHERE id='".$id."' ";

			echo $sql;
			
			$stmt = sqlsrv_query($conn , $sql);




			$_SESSION['success'] = 'Product updated successfully';
		
		
		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit product form first';
	}

	header('location: products.php');

?>