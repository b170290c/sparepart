<?php include 'includes/session.php'; ?>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>


<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<script type="text/javascript" src="../DataTables/DataTables-1.10.23/js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $_GET['var1']; ?> -> <?php echo  $_GET['var2']; ?></title>


<section class="content">
      <div class="row">
<div class="container">




<?php
$start1 = $_GET['var1'];
$end1 = $_GET['var2'];
$reportid = $_GET['var3'];
$title = "Scrap Report";

$excelname = $title.' '.$start1.' To '.$end1;
$file = $excelname.".xls";


    header("Content-type: application/vnd-ms-excel");

    header('Content-disposition: attachment; filename='.basename($file));  

   
?>





  <div class="box-body">
              <table id="example"  class="table table-bordered">
               <thead class="thead-dark">
  <br><br>
                <th class="hidden"></th>
               
                <th>SAP Number</th>
                <th>Part Number</th>
                <th>Brand</th>
                <th>Product Description</th>
                <th>Date</th>
                <th>Line</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Total Cost</th>
                <th>Currency</th>
                  
                  
                  
                  
                </thead>
                <tbody>
                  <?php
                   // $conn = $pdo->open();

                    $start = $start1.' 00:00:00';
                    $end = $end1.' 23:59:59';




                   try{

                      
                      // $stmt = $conn->prepare("SELECT p.name as prodname, r.badqty as quantity, p.price as price,  u.line as line , r.time as date, p.noSerial as noSerial, p.noSAP as noSAP , p.noParts as noParts, c.name AS brand  FROM rdetails r LEFT JOIN sales s ON s.id=r.sales_id LEFT JOIN users1 u ON u.id=s.user_id LEFT JOIN products p ON p.id=r.product_id LEFT JOIN category c ON c.id=p.category_id WHERE r.time BETWEEN '$start' AND '$end' AND r.retstat=3 AND r.badqty<>3   ORDER BY r.time DESC" );
                      // $stmt->execute();
                      // foreach($stmt as $row){

                    $sql = " SELECT p.name as prodname, r.badqty as quantity, p.price as price,  u.line as line , r.time as date, p.noSerial as noSerial, p.noSAP as noSAP , p.noParts as noParts, c.name AS brand  FROM sps.rdetails r LEFT JOIN sps.sales s ON s.id=r.sales_id LEFT JOIN sps.users1 u ON u.id=s.user_id LEFT JOIN sps.products p ON p.id=r.product_id LEFT JOIN sps.category c ON c.id=p.category_id WHERE r.time BETWEEN '$start' AND '$end' AND r.retstat=3 AND r.badqty<>3   ORDER BY r.time DESC ";
                    $params = array();
                     $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                     $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 

                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        
                       $total = $row['price']*$row['quantity'];
                        $currency = "Malaysian Ringgit (MYR)" ;
                       // $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                          
                  
                          echo "
                          <tr>
                          <td  class='hidden'></td> 

                          
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['noParts']."</td>
                          <td align='center'>".$row['brand']."</td>
                          <td align='center'>".$row['prodname']."</td>                            
                          <td align='center'>".$row['date']->format("d/M/y")."</td>
                          <td align='center'>".$row['line']."</td>
                          <td align='center'>".$row['quantity']."</td>                            
                          <td align='center'>".$row['price']."</td>                          
                          <td align='center'>".$total."</td>
                          <td align='center'>".$currency."</td>
                          
                          
                          

                          ";  
                          
                          echo "</tr>" ;

      
                            }
                          }
     

                            
                  
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }
     





      ?>



              </table>
            </div>
</div>

</div>
</section>