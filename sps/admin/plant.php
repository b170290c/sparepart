<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>


  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />

  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/menubar.php'; ?>
  <?php include 'includes/navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Plant
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Products</li>
        <li class="active">Plant</li>
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Plant Name</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                   // $conn = $pdo->open();

                    try{
                      // $stmt = $conn->prepare("SELECT * FROM plant ORDER BY name asc");
                      // $stmt->execute();
                      // foreach($stmt as $row){

                      	$sql = " SELECT * FROM sps.plant ORDER BY name asc " ;
                      	 $stmt = sqlsrv_query( $conn, $sql);

                      	 while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        echo "
                          <tr>
                            <td>".$row['name']."</td>
                            <td>
                              <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['id']."'><i class='fa fa-edit'></i> Edit</button>
                              <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."'><i class='fa fa-trash'></i> Delete</button>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                   // $pdo->close();
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
    <?php include 'includes/plant_modal.php'; ?>

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

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'plant_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.plantid').val(response.id);
      $('#edit_name').val(response.name);
      $('.plantname').html(response.name);
    }
  });
}
</script>
</body>
</html>