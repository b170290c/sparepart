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
		

				$sql = " INSERT INTO sps.products ([category_id], [vendor_id], [name], [description], [slug], [price], [photo],[counter], [qnty], [minqnty], [mls], [roq], [leadtime] , [recdate], [idLoc],  [noSAP], [noParts]) VALUES ('".$category."', '".$vendor."', '".$name."', '".$description."', '".$slug."', '".$price."', '".$new_filename."' , '0' ,  '".$qnty."', '".$qnty."' '".$minqnty."', '".$mls."', '".$roq."', '".$leadtime."' , '".$recdate."', '".$idLoc."',  '".$noSAP."', '".$noParts."') ";
echo $sql;

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

	//header('location: products.php');

?>