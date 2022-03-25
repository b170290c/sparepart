<?php
	include 'includes/session.php';

	$id = $_POST['id'];

	//$conn = $pdo->open();

	$output = array('list'=>'');

	$sql = " SELECT * FROM sps.details LEFT JOIN sps.products ON products.id=details.product_id LEFT JOIN sps.sales ON sales.id=details.sales_id WHERE sales.id='".$id."' ";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $conn, $sql , $params, $options ); 
                      

	// $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id LEFT JOIN sales ON sales.id=details.sales_id WHERE sales.id=:id");
	// $stmt->execute(['id'=>$id]);

	$total = 0;
	while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
		$output['transaction'] = $row['pay_id'];
		 $output['date'] = $row['sales_date']->format("d/M/y");
		$subtotal = $row['price']*$row['quantity'];
		$total += $subtotal;
		$output['list'] .= "
			<tr class='prepend_items'>
				<td>".$row['idLoc'].
				'<br/>'
				.$row['noParts'].
				'<br/>'
				.$row['noSAP']."</td>
				<td>RM ".number_format($row['price'], 2)."</td>
				<td>".$row['quantity']."</td>
				
				<td>RM ".number_format($subtotal, 2)."</td>
			</tr>
		";
	}
	
	$output['total'] = 'RM '.number_format($total, 2).'<b>';
	//$pdo->close();
	echo json_encode($output);

?>