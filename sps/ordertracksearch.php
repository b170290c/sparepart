<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar2.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-8">
	            <?php
	       			
	       			//$conn = $pdo->open();

	       			// $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products WHERE name LIKE :keyword");
	       			// $stmt->execute(['keyword' => '%'.$_POST['keyword'].'%']);
	       			// $row = $stmt->fetch();

	            // $sql = " SELECT COUNT(*) AS numrows FROM sps.products WHERE name LIKE '%".$_POST['keyword']."%' ";
	             $sql = " SELECT COUNT(*) AS numrows FROM sps.products WHERE name LIKE  '".'%'.$_POST['keyword'].'%'."' ";
	            $params = array();
                $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                $stmt = sqlsrv_query( $conn, $sql , $params, $options );
                $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);



	       			if($row['numrows'] < 1){
	       				echo '<h1 class="page-header">No results found for <i>'.$_POST['keyword'].'</i></h1>';
	       			}
	       			else{
	       				echo '<h1 class="page-header">Search results for <i>'.$_POST['keyword'].'</i></h1>';
		       			try{
		       			 	$inc = 3;	

		       			 	$sql1 = " SELECT *, products.name as prodname , category.name as catname FROM sps.products LEFT JOIN sps.category ON products.category_id=category.id WHERE products.name LIKE '".'%'.$_POST['keyword'].'%'."' ";
		       			 	$params1 = array();
               				$options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                			$stmt1 = sqlsrv_query( $conn, $sql1 , $params1, $options1 );


						    // $stmt = $conn->prepare("SELECT *, products.name as prodname , category.name as catname FROM products LEFT JOIN category ON products.category_id=category.id WHERE products.name LIKE :keyword");
						    // $stmt->execute(['keyword' => '%'.$_POST['keyword'].'%']);
					 
						      while($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {

						    	$highlighted = preg_filter('/' . preg_quote($_POST['keyword'], '/') . '/i', '<b>$0</b>', $row['prodname']);
						    	$image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
						    	$inc = ($inc == 3) ? 1 : $inc + 1;
	       						if($inc == 1) echo "<div class='row'>";
	       						echo "
	       							<div class='col-sm-4'>
	       								<div class='box box-solid'>
		       								<div class='box-body prod-body'>
		       									<img src='".$image."' width='100%' height='230px' class='thumbnail'>
		       									<h5><a href='product.php?product=".$row['slug']."'>".$highlighted."</a></h5>
		       								</div>
		       								<div class='box-footer'>
		       									<b>Piece Available: ".number_format($row['qnty'])."</b>
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
					}

					//$pdo->close();
					  sqlsrv_free_stmt($stmt);
                      sqlsrv_close($conn);

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