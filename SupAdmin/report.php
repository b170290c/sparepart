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
        
    <hr/>
      <h3> Spare Part Database Backup:</h3>
    <ul class="toggle">
        <li class="icn_folder"><a href="backup.php">Backup Database</a></li>
    </ul>
    
    <h3>Reports:</h3>
    <ul class="toggle">
        <li class="icn_settings"><a href="report.php">Report</a></li>
        <li class="icn_settings"><a href="products_print.php">Inventory Report</a></li>

        
    </ul>


    
    <h3>Administrator:</h3>
    <ul class="toggle">
        <li class="icn_add_user"><a href="users.php">View Employees</a></li>
      <li class="icn_photo"><a href="products.php">View Product</a></li>
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
 <section class="content">
      <div class="row">

 <div class="container" align="content-center" >

<form method="post" action="export.php" target="_blank" rel="noreferrer noopener">
  <input type="hidden" name="report">
  
 <div>

 <strong>Reports: </strong> <select id="report" name="report_id" >
                            <option selected disabled>Choose Report</option>
                            <option value="summary">Summary Report</option>
                            <option value="all order history">All Order History</option>
                            <option value="stock in">Stock Intake</option>
                           <option value="stock out">Stock Out</option>
                       </select>

<br><br>

        <label for="fname">Start Date</label>
        <input type="Date" id="sdate" name="startdate" required> &nbsp; &nbsp;
    
        <label for="lname">End Date</label>      
        <input type="Date" id="edate" name="enddate" required  >
      
      
    </div> 
<br>
    
<br>
    
      <input type="submit" style="background: green" value='Generate PDF'> &nbsp; &nbsp;&nbsp; &nbsp; 


      <input type="submit" style="background: cyan" formaction="xmlexport.php" value="Generate Excel">
   </form>
  </div>
  
 
    
</div>
</section>
         

         


      </div>
  </div>
</div>
 

  <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>

