<?php
	include 'includes/session.php';

	$output = '';

	// $conn = $pdo->open();

	// $stmt = $conn->prepare("SELECT * FROM category");
	// $stmt->execute();

	// foreach($stmt as $row){

	$sql = " SELECT * FROM sps.category ";
	$stmt = sqlsrv_query($conn , $sql);
	
	while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
		$output .= "
			<option value='".$row['id']."' class='append_items'>".$row['name']."</option>
		";
	}

	//$pdo->close();
	echo json_encode($output);

?>