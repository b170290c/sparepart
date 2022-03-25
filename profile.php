<?php include 'includes/session.php'; ?>
<?php
	if(!isset($_SESSION['user'])){
		header('location: index.html');
	}
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
	        		<?php
	        			if(isset($_SESSION['error'])){
	        				echo "
	        					<div class='callout callout-danger'>
	        						".$_SESSION['error']."
	        					</div>
	        				";
	        				unset($_SESSION['error']);
	        			}

	        			if(isset($_SESSION['success'])){
	        				echo "
	        					<div class='callout callout-success'>
	        						".$_SESSION['success']."
	        					</div>
	        				";
	        				unset($_SESSION['success']);
	        			}
	        		?>
	        		<div class="box box-solid">
	        			<div class="box-body">
	        				<div class="col-sm-3">
	        					<img src="<?php echo (!empty($user['photo'])) ? 'images/'.$user['photo'] : 'images/profile.jpg'; ?>" width="100%">
	        				</div>
	        				<div class="col-sm-9">
	        					<div class="row">
	        						<div class="col-sm-3">
	        							<h4>Name:</h4>
	        							<h4>Username:</h4>
	        							<h4>Employee ID:</h4>
	        							<h4>Plant & Line:</h4>
	        							<h4>Joined On:</h4>

	        							
	        					
	        						</div>
	        						<div class="col-sm-9">
	        							<h4><?php echo $user['firstname'].' '.$user['lastname']; ?>
	        								<span class="pull-right">
	        									<a href="#edit" class="btn btn-success btn-flat btn-sm" data-toggle="modal"><i class="fa fa-edit"></i> Edit</a>
	        								</span>
	        							</h4>
	        							<h4><?php echo $user['username']; ?></h4>
	        							<h4><?php echo $user['empid']; ?></h4>
	        							<h4><?php echo (!empty($user['plant'])) ? $user['plant'] : 'N/a'; ?> & <?php echo (!empty($user['line'])) ? $user['line'] : 'N/a'; ?> </h4>
	        							<!-- <h4><?php echo (!empty($user['address'])) ? $user['address'] : 'N/a'; ?></h4> -->
	        						<h4><?php echo $user['created_on']->format("d-M-y "); ?></h4> 
	        						</div>
	        					</div>
	        				</div>
	        			</div>
	        		</div>
	        		<div class="box box-solid">
	        			<div class="box-header with-border">
	        				<h4 class="box-title"><i class="fa fa-calendar"></i> <b>Transaction History</b></h4>
	        			</div>
	        			<div class="box-body">
	        				<table class="table table-bordered" id="example1">
	        					<thead>
	        						<th class="hidden"></th>
	        						<th>Date</th>
	        						<th>Transaction#</th>
	        						<th>Status</th>
	        						<th>Full Details</th>
	        					</thead>
	        					<tbody>
	        					<?php
	        					//	$conn = $pdo->open();

	        						try{

	        							$sql = " SELECT * FROM sps.sales WHERE user_id='".$user['id']."' ORDER BY sales_date DESC ";
	        							// $stmt = $conn->prepare("SELECT * FROM sales WHERE user_id=:user_id ORDER BY sales_date DESC");
	        							// $stmt->execute(['user_id'=>$user['id']]);

	        							while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

	        								$sql1 = " SELECT * FROM sps.details LEFT JOIN sps.products ON products.id=details.product_id WHERE sales_id='".$row['id']."' ";

	        								$stmt1 = sqlsrv_query($conn , $sql1);



	        								// $stmt2 = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE sales_id=:id");
	        								// $stmt2->execute(['id'=>$row['id']]);
	        								$total = 0;
	        								while($row2 = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {

	        									$subtotal = $row2['price']*$row2['qtyok'];
	        									$total += $subtotal;
	        									$st = $row2['detail_status'];

	        									        if ($st == 0) {
							                             $st = 'Item Requested Is Being Reviewed!';
							                          } elseif ($st == 1) {
							                              $st = 'Approved! ';

							                          } elseif ($st == 2) {
							                             $st = 'Rejected! ';
							                          }
                        }
                      
	        								echo "
	        									<tr>
	        										<td class='hidden'></td>
	        										<td>".date('M d, Y', strtotime($row['sales_date']))."</td>
	        										<td>".$row['pay_id']."</td>
	        										<td> ".$st."</td>
	        										<td><button class='btn btn-sm btn-flat btn-info transact' data-id='".$row['id']."'><i class='fa fa-search'></i> View</button></td>
	        									</tr>
	        								";
	        							}

	        						}
        							catch(PDOException $e){
										echo "There is some problem in connection: " . $e->getMessage();
									}

	        						//$pdo->close(); 
	        						sqlsrv_free_stmt($stmt);
                      				sqlsrv_close($conn);
	        					?>
	        					</tbody>
	        				</table>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  
  	<?php include 'includes/footer.php'; ?>
  	<?php include 'includes/profile_modal.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
	$(document).on('click', '.transact', function(e){
		e.preventDefault();
		$('#transaction').modal('show');
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'transaction.php',
			data: {id:id},
			dataType: 'json',
			success:function(response){
				$('#date').html(response.date);
				$('#transid').html(response.transaction);
				$('#detail').prepend(response.list);
				$('#total').html(response.total);
			}
		});
	});

	$("#transaction").on("hidden.bs.modal", function () {
	    $('.prepend_items').remove();
	});
});
</script>
</body>
</html>