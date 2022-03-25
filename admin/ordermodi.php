<?php
include 'includes/session.php';



$status = $_POST['status'];
$did = $_POST['dID'];


$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');



//$conn = $pdo->open();

if($status == 'Now')
{

	$sql = " SELECT * FROM sps.details LEFT JOIN sps.sales ON details.sales_id=sales.id LEFT JOIN sps.products ON details.product_id = products.id WHERE detailid='".$did."' ";
	$stmt = sqlsrv_query($conn , $sql);

	//	$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON details.sales_id=sales.id LEFT JOIN products ON details.product_id = products.id WHERE detailid=:id");
	//	$stmt->execute(['id'=>$did]);

						while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
						$req = $row['quantity'];

						$ownqnty = $row['ownqnty'];									
						$pid = $row['product_id'];

						$blnc = $_POST['blnc'];	

						$valid = $ownqnty - $blnc;

					


	//reject 
					if($valid < 0 ){

						// echo "cannot proceed low qnty!";

							 header("location:ongoing.php?fail=fail");


					
					}


else{

// echo "update alr 2";

					$sql = " UPDATE sps.ongoing SET  orderstat='2' , dates='".$date."' WHERE detailid='".$did."' ";
					$stmt = sqlsrv_query($conn , $sql);

				 	// $stmt = $conn->prepare("UPDATE ongoing SET  orderstat=:orderstat , dates=:dates WHERE detailid=:did");
			   //      $stmt->execute([ 'orderstat'=>2 , 'dates'=>$date , 'did'=>$did ]);

			header("location:ongoing2.php?dID=$did");

}
}



}






elseif($status == 'Reschedule')
{


			$sql = " UPDATE sps.ongoing SET  orderstat='0' , dates='".$date."' WHERE detailid='".$did."' ";
			$stmt = sqlsrv_query($conn , $sql);


		 // $stmt = $conn->prepare("UPDATE ongoing SET   orderstat=:orderstat , dates=:dates WHERE detailid=:did");
   //          $stmt->execute([ 'orderstat'=> 0 , 'dates'=>$date , 'did'=>$did ]);

		header("location:ongoing2.php?dID=$did");
}













?>