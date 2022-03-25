<?php 
  include 'includes/session.php';
  include 'includes/format.php'; 
?>



  <link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>

<?php 
date_default_timezone_set("Asia/Kuala_Lumpur");
  $today = date('Y-m-d');
  $year = date('Y');
  $month = date('F');
  if(isset($_GET['year'])){
    $year = $_GET['year'];
  }
  if(isset($_GET['month'])){
    $month = $_GET['month'];
  }

//  $conn = $pdo->open();
?>
<!-- Preloader -->

    
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div  class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
      <!-- Small boxes (Stat box) -->
      <div id="content2" class="row">
        <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <?php

              $sql = " SELECT * FROM sps.details LEFT JOIN sps.products ON products.id=details.product_id INNER JOIN sps.sales ON details.sales_id=sales.id WHERE YEAR(sales_date)= '".$year."' ";

              $stmt = sqlsrv_query( $conn, $sql );


                // $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id INNER JOIN sales ON details.sales_id=sales.id WHERE YEAR(sales_date)=:year ");
                // $stmt->execute(['year'=>$year]);

                $total = 0;
                 while($srow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                  $subtotal = $srow['price']*$srow['qtyok'];
                  $total += $subtotal;
                }

                echo "<h3>RM ".number_format($total, 2)."</h3>";
              ?>
              <p>Total Cost For <?php echo $year; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
         <!--   <a href="sales.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>-->
          </div> 
        </div>
      
        <!-- ./col -->
        <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <?php

              $sql = " SELECT COUNT(*) AS numrows FROM sps.products  ";
              $stmt = sqlsrv_query($conn , $sql);
              $prow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


                // $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products");
                // $stmt->execute();
                // $prow =  $stmt->fetch();

                echo "<h3>".$prow['numrows']."</h3>";
              ?>
          
              <p>Number of Products</p>
            </div>
            <div class="icon">
              <i class="fa fa-product-hunt" aria-hidden="true"></i>
            </div>
            <a href="products.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      
 

        <!-- ./col -->
        <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-red">
            <div id="ref" class="inner">
              <?php

              $sql = " SELECT COUNT(*) AS numrows FROM sps.details WHERE detail_status=0  ";
              $stmt = sqlsrv_query($conn , $sql);
              $prow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);
                // $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM details WHERE detail_status=0");
                // $stmt->execute();
                //  $prow =  $stmt->fetch();
               
                echo "<h3>".$prow['numrows']."</h3>";
                
              ?>

              <p>Pending Request</p>
            </div>
            <div class="icon">
              <i class="fa fa-check"></i>
            </div>
            <a href="sales.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
          <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div id=ref2 class="inner">
              <?php


               $sql = " SELECT COUNT(*) AS numrows FROM sps.products WHERE qnty<=minqnty  ";
              $stmt = sqlsrv_query($conn , $sql);
              $prow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


                // $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE qnty <= minqnty");
                // $stmt->execute();
                // $prow =  $stmt->fetch();

                echo "<h3>".$prow['numrows']."</h3>";
              ?>
          
              <p>Low Stock Product</p>
            </div>
            <div class="icon">
              <i class="fa fa-warning"></i>
            </div>
            <a href="lowstock.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

<!-- ./col -->
        <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div id="ref3" class="inner">
              <?php

              $sql = " SELECT COUNT(*) AS numrows FROM sps.rdetails WHERE retstat <> 3  ";
              $stmt = sqlsrv_query($conn , $sql);
              $prow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


                // $stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM rdetails WHERE retstat <> 3; ");
                // $stmt->execute();
                // $prow =  $stmt->fetch();

                echo "<h3>".$prow['numrows']."</h3>";
              ?>
          
              <p>User Return Product</p>
            </div>
            <div class="icon">
              <i class="fa fa-retweet"></i>
            </div>
            <a href="return.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

           <div class="col-sm-4">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div id="ref3" class="inner">
              <?php

               $sql = " SELECT  SUM(r.badqty) AS numrows FROM sps.rdetails r WHERE r.badqty <> 0 AND MONTH(r.time) = MONTH(GETDATE())  GROUP BY r.badqty  ";
              $stmt = sqlsrv_query($conn , $sql);
              $prow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC);


                // $stmt = $conn->prepare("SELECT  SUM(r.badqty) AS numrows FROM rdetails r WHERE r.badqty <> 0 AND MONTH(r.time) = MONTH(CURRENT_DATE())   GROUP BY r.badqty; ");
                // $stmt->execute();
                // $prow =  $stmt->fetch();

                echo "<h3>".$prow['numrows']."</h3>";
              ?>
          
              <p>Scrap Quantity For <?php echo $month; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-trash"></i>
            </div>
            <a href="dbody.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>

          </div>
        </div>
     
      </div>


      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Monthly Sales Report</h3>
              <div class="box-tools pull-right">
                <form class="form-inline">
                  <div class="form-group">
                    <label>Select Year: </label>
                    <select class="form-control input-sm" id="select_year">
                      <?php
                        for($i=2021; $i<=2065; $i++){
                          $selected = ($i==$year)?'selected':'';
                          echo "
                            <option value='".$i."' ".$selected.">".$i."</option>
                          ";
                        }
                      ?>
                    </select>
                  </div>
                </form>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <br>
                <div id="legend" class="text-center"></div>
                <canvas id="barChart" style="height:350px"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>



     

      </section>
      <!-- right col -->
    </div>
  	<?php include 'includes/footer.php'; ?>

</div>
<!-- ./wrapper -->

<!-- Chart Data -->
<?php
  $months = array();
  $sales = array();
  for( $m = 1; $m <= 12; $m++ ) {
    try{

      $sql = " SELECT * FROM sps.details LEFT JOIN sps.sales ON sales.id=details.sales_id LEFT JOIN sps.products ON products.id=details.product_id WHERE MONTH(sales_date)='".$m."' AND YEAR(sales_date)='".$year."' ";
      $stmt = sqlsrv_query($conn , $sql);


      // $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN sales ON sales.id=details.sales_id LEFT JOIN products ON products.id=details.product_id WHERE MONTH(sales_date)=:month AND YEAR(sales_date)=:year");
      // $stmt->execute(['month'=>$m, 'year'=>$year]);
      $total = 0;
       while($srow = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
        $subtotal = $srow['price']*$srow['qtyok'];
        $total += $subtotal;    
      }
      array_push($sales, round($total, 2));
    }
    catch(PDOException $e){
      echo $e->getMessage();
    }

    $num = str_pad( $m, 2, 0, STR_PAD_LEFT );
    $month =  date('M', mktime(0, 0, 0, $m, 1));
    array_push($months, $month);
  }

  $months = json_encode($months);
  $sales = json_encode($sales);

?>
<!-- End Chart Data -->



<?php  sqlsrv_close($conn); ?>
<?php include 'includes/scripts.php'; ?>

<script type="text/javascript" src="js/jquery-3.5.1.js">



var vTimeOut;

$(function() {
  vTimeOut= setTimeout(startRefresh, 1000)
});


function startRefresh() {
  clearInterval(vTimeOut);
  vTimeOut= setTimeout(startRefresh, 1000);
  $("#ref").load(" #ref");
  $("#ref2").load(" #ref2");
  $("#ref3").load(" #ref3");
}

</script>


<script>
$(function(){
  var barChartCanvas = $('#barChart').get(0).getContext('2d')
  var barChart = new Chart(barChartCanvas)
  var barChartData = {
    labels  : <?php echo $months; ?>,
    datasets: [
      {
        label               : 'SALES',
        fillColor           : 'rgba(60,141,188,0.9)',
        strokeColor         : 'rgba(60,141,188,0.8)',
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : <?php echo $sales; ?>
      }
    ]
  }
  //barChartData.datasets[1].fillColor   = '#00a65a'
  //barChartData.datasets[1].strokeColor = '#00a65a'
  //barChartData.datasets[1].pointColor  = '#00a65a'
  var barChartOptions                  = {
    //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
    scaleBeginAtZero        : true,
    //Boolean - Whether grid lines are shown across the chart
    scaleShowGridLines      : true,
    //String - Colour of the grid lines
    scaleGridLineColor      : 'rgba(0,0,0,.05)',
    //Number - Width of the grid lines
    scaleGridLineWidth      : 1,
    //Boolean - Whether to show horizontal lines (except X axis)
    scaleShowHorizontalLines: true,
    //Boolean - Whether to show vertical lines (except Y axis)
    scaleShowVerticalLines  : true,
    //Boolean - If there is a stroke on each bar
    barShowStroke           : true,
    //Number - Pixel width of the bar stroke
    barStrokeWidth          : 2,
    //Number - Spacing between each of the X value sets
    barValueSpacing         : 5,
    //Number - Spacing between data sets within X values
    barDatasetSpacing       : 1,
    //String - A legend template
    legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
    //Boolean - whether to make the chart responsive
    responsive              : true,
    maintainAspectRatio     : true
  }

  barChartOptions.datasetFill = false
  var myChart = barChart.Bar(barChartData, barChartOptions)
  document.getElementById('legend').innerHTML = myChart.generateLegend();
});
</script>
<script>
$(function(){
  $('#select_year').change(function(){
    window.location.href = 'home.php?year='+$(this).val();
  });
});
</script>







</body>
</html>
