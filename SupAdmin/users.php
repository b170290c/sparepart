<?php
include ('session.php');


include ('conn1.php');
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
           
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
            <h1> ALL USERS REGISTRATION FORM </h1>
        <!-- Begin Page Content -->
        <div class="container-fluid">

        <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="users_modal.php" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="adduser"><i class="fa fa-plus"></i> New</a> <br><br>
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
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM users1 ");
                      $stmt->execute();
                      foreach($stmt as $row){
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

                            <td>".date('M d, Y', strtotime($row['created_on']))."</td>
                            <td>
                              
                               <a button class='btn btn-success btn-sm edit btn-flat' href=\"useredit.php?id=$row[id]\">Edit</a> 
                              <a button class='btn btn-danger btn-sm delete btn-flat' href=\"userdelete.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
<br><br>
            <h1> SUPER ADMIN REGISTRATION FORM </h1>
            <div class="box">
            <div class="box-header with-border">
              <a href="admin_modal.php" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addadmin"><i class="fa fa-plus"></i> New</a> <br><br>
            </div>

             <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
               <th>Admin Batch ID</th>
                  <th>Admin Name</th>
                  <th>Status Level</th>
  
                  <th>Date Modified</th>
                  <th>Tools</th>
                </thead> 
                  <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM sadmin ");
                      $stmt->execute();
                      foreach($stmt as $row){
                        $status = "Super Admin";
                       
                     


                     //   $status = ($row['status']) ? '<span class="label label-success">active</span>' : '<span class="label label-danger">not verified</span>';
                       // $active = (!$row['status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['id'].'"><i class="fa fa-check-square-o"></i></a></span>' : '';
                        echo "
                          <tr>
                            
                            <td>".$row['empID']."</td>
                            <td>".$row['uname']."</td>
                            <td>".$status."</td>

         
                           
    
                             ";



                         //   <td>".$type ."</td>



echo "

                            <td>".date('M d, Y', strtotime($row['date_mod']))."</td>
                            <td>
                              
                              <a button class='btn btn-success btn-sm edit btn-flat' href=\"adminedit.php?id=$row[id]\">Edit</a> 
                              <a button class='btn btn-danger btn-sm delete btn-flat' href=\"admindelete.php?id=$row[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
                            </td>
                          </tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?>
                </tbody>
              </table>
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

