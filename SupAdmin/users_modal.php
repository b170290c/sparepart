<?php
include ('session.php');


include ('conn.php');
date_default_timezone_set("Asia/Kuala_Lumpur");
  $today = date('Y-m-d');
  $year = date('Y');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>

   

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Spare Part Super Admin</title>
<!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Custom style for url -- adding icon-->
  <link rel="shortcut icon" type="image/x-icon" href="image/ub.png">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
 <aside id="sidebar" class="column">
          <!-- Begin Search -->
   
        <!-- End Search -->
    <hr/>
      <h3> SomStore Database Backup:</h3>
    <ul class="toggle">
        <li class="icn_folder"><a href="Backup.php">Backup Database</a></li>
    </ul>
    
    <h3>Reports:</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="report.php">Report</a></li>

        
    </ul>


    
    <h3>Administrator:</h3>
    <ul class="toggle">
        <li class="icn_add_user"><a href="users.php">View Employees</a></li>
      <li class="icn_photo"><a href="add_product.php">View Product</a></li>
      <!-- <li class="icn_tags"><a href="add_warehouse.php">Add Warehouse</a></li>
      <li class="icn_new_article"><a href="add_category.php">Add Category</a></li> -->
    
    </ul>
    
        <!-- <h3>Tables:</h3>
    <ul class="toggle">
        <li class="icn_categories"><a href="order.php">Order Detial</a></li>
        <li class="icn_categories"><a href="customerTable.php">Customer Detail</a></li>
    </ul> -->

    <h3>Admin</h3>
    <ul class="toggle">
      <li class="icn_jump_back"><a href="index.php">Dashboard</a></li>

      <li class="icn_jump_back"><a href="logout.php">Logout</a></li>
    </ul>
  
  </aside><!-- end of sidebar -->
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

          
        

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline small" style="color:#d51709;">Welcome <?php echo $_SESSION['empID']; ?></span>

              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2" style="color:#d51709;"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

         <!-- Add -->

              <h4 class="modal-title"><b>Add New User</b></h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" method="POST" action="users_add.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="username" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="empid" class="col-sm-3 control-label">Employee ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="empid" name="empid" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="plant" class="col-sm-3 control-label">Plant</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="plant" name="plant" required>
                      <option value="" selected disabled> Select Plant </option>
                                         <?php
        include "conn.php";  // Using database connection file here
        $records = mysqli_query($conn, "SELECT name From plant ORDER BY name ASC");  // Use select query here 

        while($data = mysqli_fetch_array($records))
        {
            echo "<option value='". $data['name'] ."'>" .$data['name'] ."</option>";  // displaying data in option menu
        } 
    ?>  
                    </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="line" class="col-sm-3 control-label">Line</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="line" name="line" required>
                      <option value="" selected disabled> Select Line</option>

                      <?php
        include "conn.php";  // Using database connection file here
        $records = mysqli_query($conn, "SELECT name From line ORDER BY name ASC");  // Use select query here 

        while($data = mysqli_fetch_array($records))
        {
            echo "<option value='". $data['name'] ."'>" .$data['name'] ."</option>";  // displaying data in option menu
        } 
    ?>  
                    </select>
                    </div>
                </div>
                   <div class="form-group">
                    <label for="type" class="col-sm-3 control-label">Access Type</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="type" name="type" required>
                      <option value="" selected disabled> Select Access Type</option>
                      <option value = '0'>User</option>
                      <option value = '1'>Admin</option>
                    </select>
                    </div>
                </div>


              
            </div>
            <div class="modal-footer">
              <button type="button" onclick="location.href = 'users.php';"  class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
              <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
              </form>
            </div>
        </div>
    </div>
</div>


         


      </div>
  </div>
</div>
 

  <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

