<?php
	include 'includes/session.php';
	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
		$slug = slugify($name);
		$category = $_POST['category'];
		$vendor = $_POST['vendor'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$filename = $_FILES['photo']['name'];
		$qnty = $_POST['qnty'];
		$minqnty = $_POST['minqnty'];
		$mls = $_POST['mls'];
		$roq = $_POST['roq'];
		$leadtime = $_POST['leadtime'];
		$recdate = $_POST['recdate'];
		$idLoc = $_POST['idLoc'];
		
		$noSAP = $_POST['noSAP'];
		$noParts = $_POST['noParts'];

		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE slug=:slug");
		// $stmt->execute(['slug'=>$slug]);
		// $row = $stmt->fetch();

		$sql = " SELECT *, COUNT(*) AS numrows FROM sps.products WHERE slug='".$slug."' GROUP BY id,category_id,vendor_id,name,description,slug,price,photo,date_view,counter,qnty,minqnty,mls,roq,ownqnty,leadtime,recdate,idloc,noSerial,noSAP,noParts ";
		$stmt = sqlsrv_query($conn , $sql);
	
	$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ;

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Product already exist';
		}
		else{
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$new_filename = $slug.'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}

			try{
				// $stmt = $conn->prepare("INSERT INTO products (category_id, vendor_id, name, description, slug, price, photo, recdate, idLoc, noSerial, noSAP, noParts, qnty, minqnty, mls, roq, leadtime) VALUES (:category, :vendor, :name, :description, :slug, :price, :photo, :recdate, :idLoc, :noSerial, :noSAP, :noParts, :qnty, :minqnty, :mls, :roq, :leadtime)");
				// $stmt->execute(['category'=>$category, 'vendor'=>$vendor, 'name'=>$name, 'description'=>$description, 'slug'=>$slug, 'price'=>$price, 'photo'=>$new_filename, 'recdate'=>$recdate, 'idLoc'=>$idLoc, 'noSerial'=>$noSerial, 'noSAP'=>$noSAP, 'noParts'=>$noParts, 'qnty'=>$qnty, 'minqnty'=>$minqnty, '$mls'=>$mls, 'roq'=>$roq, 'leadtime'=>$leadtime]);

				$sql = " INSERT INTO sps.products ([category_id], [vendor_id], [name], [description], [slug], [price], [photo], [recdate], [idLoc], [noSerial], [noSAP], [noParts], [qnty], [minqnty], [mls], [roq], [leadtime]) VALUES ('".$category."', '".$vendor."', '".$name."', :'".$description."', '".$slug."', '".$price."', '".$new_filename."' , '".$recdate."', '".$idLoc."',  '".$noSAP."', $'".$noParts."', '".$qnty."', '".$minqnty."', '".$mls."', '".$roq."', '".$leadtime."') ";
				$stmt = sqlsrv_query($conn , $sql);



				$_SESSION['success'] = 'Product added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up product form first';
	}

	header('location: products.php');

?>