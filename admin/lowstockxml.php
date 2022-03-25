
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
$title = "Low Stock Quantity";

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
             
                <th>SAP</th>
                <th>Part No.</th>
                <th>Vendor</th>
                <th>Brand</th>
                <th>Product Description</th>
                <th>Date In</th>
                <th>ROP</th>
                <th>MLS</th>
                <th>ROQ</th>
                <th>Lead Time</th> 
                <th>Quantity</th> 
                 <th>Cost</th> 
                  <th>Total Cost</th>     
                   <th>Currency</th>  
                </thead>
                <tbody>
                  <?php  
$start1=$_GET['var1'];
$end1=$_GET['var2'];

                  $start = $start1.' 00:00:00';
                  $end = $end1.' 23:59:59';

        

                  
                   try{
                      
                      // $stmt = $conn->prepare("SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id WHERE qnty <= minqnty" );
                      // $stmt->execute();
                      // foreach($stmt as $row){

                    $sql = " SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.vendor ON vendor.id= products.vendor_id WHERE qnty <= minqnty ";
                     $params = array();
                     $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                     $stmt = sqlsrv_query( $conn, $sql , $params, $options );

                     while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                      
                       $total = $row['price']*$row['qnty'];
                       $total = number_format($total,2); 
                        $currency = "Malaysian Ringgit (MYR)" ;

                          echo "
                          <tr>
                          <td  class='hidden'></td> 
                         
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['noParts']."</td>
                          <td align='center'>".$row['vename']."</td>
                          <td align='center'>".$row['catname']."</td>
                          <td align='center'>".$row['prodname']."</td>     
                          <td align='center'>".$row['recdate']->format("d/M/y")."</td>                       
                          <td align='center'>".$row['minqnty']."</td>   
                          <td align='center'>".$row['mls']."</td>   
                           <td align='center'>".$row['roq']."</td>
                           <td align='center'>".$row['leadtime']."</td>
                           <td align='center'>".$row['qnty']."</td>
                           <td align='center'>".number_format($row['price'],2)."</td>
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