	<?php include 'includes/session.php';
	include 'includes/header.php';
	?>
	<head>
	 <script type="text/javascript" src="js/jquery-3.5.1.js"></script>

	</script>


	</head>
	<body>
	<?php


	$status = $_POST['status'];
	$detailid = $_POST['dID'];
	$pid = $_POST['pID'];
	$sid = $_POST['sID'];
	$notes = $_POST['note'];
	$oldQnty = $_POST['oldQnty'];
	$newQnty = $_POST['newQnty'];
	$qtyok = $_POST['qtyok'];
	$ownQnty = $_POST['ownQnty'];

	$date = date_default_timezone_set("Asia/Singapore");
	$date = date('Y-m-d H:i:s');




	//$conn = $pdo->open();



	if($status == "Accept"){
		$code = 1;
	}
	else{
		$code = 2;


	}

	$ok = 1;



	//validation
	
$valid = $ownQnty - $qtyok ;


	if( $valid < 0   && $status != "Reject"){



	 header("location:sales.php?fail=fail");
	 exit();

	}


	else{


	try{





					// $stmt = $conn->prepare("UPDATE details SET detail_status=:status, qtyok=:qtyok, notes=:note WHERE detailid=:detailid");
					// $stmt->execute(['status'=>$code, 'qtyok'=>$qtyok ,'note'=>$notes, 'detailid'=>$detailid]);

		$sql = " UPDATE sps.details SET detail_status='".$code."' , qtyok='".$qtyok."', notes='".$notes."' WHERE detailid='".$detailid."' ";
		$stmt = sqlsrv_query($conn , $sql);
					


					
					// $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON details.sales_id=sales.id LEFT JOIN products ON details.product_id = products.id WHERE detailid=:id");
					// $stmt->execute(['id'=>$detailid]);

					// foreach($stmt as $row){

		$sql1 = " SELECT * FROM sps.details LEFT JOIN sps.sales ON details.sales_id=sales.id LEFT JOIN sps.products ON details.product_id = products.id WHERE detailid='".$detailid."' "; 
		$params1 = array();
        $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

        $stmt1 = sqlsrv_query( $conn, $sql1 , $params1, $options1 );

        while($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {

					$req = $row['quantity'];
					$detailid = $_POST['dID'];
					$pid = $_POST['pID'];
					$sid = $_POST['sID'];
					$ok = $qtyok;
					$blnc = $row['qnty'];
					$ownqnty = $row['ownqnty'];
					$pid = $row['product_id'];
					$ori = $row['qnty'];
					$curr = $row['quantity'];

					//baalance after accept
					$bal = $req - $ok;
					
					//quantity balance in hand
					$newBlnc = $ownqnty - $ok;

					//return product qnty stock for reject
					$newQnty1 = $ori + $curr;



	//reject calc.
					if($status == "Reject"){

					// $stmt = $conn->prepare("UPDATE products SET qnty=:newQnty WHERE id=:pid");
					// $stmt->execute(['newQnty'=>$newQnty1,  'pid'=>$pid ]);
						$sql = " UPDATE sps.products SET qnty='".$newQnty1."' WHERE id='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);
					header("location:sales.php?success=success");
					exit();

					}

	//accept calc.				

					if($status == "Accept" && $newQnty == $qtyok){

			


					// $stmt = $conn->prepare("UPDATE products SET ownqnty=:newBlnc WHERE id=:pid");
					// $stmt->execute(['newBlnc'=>$newBlnc , 'pid'=>$pid ]);

						$sql = " UPDATE sps.products SET ownqnty='".$newBlnc."' WHERE id='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);

					// $stmt = $conn->prepare("UPDATE details SET qtyok=:ok WHERE detailid=:detailid");
					// $stmt->execute(['ok'=>$ok, 'detailid'=>$detailid ]);

						$sql = " UPDATE sps.details SET qtyok='".$ok."' WHERE detailid='".$detailid."' ";
						$stmt = sqlsrv_query($conn , $sql);




					}

					//ongoing order calc.				

					if($status == "Accept" && $newQnty != $qtyok){

					// $stmt = $conn->prepare("UPDATE products SET ownqnty=:newBlnc WHERE id=:pid");
					// $stmt->execute(['newBlnc'=>$newBlnc , 'pid'=>$pid ]);
						$sql = " UPDATE sps.products SET ownqnty='".$newBlnc."' WHERE id='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);




					
						$sql = " INSERT INTO sps.ongoing ([detailid], [salesid], [product_id], [quantity], [orderstat], [dates] ) VALUES ('".$detailid."', '".$sid."', '".$pid."', '".$bal."' , '0' , '".$date."') ";
						$stmt = sqlsrv_query($conn , $sql);


 //echo $sql;
					}
				
				
				}
			}
			
				catch(PDOException $e){
					$_SESSION['error'] = $e->getMessage();
			}







		//	$pdo->close();



	header("location:sales.php?success=success");
	}
	?>