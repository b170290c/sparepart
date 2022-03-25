<?php include 'includes/session.php'; ?>
<style>
input[type=text] {
    padding:5px; 
    border:2px solid #ccc; 
    -webkit-border-radius: 5px;
    border-radius: 5px;
}

input[type=text]:focus {
    border-color:#333;
}

input[type=submit] {
    padding:5px 15px; 
    background:#ccc; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
}
th {
  background-color: #04AA6D;
  color: white;
}

</style>
<?php


	$slug = $_GET['product'];



	    $sql = "SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM sps.products LEFT JOIN sps.details ON details.product_id= products.id LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.sales ON sales.id = details.sales_id LEFT JOIN sps.users1 ON sales.user_id = users1.id WHERE slug = '".$slug."' ";
	    $params = array();
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$stmt = sqlsrv_query( $conn, $sql , $params, $options );

		$product = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);





?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-yellow layout-top-nav">

<div class="wrapper">

	<?php include 'includes/navbar2.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
		            <div class="row">
		            	<div class="col-sm-6">
		            		<img src="<?php echo (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?php echo $product['photo']; ?>">
		            		<br><br>
		            	
		            	</div>
		            	<div class="col-sm-6">
		            		<h1 class="page-header"><?php echo $product['prodname']; ?></h1>	

		            		<b>ID Location: &nbsp; <?php echo $product['idLoc']; ?> <br>
		            		
		            		SAP No: &nbsp; <?php echo $product['noSAP']; ?> <br>
		            		
		            		Parts No: &nbsp; <?php echo $product['noParts']; ?></b>

		            		
		            		
		            	</div>

		            </div>
     

                    <div class="container">
<table id="example6" class="table table-striped">
<tr>

<th>Received Date</th>

<th>Name</th>
<th>Line & Plant</th>
<th>Quantity</th>
<th>Item Status</th>
</tr>
<?php

		             $sql1 = "SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid FROM sps.products LEFT JOIN sps.details ON details.product_id= products.id LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.sales ON sales.id = details.sales_id LEFT JOIN sps.users1 ON sales.user_id = users1.id  WHERE details.detail_status <> '0' AND details.detail_status <> '3' AND details.detail_status <> '2'  ORDER BY users1.firstname asc ";
                      $params1 = array();
                      $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                      $stmt1 = sqlsrv_query( $conn, $sql1 , $params1, $options1 );


                while($row = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {

                  $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                 
        
$qtyok = $row['qtyok'];
$quantity = $row['quantity'];
$st = $row['detail_status'];
$itemRec = $row['itemRec'];
$sales_date = $row['sales_date']->format("d-M-y h:i a");


if ($st == 0) {
                             $st = 'Waiting for Approval';
                          } elseif ($st == 1) {
                              $st = 'Approved! ';

                      }

    ?>
    <tr>
    <td><?php echo $sales_date; ?>

    <td><?php echo $row['firstname'].' '.$row['lastname']; ?></td>
    <td><?php echo $row['line'].' & '. $row['plant']; ?></td>
    <td><strong>Requested :</strong> <?php echo $row['quantity'];?> <br>
      <strong>Approved : </strong><?php echo $row['qtyok']; ?>
       
    </td>
    <?php
if($qtyok != $quantity && $itemRec==1 ){
?>
   <td bgcolor='#FF0000' style="text-align:center">
    
                             <h2> Order On-Going! </h2>

                             
                       

                             </td>
<?php
} 
elseif($qtyok == $quantity && $itemRec==1){
?>
   <td bgcolor='#00FF00' style="text-align:center">
    
                             <h2> Order Closed! </h2>

                             
                       

                             </td>
<?php
} 
elseif(  $st == 1 && $itemRec==0 || $itemRec==1){
?>

   <td bgcolor='#ffff00' style="text-align:center">
    
                             <h2> Collect Product! </h2>

                             
                       

                             </td>
<?php

} 
    
?>
    
    </tr>
<?php
}
?>
</table>
</div>

           



		            <br>
				   
	        	
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
$(function(){
	$('#add').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		quantity++;
		$('#quantity').val(quantity);
	});
	$('#minus').click(function(e){
		e.preventDefault();
		var quantity = $('#quantity').val();
		if(quantity > 1){
			quantity--;
		}
		$('#quantity').val(quantity);
	});

});
</script>
</body>
</html>