
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM line WHERE name=:name");
		// $stmt->execute(['name'=>$name]);
		// $row = $stmt->fetch();

		$sql = " SELECT *, COUNT(*) AS numrows FROM sps.line WHERE name='".$name."' GROUP BY id,name ";
		 $stmt = sqlsrv_query( $conn, $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Line already exist';
		}
		else{
			try{
				// $stmt = $conn->prepare("INSERT INTO line (name) VALUES (:name)");
				// $stmt->execute(['name'=>$name]);

				$sql1 = " INSERT INTO sps.line ([name]) VALUES ('".$name."') ";
				$stmt = sqlsrv_query( $conn, $sql1);

				$_SESSION['success'] = 'Line added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up line form first';
	}

	header('location: line.php');

?>