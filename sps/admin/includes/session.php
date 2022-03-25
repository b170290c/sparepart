<?php
	include '../includes/conn1.php';
	session_start();
	
	$inactive = 600;
if( !isset($_SESSION['timeout']) )
$_SESSION['timeout'] = time() + $inactive; 

$session_life = time() - $_SESSION['timeout'];

if($session_life > $inactive)
{  
	
	session_destroy();
	
	header("Location:../login.php");     
}

$_SESSION['timeout']=time();

	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: ../index.php');
		exit();
	}

	//$conn = $pdo->open();

	// $stmt = $conn->prepare("SELECT * FROM users1 WHERE id=:id");
	// $stmt->execute(['id'=>$_SESSION['admin']]);
	// $admin = $stmt->fetch();

	$sql = " SELECT * FROM sps.users1 WHERE id='".$_SESSION['admin']."' ";
	$stmt = sqlsrv_query($conn , $sql);
	$admin = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


//	$pdo->close();
	    

?>