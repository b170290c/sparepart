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

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
      </ol>
    </section>
<script>

$(document).ready(function() {
    $('#example1').DataTable({
        dom: "flrtip",
        // buttons: [
        //  {extend: 'Copy', title: 'Copy Table'}
               
        //   ]
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
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="adduser"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th>Photo</th>
                  <th>Username</th>
                  <th>Name</th>
                  <th>Employee ID</th>
                  <th>Plant Name</th>
                  <th>Line Name</th>
                  <th>Status Level</th>
                  <th>Date Added</th>
                  <th>Tools</th>
                </thead>
                <tbody>
                  <?php
                    //$conn = $pdo->open();

                    try{
                      // $stmt = $conn->prepare("SELECT * FROM users1 WHERE type = 0 ");
                      // $stmt->execute();
                      // foreach($stmt as $row){

                      $sql = " SELECT * FROM sps.users1 WHERE type = '0' ";
                        $params = array();
             $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
             $stmt = sqlsrv_query( $conn, $sql , $params, $options );

              while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/profile.jpg';
                        $type = $row['type'];



                     //   $status = ($row['status']) ? '<span class="label label-success">active</span>' : '<span class="label label-danger">not verified</span>';
                       // $active = (!$row['status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-check-square-o"></i></a></span>' : '';
                        echo "
                          <tr>
                            <td>
                              <img src='".$image."' height='30px' width='30px'>
                              <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['id']."'><i class='fa fa-edit'></i></a></span>
                            </td>
                            <td>".$row['username']."</td>
                            <td>".$row['firstname'].' '.$row['lastname']."</td>
                            <td>".$row['empid']."</td>
                            <td>".$row['plant']."</td>
                            <td>".$row['line']."</td> ";



if ($type == '1') {
	echo "<td>Admin</td>";
}
elseif($type == '0'){
	echo "<td>User</td>";
}

                         //   <td>".$type ."</td>



echo "

                            <td>".$row['created_on']->format("d/M/y")."</td>
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
    <?php include 'includes/users_modal.php'; ?>

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

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });
  $('#adduser').click(function(e){
    e.preventDefault();
    getPlant();
    getLine();
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
    url: 'users_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.userid').val(response.id);
      $('#edit_username').val(response.username);
      $('#edit_password').val(response.password);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_empid').val(response.empid);
      $('#plantselected').val(response.plant).html(response.plant);
      $('#lineselected').val(response.line).html(response.line);
      $('#edit_type').val(response.type);

      $('.fullname').html(response.firstname+' '+response.lastname);
      getPlant();
      getLine();
    }
  });
}

function getPlant(){
  $.ajax({
    type: 'POST',
    url: 'plant_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#plant').append(response);
      $('#edit_plant').append(response);
    }
  });
}

function getLine(){
  $.ajax({
    type: 'POST',
    url: 'line_fetch.php',
    dataType: 'json',
    success:function(response){
      $('#line').append(response);
      $('#edit_line').append(response);
    }
  });
}
</script>
</body>
</html>
