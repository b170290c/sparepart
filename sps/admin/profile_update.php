<?php
	include 'includes/session.php';

	if(isset($_GET['return'])){
		$return = $_GET['return'];
		
	}
	else{
		$return = 'home.php';
	}

	if(isset($_POST['save'])){
		$curr_password = $_POST['curr_password'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$photo = $_FILES['photo']['name'];
		if(password_verify($curr_password, $admin['password'])){
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo);
				$filename = $photo;	
			}
			else{
				$filename = $admin['photo'];
			}

			if($password == $admin['password']){
				$password = $admin['password'];
			}
			else{
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

		//	$conn = $pdo->open();

			try{
				// $stmt = $conn->prepare("UPDATE users1 SET username=:username, password=:password, firstname=:firstname, lastname=:lastname, photo=:photo WHERE id=:id");
				// $stmt->execute(['username'=>$username, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'photo'=>$filename, 'id'=>$admin['id']]);

				$sql = " UPDATE sps.users1 SET username='".$username."' , password='".$password."' , firstname='".$firstname."' , lastname='".$lastname."', photo='".$filename."' WHERE id='".$admin['id']."' ";
				$stmt = sqlsrv_query($conn , $sql);

				$_SESSION['success'] = 'Account updated successfully';
			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}

			//$pdo->close();
			
		}
		else{
			$_SESSION['error'] = 'Incorrect password';
		}
	}
	else{
		$_SESSION['error'] = 'Fill up required details first';
	}

	header('location:'.$return);

?>