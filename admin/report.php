<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>

<body class="hold-transition skin-red sidebar-mini">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


  <?php include 'includes/menubar.php'; ?>
  <?php include 'includes/navbar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
        Reports
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Report List</li>
      </ol>
    </section>
  <!--   <script type="text/javascript">

   function changeFunc() {
    var report = document.getElementById("report");
    var selectedValue = report.options[report.selectedIndex].value;
    alert(selectedValue);
   }

  </script>
 -->
    <!-- Main content -->
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
                            <option value="stock in">Stock Entry</option>
                           <option value="stock out">Stock Withdrawal By Line</option>
                            <option value="low stock">Low Quantity Stock</option>
                            <option value="scrap">Scrap Report</option>
                            
                       </select>

<br><br>

        <label for="fname">Start Date</label>
        <input type="Date" id="sdate" name="startdate" required > &nbsp; &nbsp;
    
        <label for="lname">End Date</label>      
        <input type="Date" id="edate" name="enddate" required >


        
      
      
    </div> 
<br>
    
<br>
    
      <input type="submit" style="background: cyan" value='Generate PDF'> &nbsp; &nbsp;&nbsp; &nbsp; 


      <input type="submit" style="background: cyan" formaction="xmlexport.php" value="Generate Excel">
   </form>
  </div>
  
 
    
</div>
</section>
</div>

    
<?php include 'includes/footer.php'; ?>
<?php include 'includes/profile_modal.php'; ?>


<!-- ./wrapper -->
<?php include 'includes/scripts.php'; ?>

<script>

</script>
</body>

</html>
