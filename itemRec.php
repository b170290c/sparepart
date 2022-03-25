
<?php include 'includes/session.php';
include 'includes/header.php';
?>
<head>
<script type="text/javascript" src="js/jquery-3.5.1"></script>

<script>

</script>
</head>
<body>
<?php

$detailid = $_POST['dID'];
$itemRec = $_POST['itemRec'];
$stat = $_POST['stat'];


	

$conn = $pdo->open();



if($stat == "Receive"){
	$code = 1;
}

try{
				$stmt = $conn->prepare("UPDATE details SET itemRec=:stat WHERE detailid=:detailid");
				$stmt->execute(['stat'=>$code, 'detailid'=>$detailid]);
				$stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON details.sales_id=sales.id LEFT JOIN products ON details.product_id = products.id WHERE detailid=:id");
				$stmt->execute(['id'=>$detailid]);
				
			}


		
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
		}







		$pdo->close();



header("location:item_view.php");

?>