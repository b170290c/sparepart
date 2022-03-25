
<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];

		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM category WHERE name=:name");
		// $stmt->execute(['name'=>$name]);
		// $row = $stmt->fetch();

		$sql = " SELECT *, COUNT(*) AS numrows FROM sps.category WHERE name='".$name."' GROUP BY id,name ";
		$params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 

		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Category already exist';
		}
		else{
			try{
				// $stmt = $conn->prepare("INSERT INTO category (name) VALUES (:name)");
				// $stmt->execute(['name'=>$name]);

				$sql = " INSERT INTO sps.category ([name]) VALUES ('$name') ";
				$stmt = sqlsrv_query($conn , $sql);
				$_SESSION['success'] = 'Category added successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up category form first';
	}

	header('location: category.php');

?>