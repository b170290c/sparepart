<?php include 'includes/session.php'; ?>

  <meta charset="utf-8">


  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>


<?php
  $where = '';
  if(isset($_GET['category'])){
    $catid = $_GET['category'];
    $where = 'WHERE category_id ='.$catid;
  }

?>


<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/menubar.php'; ?>
  <?php include 'includes/navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Product List
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Products</li>
        <li class="active">Product List</li>
      </ol>
    </section>

<script>
$(document).ready(function() {
    $('#example4').DataTable({
        dom: "flrtip",
       //  "scrollY":        "800px",
        "scrollCollapse": true,
        "paging":         true,
        //"responsive": true,
     "scrollX": true
      
    });
} );
</script>



    <!-- Main content -->


 

    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
       <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
            <form method="POST" action="products_print.php" >
                <input type="hidden" name="print" ><br>
              <button class="fa fa-print">Excel</button>
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i class="fa fa-plus"></i> New</a>
                <div class="pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label>Brand: </label>
                    <select class="form-control input-sm" id="select_category">
                      <option value="0">ALL</option>
                      <?php
                       // $conn = $pdo->open();

                        // $stmt = $conn->prepare("SELECT * FROM category");
                        // $stmt->execute();

                      $sql = " SELECT * FROM sps.category ";
                      $stmt = sqlsrv_query($conn , $sql);

                        while($crow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                          $selected = ($crow['id'] == $catid) ? 'selected' : ''; 
                          echo "
                            <option value='".$crow['id']."' ".$selected.">".$crow['name']."</option>
                          ";
                        }

                       // $pdo->close();
                      ?>
                    </select>
                  </div>
                </form>
              </div>

             
            </div>
            <div class="box-body">
              <table id="example4" class="table table-hover" style="width:100%">
                <thead>
                  <th>Name</th>
                 <th>Vendor</th>
                  <th>Photo</th>
                  <th>Description</th>
                  <th>Price</th>
				  <th>Stock Count</th>
                  <th>Ready Stock</th>
				  <th>ROP</th>
                  <th>MLS</th>
                  <th>ROQ</th>
                  <th>Lead Time (Days)</th>
                  <th>Date Received</th>
                  <th>ID Location</th>
                  
                  <th>SAP Number</th>
                  <th>Parts Number</th>
<!--                   <th>Views Today</th>
 -->                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                   // $conn = $pdo->open();

                    try{
                      $now = date('Y-m-d');
                      // $stmt = $conn->prepare("SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id $where ");
                      // $stmt->execute();
                      // foreach($stmt as $row){

                      $sql = " SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty,  products.ownqnty AS ownqnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.vendor ON vendor.id= products.vendor_id $where ";
                      
                      $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 



                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                       
                  //      $vename = $row['vname'];
                        echo "
                          <tr>
                            <td>".$row['prodname']."</td>
                            <td>".$row['vename']."</td>
                         
                            <td>
                              <img src='".$image."' height='30px' width='30px'>
                              <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['prodid']."'><i class='fa fa-edit'></i></a></span>
                            </td>
                            

                            <td><a href='#description' data-toggle='modal' class='btn btn-info btn-sm btn-flat desc' data-id='".$row['prodid']."'><i class='fa fa-search'></i> View</a></td>
                            <td>RM ".number_format($row['price'], 2)."</td>
                          <td>".$row['qnty']."</td>
						  <td>".$row['ownqnty']."</td>
                            <td>".$row['minqnty']."</td>
                            <td>".$row['mls']."</td>
                            <td>".$row['roq']."</td>
                            <td>".$row['leadtime']."</td>
                             <td>".$row['recdate']->format("d/M/y")."</td>
                              <td>".$row['idLoc']."</td>
                              
                               <td>".$row['noSAP']."</td>
                                <td>".$row['noParts']."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['prodid']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['prodid']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                //    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>


     
  </div>
    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/products_modal.php'; ?>
    <?php include 'includes/products_modal2.php'; ?>

</div>
<!-- ./wrapper -->




<?php include 'includes/scripts.php'; ?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.desc', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $('#select_category').change(function(){
    var val = $(this).val();
    if(val == 0){
      window.location = 'products.php';
    }
    else{
      window.location = 'products.php?category='+val;
    }
  });


  $('#addproduct').click(function(e){
    e.preventDefault();
    getCategory();
    getVendor();
  });

  $("#addnew").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

  $("#edit").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

   $("#print").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'products_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#desc').html(response.description);
      $('.name').html(response.prodname);
      $('.prodid').val(response.prodid);
      $('#edit_name').val(response.prodname);
      $('#catselected').val(response.category_id).html(response.catname);
      $('#venselected').val(response.vendor_id).html(response.vename);
      $('#edit_price').val(response.price);
      $('#edit_qnty').val(response.qnty);
      $('#edit_minqnty').val(response.minqnty);
      $('#edit_minqnty1').val(response.mls);
      $('#edit_roq').val(response.roq);
      $('#edit_leadtime').val(response.leadtime);
      $('#edit_recdate').val(response.recdate);
      $('#edit_idLoc').val(response.idLoc);
      $('#edit_noSAP').val(response.noSAP);
      $('#edit_noParts').val(response.noParts);
    
      CKEDITOR.instances["editor2"].setData(response.description);
      getCategory();
      getVendor();
    }
  });
}
function getCategory(){
  $.ajax({
    type: 'POST',
    url: 'category_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#category').append(response);
      $('#edit_category').append(response);
    }
  });
}

function getVendor(){
  $.ajax({
    type: 'POST',
    url: 'vendor_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#vendor').append(response);
      $('#edit_vendor').append(response);
    }
  });
}



</script>
</body>
</html>
