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
$starta = date('d-m-Y', strtotime( $_GET['var1']));
$endb = date('d-m-Y', strtotime( $_GET['var2']));
$reportid = $_GET['var3'];
$title = "Stock Out By Line";

$excelname = $title.' '.$starta.' To '.$endb;
$file = $excelname.".xls";



    header("Content-type: application/vnd-ms-excel");

    header('Content-disposition: attachment; filename='.basename($file));  

   
?>





  <div class="box-body">
              <table id="example"  class="table table-bordered">
               <thead class="thead-dark">
  <br><br>
                <th class="hidden"></th>
                <th>Date</th>
                 <th>Line</th>
                  <th>Quantity</th>    
                  <th>Total Cost</th>     
                   <th>Currency</th>  
                    <th>PIC</th>  
                </thead>
                <tbody>
                  <?php  

$start1=$_GET['var1'];
$end1=$_GET['var2'];

                  $start = $start1.' 00:00:00';
                  $end = $end1.' 23:59:59';

                     

                  
                   try{

                    $sql = " SELECT  users1.line as uline, sales.sales_date, Sum(details.qtyok) as quantity, Sum(products.price*details.qtyok) AS total, users1.firstname as firstname , users1.lastname as lastname FROM sps.details  JOIN sps.products ON details.product_id=products.id  JOIN sps.sales ON sales.id=details.sales_id  JOIN sps.users1 ON users1.id=sales.user_id WHERE sales.sales_date BETWEEN '$start' AND  '$end' AND details.detail_status=1   GROUP BY line,sales_date,qtyok,price,firstname,lastname ";

                     $params = array();
                     $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                     $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 
                      
                      // $stmt = $conn->prepare("SELECT  users1.line as uline, sales.sales_date, Sum(details.qtyok) as quantity, Sum(products.price*details.qtyok) AS total, users1.firstname as firstname , users1.lastname as lastname FROM details  JOIN products ON details.product_id=products.id  JOIN sales ON sales.id=details.sales_id  JOIN users1 ON users1.id=sales.user_id WHERE sales.sales_date BETWEEN '$start' AND  '$end' AND details.detail_status=1  GROUP BY users1.line" );
                      // $stmt->execute();
                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                       $fullname = $row['firstname'].' '.$row['lastname'];
                       
                        $currency = "Malaysian Ringgit (MYR)" ;

                          echo "
                          <tr>
                          <td  class='hidden'></td> 
                          <td align='center'>".$row['sales_date']->format("d/M/y")."</td>
                          <td align='center'>".$row['uline']."</td>
                           <td align='center'>".$row['quantity']."</td>
                           <td align='center'>".$row['total']."</td>
                      
                          <td align='center'>".$currency."</td>
                          <td align='center'>".$fullname."</td>

                          
                          
                          

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