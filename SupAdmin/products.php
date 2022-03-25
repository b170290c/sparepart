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
 

  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
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
             
            </li>

          </ul>

        </nav>
      </div>

        <!-- End of Topbar -->

        <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js">

  <!-- Bootstrap core JavaScript-->
 <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>




        <!-- Begin Page Content -->
<?php include ('conn.php');
$query =" SELECT *, products.name as pname, vendor.name as vename, category.name as catname FROM products LEFT JOIN vendor ON vendor.id=products.vendor_id LEFT JOIN category ON category.id=products.category_id ORDER BY pname ASC";  
 $result = mysqli_query($conn, $query);  
 ?>   
  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
           <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
           <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  
      </head>  
      <body>  
           <br /><br /> 
      
           
            
           <div class="container">  
                <div class="table-responsive">  
                     <table id="example" class="table table-striped table-bordered">  
                          <thead>  
                               <tr>  
                                     <th>Name</th>
                                     <th>Photo</th>
                 <th>Vendor</th>
                 <th>Brand</th>

                  
                  <th>Price</th>
                  <th>Ready Stock</th>
                  <th>ROP</th>
                  <th>MLS</th>
                  <th>ROQ</th>
                  <th>Lead Time</th>
                  <th>Date Received</th>
                  <th>ID Location</th>
                  <th>Serial Number</th>
                  <th>SAP Number</th>
                  <th>Parts Number</th> 
              <!--     <th>Tools</th> -->

                               </tr>  
                          </thead>  
                          <?php  
                          while($row = mysqli_fetch_array($result))  
                          {
                            $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                        // $counter = ($row['date_view'] == $now) ? $row['counter'] : 0;
                               // echoing the fetched data from the database per column names
                               echo "
                          <tr>
                            <td>".$row['pname']."</td><td>
                              <img src='".$image."' height='30px' width='30px'>
                              
                            </td>
                             <td>".$row['vename']."</td>
                              <td>".$row['catname']."</td>
                         
                            
                            <td>RM ".number_format($row['price'], 2)."</td>
                            <td>".$row['qnty']."</td>
                            <td>".$row['minqnty']."</td>
                            <td>".$row['mls']."</td>
                            <td>".$row['roq']."</td>
                            <td>".$row['leadtime']."</td>
                             <td>".$row['recdate']."</td>
                              <td>".$row['idLoc']."</td>
                              <td>".$row['noSerial']."</td>
                               <td>".$row['noSAP']."</td>
                                <td>".$row['noParts']."</td>
                                

                           
                           

                          </tr>
                        ";
                          }  
                          ?>  
                     </table>  
                </div>  
           </div>  
      </body>  
 </html>  
 <script>  
$(document).ready(function() {
    $('#example').DataTable( {
   //   dom :'<"pull-left" f><t>',
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

