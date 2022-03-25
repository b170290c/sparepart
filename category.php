<?php include 'includes/session.php'; ?>
<?php
	$slug = $_GET['category'];

	//$conn = $pdo->open();

	try{

		$sql = " SELECT * FROM sps.category WHERE cat_slug = '".$slug."' ";
		$stmt = sqlsrv_query($conn , $sql);
		$cat = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


		// $stmt = $conn->prepare("SELECT * FROM category WHERE cat_slug = :slug");
		// $stmt->execute(['slug' => $slug]);
		// $cat = $stmt->fetch();


		$catid = $cat['id'];
	}
	catch(PDOException $e){
		echo "There is some problem in connection: " . $e->getMessage();
	}

	//$pdo->close();

?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
		            <h1 class="page-header"><?php echo $cat['name']; ?></h1>
		       		<?php
		       			
		       		//	$conn = $pdo->open();

		       			try{
		       			 	$inc = 3;

		       			 	$sql = " SELECT * FROM products WHERE category_id='".$catid."' ";
		       			 	$stmt = sqlsrv_query($conn , $sql);



						    // $stmt = $conn->prepare("SELECT * FROM products WHERE category_id=:catid");
						    // $stmt->execute(['catid' => $catid]);

						    while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=".$row['slug']."'>".$row['name']."</a></h5>
		       								</div>
		       								<div class='box-footer'>
		       									<b>RM ".number_format($row['price'], 2)."</b>
		       								</div>
	       								</div>
	       							</div>
	       						";
	       						if($inc == 3) echo "</div>";
						    }
						    if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
							if($inc == 2) echo "<div class='col-sm-4'></div></div>";
						}
						catch(PDOException $e){
							echo "There is some problem in connection: " . $e->getMessage();
						}

					//	$pdo->close();

		       		?> 
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>