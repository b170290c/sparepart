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






			if($curqty == 0)
			{	  	


				$sql = " UPDATE sps.ongoing SET quantity='".$curqty."' , orderstat='3' , dates= '".$date."' , empID='".$eid."' , empName='".$ename."'  WHERE detailid='".$did."' ";
				$stmt = sqlsrv_query($conn , $sql);

					

				
				$sql = " UPDATE sps.products SET ownqnty='".$pqnty1."' WHERE id='".$pid."' ";
				$stmt = sqlsrv_query($conn , $sql);


						

				$sql = " UPDATE sps.details SET qtyok='".$newqty."' , empName='".$ename."' , empID = '".$eid."' , dates='".$date."' WHERE detailid='".$did."' ";
				$stmt = sqlsrv_query($conn , $sql);

			

						 header("location:sales.php?success1=success1");


					}

					elseif($curqty != 0)
					{	  

						$sql = " UPDATE sps.ongoing SET quantity='".$curqty."' , orderstat='0' , dates= '".$date."' WHERE detailid='".$did."' ";
						$stmt = sqlsrv_query($conn , $sql);



						$sql = " UPDATE sps.products SET ownqnty='".$pqnty1."' WHERE id='".$pid."' ";
						$stmt = sqlsrv_query($conn , $sql);



						$sql = " UPDATE sps.details SET qtyok='".$newqty."' ,  empName='".$ename."' , empID = '".$eid."' , dates='".$date."' WHERE detailid='".$did."' ";
						$stmt = sqlsrv_query($conn , $sql);



						 header("location:ongoing2.php?dID=$did");




					}


			

































?>