<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$empid = $_POST['empid'];
		$plant = $_POST['plant'];
		$line = $_POST['line'];
		$type = $_POST['type'];
		


		// $conn = $pdo->open();

		// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users1 WHERE (username=:username OR empid=:empid)");
		// $stmt->execute(['username'=>$username , 'empid'=>$empid]);
		// $row = $stmt->fetch();

		$sql = " SELECT *, COUNT(*) AS numrows FROM sps.users1 WHERE username='".$username."' OR empid='".$empid."' GROUP BY id,username,firstname,lastname,line,plant,password,empid,type,photo,created_on ";
		$params = array();
	 	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	 	$stmt = sqlsrv_query( $conn, $sql , $params, $options );
		$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Username or Employee ID already taken';
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);
			$filename = $_FILES['photo']['name'];
			$now = date('Y-m-d');
			if(!empty($filename)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
			}
			try{
				// $stmt = $conn->prepare("INSERT INTO users1 (username, password, firstname, lastname, empid, plant, line, type, photo, created_on) VALUES (:username, :password, :firstname, :lastname, :empid, :plant, :line, :type, :photo, :created_on)");
				// $stmt->execute(['username'=>$username, 'password'=>$password, 'firstname'=>$firstname, 'lastname'=>$lastname, 'empid'=>$empid, 'plant'=>$plant, 'line'=>$line, 'type'=>$type, 'photo'=>$filename, 'created_on'=>$now]);

				$sql = " INSERT INTO sps.users1 ([username], [password], [firstname], [lastname], [empid], [plant], [line], [type], [photo], [created_on]) VALUES ('".$username."', '".$password."', '".$firstname."', '".$lastname."', '".$empid."', '".$plant."', '".$line."', '".$type."', '".$filename."' , '".$now."' ";
				$stmt = sqlsrv_query($conn , $sql);


				$_SESSION['success'] = 'User added successfully';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		//$pdo->close();
	}
	else{
		$_SESSION['error'] = 'Fill up user form first';
	}

	header('location: users.php');

?>