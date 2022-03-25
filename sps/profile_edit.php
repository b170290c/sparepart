<?php
	include 'includes/session.php';

	//$conn = $pdo->open();

	if(isset($_POST['edit'])){
		$curr_password = $_POST['curr_password'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		// $plant = $_POST['plant'];
		// $line = $_POST['line'];
		$photo = $_FILES['photo']['name'];
		if(password_verify($curr_password, $user['password'])){
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], 'images/'.$photo);
				$filename = $photo;	
			}
			else{
				$filename = $user['photo'];
			}

			if($password == $user['password']){
				$password = $user['password'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			try{

				$sql = " UPDATE sps.users1 SET username='".$username."', password='".$password."', firstname='".$firstname."', lastname='".$lastname."',  photo='".$filename."' WHERE id='".$user['id']."' ";
				$stmt = sqlsrv_query($conn , $sql);




				// $stmt = $conn->prepare("UPDATE users1 SET username=:username, password=:password, firstname=:firstname, lastname=:lastname,  photo=:photo WHERE id=:id");
				// $stmt->execute(['username'=>$username, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname,  'photo'=>$filename, 'id'=>$user['id']]);

				$_SESSION['success'] = 'Account updated successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	//$pdo->close();
	 sqlsrv_free_stmt($stmt);
     sqlsrv_close($conn);

	header('location: profile.php');

?>