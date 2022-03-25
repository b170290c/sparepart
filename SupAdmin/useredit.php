<?php
include_once("conn.php");

if(isset($_POST['update']))
{	

	$id = mysqli_real_escape_string($conn, $_POST['id']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);	
	$password = mysqli_real_escape_string($conn, $_POST['password']);	
	$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
	$empid = mysqli_real_escape_string($conn, $_POST['empid']);
	$plant = mysqli_real_escape_string($conn, $_POST['plant']);
	$line = mysqli_real_escape_string($conn, $_POST['line']);		
  
	$password = password_hash($password, PASSWORD_DEFAULT);
		
		//updating the table
		$result = mysqli_query($conn, "UPDATE users1 SET username='$username',password='$password',firstname='$firstname' , lastname='$lastname' , empid='$empid' , plant='$plant', line='$line' WHERE id=$id");
		
		//redirectig to the display page. In our case, it is index.php
		header("Location: users.php");

}
?>
<?php
//getting id from url
$id = $_GET['id'];

//selecting data associated with this particular id
$result = mysqli_query($conn, "SELECT * FROM users1 WHERE id=$id");

while($res = mysqli_fetch_array($result))
{
	$username = $res['username'];
	$password = $res['password'];
	$firstname = $res['firstname'];
	$lastname = $res['lastname'];
	$empid = $res['empid'];
	$plant = $res['plant'];
	$line = $res['line'];

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
   

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

  
	<a href="users.php">Back</a>
	<br/><br/>
	
	<form name="form1" method="post" action="useredit.php">
		<div class="form-group">
                    <label for="username" class="col-sm-3 control-label">Username</label>

                    <div class="col-sm-9">
                      <input type="username" class="form-control" id="username" name="username" value="<?php echo $username;?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>

                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="password" name="password" value="<?php echo $password;?>" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label for="firstname" class="col-sm-3 control-label">Firstname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstname;?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastname" class="col-sm-3 control-label">Lastname</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastname;?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="empid" class="col-sm-3 control-label">Employee ID</label>

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="empid" name="empid" value="<?php echo $empid;?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="plant" class="col-sm-3 control-label">Plant</label>

                    <div class="col-sm-9">
                      <select class="form-control" id="plant" name="plant" required>
                      <option value="<?php echo $plant;?>" selected ><?php echo $plant;?></option>
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
                      <option value="<?php echo $line;?>" selected ><?php echo $line;?></option>

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





