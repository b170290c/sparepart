<?php
	include 'includes/session.php';
	//$conn = $pdo->open();

	$output = '';

	if(isset($_SESSION['user'])){
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $row){

				$sql = "SELECT user_id,product_id,quantity , COUNT(*) AS numrows FROM sps.cart WHERE user_id='".$user['id']."' AND product_id= '".$row['productid']."' GROUP BY user_id,product_id,quantity ";
					$params = array();
				    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				    $stmt = sqlsrv_query( $conn, $sql , $params, $options );
					$crow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


				// $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
				// $stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				// $crow = $stmt->fetch();

				if($crow['numrows'] < 1){

					$sql = "INSERT INTO sps.cart ([user_id], [product_id], [quantity]) VALUES ('".$user['id']."' , '".$row['productid']."', '".$row['quantity']."')";
					$stmt = sqlsrv_query( $conn, $sql );



					// $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
					// $stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid'], 'quantity'=>$row['quantity']]);
				}
				else{

					$sql = "UPDATE sps.cart SET quantity='".$row['quantity']."' WHERE user_id='".$user['id']."' AND product_id='".$row['productid']."' ";
					$stmt = sqlsrv_query( $conn, $sql );


					// $stmt = $conn->prepare("UPDATE sps.cart SET quantity='".$row['quantity']."' WHERE user_id='".$user['id']."' AND product_id='".$row['productid']."' ");
					// $stmt->execute(['quantity'=>$row['quantity'], 'user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				}
			}
			unset($_SESSION['cart']);
		}

		try{
			$total = 0;

			$sql = " SELECT *, cart.id AS cartid FROM sps.cart LEFT JOIN sps.products ON products.id=cart.product_id WHERE user_id= '".$user['id']."' ";
			$params = array();
			$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
			$stmt = sqlsrv_query( $conn, $sql , $params, $options );



			// $stmt = $conn->prepare("SELECT *, cart.id AS cartid FROM cart LEFT JOIN products ON products.id=cart.product_id WHERE user_id=:user");
			//$stmt->execute(['user'=>$user['id']]);

			while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
				$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
				$id = uniqid();
				$output .= "
					<tr>
						<td><button type='button' data-id='".$row['cartid']."' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
						<td><img src='".$image."' width='30px' height='30px'></td>
						<td>".$row['name']."</td>
						<td>".$row['qnty']."</td>
					
						<td class='input-group'>
							<span class='input-group-btn'>
            					<button type='button' id='minus' class='btn btn-default btn-flat minus' data-id='".$row['cartid']."'><i class='fa fa-minus'></i></button>
            				</span>
            				<input type='text' class='form-control' name = 'quantity' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
            				
				            <span class='input-group-btn'>
				                <button type='button' id='add' class='btn btn-default btn-flat add' data-id='".$row['cartid']."'><i class='fa fa-plus'></i>
				                </button>
				            </span>
						
					</tr>
				";
			}
			

		}
		catch(PDOException $e){
			$output .= $e->getMessage();
		}

	}
	else{
		if(count($_SESSION['cart']) != 0){
			$total = 0;
			foreach($_SESSION['cart'] as $row){

				 $sql = "SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id  WHERE products.id = '".$row['productid']."' ";
			    $params = array();
				$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
				$stmt = sqlsrv_query( $conn, $sql , $params, $options );
				$product = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


				// $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				// $stmt->execute(['id'=>$row['productid']]);
				// $product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg';
				
				$output .= "
					<tr>
						<td><button type='button' data-id='".$row['productid']."' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
						<td><img src='".$image."' width='30px' height='30px'></td>
						<td>".$product['name']."</td>
						<td>".$product['qnty']."</td>
					
						<td class='input-group'>
							<span class='input-group-btn'>
            					<button type='button' id='minus' class='btn btn-default btn-flat minus' data-id='".$row['productid']."'><i class='fa fa-minus'></i></button>
            				</span>
            				<input type='text' class='form-control' value='".$row['quantity']."' id='qty_".$row['productid']."'>
				            <span class='input-group-btn'>
				                <button type='button' id='add' class='btn btn-default btn-flat add' data-id='".$row['productid']."'><i class='fa fa-plus'></i>
				                </button>
				            </span>
						</td>
						
					</tr>
				";
				
			}

			$output .= "
				
			";
		}

		else{
			$output .= "
				<tr>
					<td colspan='6' align='center'>Cart is empty</td>
				<tr>
			";
		}
		
	}

//	$pdo->close();
	echo json_encode($output);

?>

