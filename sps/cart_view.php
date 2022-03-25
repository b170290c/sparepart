<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>

 <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>
<body class="hold-transition skin-green layout-top-nav">
<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 <?php 
	 $id = uniqid();
	 
	 if (isset($_GET['fail'])){
	 	echo ("<script>alert('Unable to send request! Invalid selected quantity! Please try again!');</script>");
	 }
	 ?>
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<h1 class="page-header">YOUR CART</h1>
	        		<div class="box box-solid">
	        			<div class="box-body">
		        		<table class="table table-bordered">
		        			<thead>
		        				<th></th>
		        				<th>Photo</th>
		        				<th>Name</th>
		        				<th>Available Piece</th>
		        				<th width="20%">Quantity</th>
		        				
		        			</thead>
		        			<tbody id="tbody">
		        			</tbody>
		        		</table>
	        			</div>
	        			
	        		</div>
	        		
	        		<?php
	        			if(isset($_SESSION['user'])){
	        				echo "
	        					<div id='cam-button'></div>

	        				";
	        			}
	        			else{
	        				echo "
	        					<h4>You need to <a href='login.php'>Login</a> to checkout.</h4>
	        				";
	        			}
	        		?>
	        		<form action = "sales.php">

					<?php

					$sql = "SELECT id, firstname , lastname, empid FROM sps.users1 WHERE id = '" .$_SESSION['user']. "' ";
					
				    $stmt = sqlsrv_query( $conn, $sql );
					// $data = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);




	     //    			$stmt = $conn->prepare("SELECT firstname , lastname, empid FROM users1 WHERE users1.id = '" . $_SESSION['user'] . "' ");
						// $stmt->execute();
						// $data = $stmt->fetchAll();

					?>
						 <select id="reqID" name="reqID" required>
                      <?php 

                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)){



                      	$fullname = $row['firstname']. '&nbsp;' . $row['lastname']; 
                      	$empid = $row['empid'];

                      }

                      ?>

				  <option value="<?php echo $empid ?>" selected><?php echo $fullname . ' - ' .$empid ?></option>
					
                    </select> 

	        			<input type = "hidden" name = "id" value = "<?php echo $id ?>" class = "cam-button"/>
	        		<!--	<input type="text" name='reqID' value=" <?php //echo $_SESSION['empid'];?>" data-id='".$row['salesid']."' required/></td> -->
	        			<input type = "submit" value = "Request Parts" class = "btn btn-danger"/> 

<!-- <input class="cam-button" type="button" value="Request Parts" onclick="window.open('camera.php','popUpWindow','height=480,width=720,left=100,top=100,resizable=no,scrollbars=no, status=yes');"/> -->
</form>
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
<script>
var total = 0;
$(function(){
	$(document).on('click', '.cart_delete', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		$.ajax({
			type: 'POST',
			url: 'cart_delete.php',
			data: {id:id},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.minus', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		if(qty>1){
			qty--;
		}
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	$(document).on('click', '.add', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = $('#qty_'+id).val();
		qty++;
		$('#qty_'+id).val(qty);
		$.ajax({
			type: 'POST',
			url: 'cart_update.php',
			data: {
				id: id,
				qty: qty,
			},
			dataType: 'json',
			success: function(response){
				if(!response.error){
					getDetails();
					getCart();
					getTotal();
				}
			}
		});
	});

	getDetails();
	getTotal();

});

function getDetails(){
	$.ajax({
		type: 'POST',
		url: 'cart_details.php',
		dataType: 'json',
		success: function(response){
			$('#tbody').html(response);
			getCart();
		}
	});
}

function getTotal(){
	$.ajax({
		type: 'POST',
		url: 'cart_total.php',
		dataType: 'json',
		success:function(response){
			total = response;
		}
	});
}
</script>

<!-- Paypal Express -->
 <!--  <script>
paypal.Button.render({
    env: 'sandbox', // change for production if app is live,

	client: {
        sandbox:    'ASb1ZbVxG5ZFzCWLdYLi_d1-k5rmSjvBZhxP2etCxBKXaJHxPba13JJD_D3dTNriRbAv3Kp_72cgDvaZ',
        //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
    },

    commit: true, // Show a 'Pay Now' button

    style: {
    	color: 'gold',
    	size: 'small'
    },

    payment: function(data, actions) {
        return actions.payment.create({
            payment: {
                transactions: [
                    {
                    	//total purchase
                        amount: { 
                        	total: total, 
                        	currency: 'USD' 
                        }
                    }
                ]
            }
        });
    },

    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function(payment) {
			window.location = 'sales.php?pay='+payment.id;
        });
    },

}, '#paypal-button');  
</script> -->



</body>
</html>