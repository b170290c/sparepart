<?php include 'includes/session.php';
include 'includes/header.php';
?>
<head>
<script type="text/javascript" src="../js/jquery-3.5.1"></script>


</head>
<body>
<?php
$product_id = $_POST['pID'];
$sales_id = $_POST['sID'];
$detailid = $_POST['dID'];
$retqty = $_POST['retqty'];
$qtyok = $_POST['qtyok'];
$badqty = $_POST['badqty'];
$qnty = $_POST['qnty'];
$note = $_POST['note'];
$ownqnty = $_POST['ownqnty'];

$okqty = $retqty - $badqty;

$okqty1 = $qnty + $okqty ;

$ownqty = $okqty + $ownqnty;



//$conn = $pdo->open();



	$int = 3;






try{		
		$sql = " UPDATE sps.rdetails SET retstat='".$int."' , badqty='".$badqty."' , comments='".$note."' WHERE detailid='".$detailid."' ";
		$stmt = sqlsrv_query($conn , $sql);



	
				// $stmt = $conn->prepare("UPDATE rdetails SET retstat=:itemret, badqty=:badqty, comments=:notes WHERE detailid=:detailid");
				// $stmt->execute(['itemret'=>$int, 'badqty'=>$badqty, 'notes'=>$note, 'detailid'=>$detailid]);
				

			$sql = " UPDATE sps.products SET qnty='".$okqty1."' , ownqnty='".$ownqnty."' WHERE id= '".$product_id."' ";
			$stmt = sqlsrv_query($conn , $sql);


				// $stmt = $conn->prepare("UPDATE products SET qnty=:qnty, ownqnty=:ownqnty WHERE id=:product_id");
				// $stmt->execute(['qnty'=>$okqty1, 'ownqnty'=>$ownqty ,'product_id'=>$product_id]);

					
				}
			
			
		


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		//$pdo->close();



 header("location:return.php");

?>