<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-red layout-top-nav">
<div class="wrapper">

  <?php include 'includes/ordertrack.php'; ?>
   
    <div class="content-wrapper">
      <div class="container">

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-sm-9">
              <?php
                if(isset($_SESSION['error'])){
                  echo "
                    <div class='alert alert-danger'>
                      ".$_SESSION['error']."
                    </div>
                  ";
                  unset($_SESSION['success']);
                }

                if (isset($_GET['success'])){
            echo ("<script>alert('Request succesfully sent to Admin! Kindly wait for approval!');</script>");
           }
                
           ?>
         <!--     <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                      <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                      <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                      <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                      <div class="item active">
                        <img src="images/banner1.png" alt="First slide">
                      </div>
                      <div class="item">
                        <img src="images/banner2.png" alt="Second slide">
                      </div>
                      <div class="item">
                        <img src="images/banner3.png" alt="Third slide">
                      </div>
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
                </div>  -->
                <h2>Product Requested List </h2>
              <?php



            $month = date_default_timezone_set( 'UTC');
                
            //    $conn = $pdo->open();

                try{
                  $inc = 4; 
                // $stmt = $conn->prepare("SELECT p.name as name , c.name as catname , p.photo as photo , p.slug as slug , p.qnty as qnty FROM products p LEFT JOIN category c ON c.id=p.category_id ORDER BY name asc");     
                // $stmt->execute();            



                      $sql = "SELECT p.name as name , p.photo as photo , p.slug as slug , sum(d.qtyok) as qtyok FROM sps.products p LEFT JOIN sps.category c ON c.id=p.category_id LEFT JOIN sps.details d ON d.product_id=p.id LEFT JOIN sps.sales s ON s.id=d.sales_id WHERE d.detail_status <> '0' AND d.detail_status <> '3' AND d.detail_status <> '2' GROUP BY p.name,p.photo,p.slug,d.qtyok ";
                      $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options );


                while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                  $image = (!empty($row['photo'])) ? 'images/'.$row['photo'] : 'images/noimage.jpg';
                  $inc = ($inc == 4) ? 1 : $inc + 1;
                    if($inc == 1) echo "<div class='row'>";
                    echo "
                      <div class='col-sm-4'>
                        <div class='box box-solid'>
                          <div class='box-body prod-body'>
                            <img src='".$image."' width='100%' height='230px' class='thumbnail'>
                            <h5><a href='producttrack.php?product=".$row['slug']."'>".$row['name']."</a></h5>
                          </div>
                          <div class='box-footer'>
                            <b>Quantity: ".$row['qtyok']."</b>
                            
                          </div>
                        </div>
                      </div>
                    ";
                    if($inc == 4) echo "</div>";
                }
                if($inc == 1) echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>"; 
              if($inc == 2) echo "<div class='col-sm-4'></div></div>";
              if($inc == 3) echo "<div class='col-sm-4'></div></div>";
            }
            catch(PDOException $e){
              echo "There is some problem in connection: " . $e->getMessage();
            }

            //$pdo->close();

              ?> 
            </div>
            <div class="col-sm-3">
              <?php include 'includes/sidebar.php'; ?>
            </div>
          </div>
        </section>
       
      </div>
    </div>
  
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>
</body>
</html>