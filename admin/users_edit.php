<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$empid = $_POST['empid'];
		$plant = $_POST['plant'];
		$line = $_POST['line'];
		$type = $_POST['type'];

		// $conn = $pdo->open();
		// $stmt = $conn->prepare("SELECT * FROM users1 WHERE id=:id");
		// $stmt->execute(['id'=>$id]);
		// $row = $stmt->fetch();

		$sql = " SELECT * FROM sps.users1 WHERE id='".$id."' ";
		$stmt = sqlsrv_query( $conn, $sql);
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		if($password == $row['password']){
			$password = $row['password'];
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
		}

		try{
			// $stmt = $conn->prepare("UPDATE users1 SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, empid=:empid, plant=:plant, line=:line, type=:type WHERE id=:id");
			// $stmt->execute(['username'=>$username, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'empid'=>$empid, 'plant'=>$plant, 'line'=>$line, 'type'=>$type, 'id'=>$id]);
			$sql = " UPDATE sps.users1 SET username='".$username."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."', empid='".$empid."', plant='".$plant."', line='".$line."', type='".$type."' WHERE id='".$id."' ";
			$stmt = sqlsrv_query($conn,$sql);


			$_SESSION['success'] = 'User updated successfully';

		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up edit user form first';
	}

	header('location: users.php');

?>