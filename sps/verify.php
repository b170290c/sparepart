<?php
	include 'includes/session.php';
	//$conn = $pdo->open();

	if(isset($_POST['login'])){
		
		$username = $_POST['username'];
		$password = $_POST['password'];

		try{

			$sql = "SELECT id,username,firstname,lastname,password,type,empid, COUNT(*) AS numrows FROM sps.users1 WHERE username = '$username' GROUP BY id,username,firstname,lastname,password,type,empid";

			   $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options );


						    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

			// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM users1 WHERE username = :username");
			// $stmt->execute(['username'=>$username]);
			// $row = $stmt->fetch();
			if($row['numrows'] > 0){
					if(password_verify($password, $row['password'])){
						if($row['type']){
							$_SESSION['admin'] = $row['id'];
							$_SESSION['empid'] = $row['empid'];
						}
						else{
							$_SESSION['user'] = $row['id'];
							$_SESSION['empid'] = $row['empid'];
						}
					}
					else{
						$_SESSION['error'] = 'Incorrect Password';
					}
				
				
			}
			else{
				$_SESSION['error'] = 'Username not found';
			}
		}
	}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

	}
	else{
		$_SESSION['error'] = 'Input login credentails first';
	}

	//$pdo->close();

	header('location: login.php');

?>