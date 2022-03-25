
<?php
	include 'includes/session.php';
	if(isset($_GET['id'])){
		$payid = $_GET['id'];
		$date = date_default_timezone_set("Asia/Singapore");
		$date = date('Y-m-d H:i:s');
		$reqID = $_GET['reqID'];

	//	$conn = $pdo->open();
	
		try{

			$sql1 = " SELECT * FROM sps.cart LEFT JOIN sps.products ON products.id=cart.product_id WHERE user_id='".$user['id']."' ";
			$stmt1 = sqlsrv_query($conn , $sql1);
			
				// $stmt = $conn->prepare("SELECT * FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user_id");
				 
				// $stmt->execute(['user_id'=>$user['id']]);
			
				while($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)){

					$curr = $row['quantity'];
					$ori = $row['qnty'];
					$pid = $row['product_id'];
					
					$roq = $row['roq'];
					$reqID = $_GET['reqID'];


					$newQnty = $ori - $curr;

					$sql2 = " UPDATE sps.products SET qnty='".$newQnty."' WHERE id='".$pid."' ";
					$stmt2 = sqlsrv_query($conn , $sql2);
					// $stmt = $conn->prepare("UPDATE products SET qnty=:newQnty WHERE id=:pid");
					// $stmt->execute(['newQnty'=>$newQnty, 'pid'=>$pid ]);
					

					$sql3 = " INSERT INTO sps.sales ([user_id], [pay_id], [sales_date]) VALUES ('".$user['id']."', '".$payid."' , '".$date."'); ";
					$stmt3 = sqlsrv_query($conn , $sql3);

					// $stmt = $conn->prepare("INSERT INTO sales (user_id, pay_id, sales_date) VALUES (:user_id, :pay_id, :sales_date)");
					// $stmt->execute(['user_id'=>$user['id'], 'pay_id'=>$payid, 'sales_date'=>$date]);
					//$salesid = $conn->lastInsertId();
					
					$sql4 = " ;WITH x AS (SELECT *, r = RANK() OVER (ORDER BY id DESC) FROM sps.sales) SELECT id FROM x WHERE r = 1 ";
					$stmt4 = sqlsrv_query($conn, $sql4);

					while ($details = sqlsrv_fetch_array($stmt4, SQLSRV_FETCH_ASSOC)) {
			

					$salesid = $details['id'];
				




					$sql5 = " INSERT INTO sps.details ([sales_id] , [product_id], [quantity], [detail_status], [notes], [qtyok], [itemRec], [reqID], [empName],  [empID], [reason] , [dates]) 
					 VALUES ('".$salesid."', '".$pid."', '".$curr."' , '0' , DEFAULT, '0' , '0' , '".$_GET['reqID']."' , DEFAULT , DEFAULT , DEFAULT , '".$date."') ";

					$stmt5 = sqlsrv_query($conn, $sql5);
					
}
// echo $sql; echo '<br>';
					
				
				// $stmt = $conn->prepare("INSERT INTO  details (sales_id, product_id, quantity, detail_status, notes, itemRec, reqID, empID, reason) VALUES (:sales_id, :product_id, :quantity, 0,DEFAULT,0, :reqID, DEFAULT,DEFAULT)");
					// $stmt->execute(['sales_id'=>$salesid, 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'],  'reqID'=>$_GET['reqID']]);

					$sql6 = " DELETE FROM sps.cart WHERE user_id = '".$user['id']."' ";
					$stmt6 = sqlsrv_query($conn , $sql6);
						
					// $stmt = $conn->prepare("DELETE FROM cart WHERE user_id=:user_id");
					// $stmt->execute(['user_id'=>$user['id']]);


						
						header("location:item_view.php");

						
					

				}
			}

	
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
	}
	
	
	sqlsrv_free_stmt($stmt);
	sqlsrv_close($conn);

		//$pdo->close();
 	
?>