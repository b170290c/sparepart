<?php
include 'includes/session.php';


$pid = $_POST['pID'];
$did = $_POST['dID'];
$sid = $_POST['sID'];
$ename = $_POST['eName'];
$eid = $_POST['eID'];
$blnc = $_POST['blnc'];
$oldqty = $_POST['oldqty'];
$ownqnty = $_POST['ownqty'];
$oriqty = $_POST['oriqty'];
$balqty = $_POST['balqty'];


$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');

//to check if bal qty = 0
$curqty = $balqty - $blnc;

//for details.qtyok
$newqty = $oldqty + $blnc;


//for products.qty
$pqnty1 = $ownqnty - $blnc;


//echo $pqnty1;

//$conn = $pdo->open();




			if($curqty == 0)
			{	  	


				$sql = " UPDATE sps.ongoing SET quantity='".$curqty."' , orderstat='3' , dates= '".$date."' , empID='".$eid."' , empName='".$ename."'  WHERE detailid='".$did."' ";
				$stmt = sqlsrv_query($conn , $sql);

					 // 	$stmt = $conn->prepare("UPDATE ongoing SET quantity=:quantity, orderstat=:orderstat , dates=:dates , empID=:empID , empName=:empName  WHERE detailid=:did");
						// $stmt->execute(['quantity'=>$curqty , 'orderstat'=>3 , 'dates'=>$date , 'empID'=>$eid , 'empName'=>$ename , 'did'=>$did ]);

				
				$sql = " UPDATE sps.products SET ownqnty='".$pqnty1."' WHERE id='".$pid."' ";
				$stmt = sqlsrv_query($conn , $sql);


						// $stmt = $conn->prepare("UPDATE products SET ownqnty=:ownqnty WHERE id=:product_id");
						// $stmt->execute(['ownqnty'=>$pqnty1 , 'product_id'=>$pid]);

				$sql = " UPDATE sps.details SET qtyok='".$newqty."' , dates='".$dates."' WHERE detailid='".$did."' ";
				$stmt = sqlsrv_query($conn , $sql);

						 // $stmt = $conn->prepare("UPDATE details SET qtyok=:quantity , dates=:dates WHERE detailid=:did");
       //      	 		 $stmt->execute(['quantity'=>$newqty ,  'dates'=>$date ,  'did'=>$did ]);


						 header("location:sales.php?success1=success1");



					}

					elseif($curqty != 0)
					{	  

						$sql = " UPDATE sps.ongoing SET quantity='".$curqty."' , orderstat='0' , dates= '".$date."' WHERE detailid='".$did."' ";
						$stmt = sqlsrv_query($conn , $sql);


					 // 	$stmt = $conn->prepare("UPDATE ongoing SET quantity=:quantity, orderstat=:orderstat , dates=:dates  WHERE detailid=:did");
						// $stmt->execute(['quantity'=>$curqty, 'orderstat'=> 0, 'dates'=>$date, 'did'=>$did ]);


						$sql = " UPDATE sps.products SET ownqnty='".$pqnty1."' WHERE id='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);


						// $stmt = $conn->prepare("UPDATE products SET ownqnty=:ownqnty WHERE id=:product_id");
						// $stmt->execute(['ownqnty'=>$pqnty1, 'product_id'=>$pid]);

						$sql = " UPDATE sps.details SET qtyok='".$newqty."' WHERE detailid='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);

						// $stmt = $conn->prepare("UPDATE details SET qtyok=:quantity WHERE detailid=:did");
      //       	 		$stmt->execute(['quantity'=>$newqty ,  'did'=>$did ]);


						 header("location:ongoing2.php?dID=$did");




					}


			







		$pdo->close();



 
 ?>





























?>