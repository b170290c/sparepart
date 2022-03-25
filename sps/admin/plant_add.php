
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM plant WHERE name=:name");
		// $stmt->execute(['name'=>$name]);
		// $row = $stmt->fetch();

		$sql = " SELECT *, COUNT(*) AS numrows FROM sps.plant WHERE name='".$name."' GROUP BY id,name ";
		 $stmt = sqlsrv_query( $conn, $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Plant already exist';
		}
		else{
			try{
				// $stmt = $conn->prepare("INSERT INTO plant (name) VALUES (:name)");
				// $stmt->execute(['name'=>$name]);
				$sql1 = " INSERT INTO sps.plant ([name]) VALUES ('".$name."') ";
				$stmt = sqlsrv_query( $conn, $sql1);


				$_SESSION['success'] = 'Plant added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up plant form first';
	}

	header('location: plant.php');

?>