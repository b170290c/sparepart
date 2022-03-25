<?php include 'includes/session.php'; ?>
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../DataTables/datatables.js"></script>
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>
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

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Low Stock List
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Products</li>
        <li class="active">Low Stock</li>
      </ol>
    </section>

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
        <!--      <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i class="fa fa-plus"></i> New</a> -->
            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Name</th>
                  <th>Vendor</th>
                  <th>Brand</th>
                  <th>Photo</th>
                  <th>Description</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Own Quantity</th>
                  <th>Date Received</th>
                  <th>ID Location</th>
                  <th>SAP Number</th>
                  <th>Parts Number</th>
                  <th>Serial Number</th>
                  
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                //    $conn = $pdo->open();

                    try{
                      $now = date('Y-m-d');

                      $sql = " SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.ownqnty as ownqnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.vendor ON vendor.id= products.vendor_id WHERE qnty <= minqnty ";


                      $stmt = sqlsrv_query( $conn, $sql  ); 


                      // $stmt = $conn->prepare("SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.ownqnty as ownqnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id WHERE qnty <= minqnty");
                      // $stmt->execute();
                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                        // $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                        echo "
                          <tr>
                            <td>".$row['prodname']."</td>
                            <td>".$row['vename']."</td>
                            <td>".$row['catname']."</td>
                            <td>
                              <img src='".$image."' height='30px' width='30px'>
                              
                            </td>
                            <td><a href='#description' data-toggle='modal' class='btn btn-info btn-sm btn-flat desc' data-id='".$row['prodid']."'><i class='fa fa-search'></i> View</a></td>
                            <td>RM ".number_format($row['price'], 2)."</td>
                            <td>".$row['qnty']."</td>
                            <td>".$row['ownqnty']."</td>
                             <td>".$row['recdate']->format('d-m-Y')."</td>
                              <td>".$row['idLoc']."</td>
                               <td>".$row['noSAP']."</td>
                                <td>".$row['noParts']."</td>
                                <td>".$row['noSerial']."</td>
                           
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['prodid']."'><i class='fa fa-edit'></i> Edit</button>
                           
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                 //   $pdo->close();
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
    <?php include 'includes/lowstock_modal2.php'; ?>

</div>

  <!-- DataTables -->
 
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
  });

  $("#addnew").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

  $("#edit").on("hidden.bs.modal", function () {
      $('.append_items').remove();
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'lowstock_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('#desc').html(response.description);
      $('.name').html(response.prodname);
      $('.prodid').val(response.prodid);
      $('#edit_name').val(response.prodname);
      $('#catselected').val(response.category_id).html(response.catname);
      $('#edit_price').val(response.price);
      $('#edit_qnty').val(response.qnty);
      $('#edit_qnty2').val(response.qnty);
      $('#edit_qnty3').val(response.ownqnty);
      $('#edit_recdate').val(response.recdate);
      $('#edit_idLoc').val(response.idLoc);
      $('#edit_noSAP').val(response.noSAP);
      $('#edit_noParts').val(response.noParts);
      $('#edit_noSerial').val(response.edit_noSerial);
      CKEDITOR.instances["editor2"].setData(response.description);
      getCategory();
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

$(document).ready(function() {
    $('#example1').DataTable( {
      "responsive" : false,
       "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "scrollX" : true,
      "tabIndex" : 1

    } );
} );
</script>
</body>
</html>
