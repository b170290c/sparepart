<?php
include_once("conn.php");

if(isset($_POST['update']))
{	

	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$uname = mysqli_real_escape_string($conn, $_POST['uname']);	
	$password = mysqli_real_escape_string($conn, $_POST['password']);	
	$empID = mysqli_real_escape_string($conn, $_POST['empID']);
	
    $password = password_hash($password, PASSWORD_DEFAULT);
		
		//updating the table
		$result = mysqli_query($conn, "UPDATE sadmin SET empID='$empID', uname='$uname',password='$password' WHERE id=$id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: users.php");

}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($conn, "SELECT * FROM sadmin WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	$uname = $res['uname'];
	$password = $res['password'];
	$empID = $res['empID'];

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
   

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

  
	<a href="users.php">Back</a>
	<br/><br/>
	
	<form name="form1" method="post" action="adminedit.php">
		<div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="username" class="form-control" id="uname" name="uname" value="<?php echo $uname;?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" value="<?php echo $password;?>" required>
                    </div>
                </div>
                 
               
                <div class="form-group">
                    <label for="empID" class="col-sm-3 control-label">Employee ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="empID" name="empID" value="<?php echo $empID;?>" required>
                    </div>
                </div>
               
		
			<div class="modal-footer">
				<input type="hidden" name="id" value=<?php echo $_GET['id'];?>></td>
				<input type="submit" name="update" value="Update"></td>
	
	</form>
</div>

         


      </div>
  </div>
</div>
 

  <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>