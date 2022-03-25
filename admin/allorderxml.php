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


<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: "Bflrtip",
        buttons: [
         {extend: 'excel', title: 'All Order History'},
                
          ]
    });
} );

</script>

<?php
$start1 = $_GET['var1'];
$end1 = $_GET['var2'];
$reportid = $_GET['var3'];
$title = "All Order History";

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
                <th>Request Date</th>
                <th>Employee Name</th>
                <th>Line</th>
                <th>Status</th>
                <th>Brand</th>
                <th>Product Description</th>
                <th>SAP Number</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Total Cost</th>
                <th>Currency</th>   
                  
                </thead>
                <tbody>
                  <?php
                  //  $conn = $pdo->open();

                    $start = $start1.' 00:00:00';
                    $end = $end1.' 23:59:59';


                   try{

                    $sql = " SELECT *, category.name AS catname, products.name AS prodname FROM sps.details JOIN sps.products ON products.id=details.product_id JOIN sps.category ON category.id=products.category_id JOIN sps.sales on details.sales_id=sales.id JOIN sps.users1 ON users1.id=sales.user_id WHERE sales_date BETWEEN '".$start."' AND  '".$end."'  ORDER BY sales_date DESC ";
                    $stmt = sqlsrv_query($conn , $sql);
                      
                      // $stmt = $conn->prepare("SELECT *, category.name AS catname, products.name AS prodname  FROM details JOIN products ON products.id=details.product_id JOIN category ON category.id=products.category_id JOIN sales on details.sales_id=sales.id JOIN users1 ON users1.id=sales.user_id WHERE sales_date BETWEEN '$start' AND  '$end'  ORDER BY sales_date DESC" );
                      // $stmt->execute();
                       while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $fullname = $row['firstname'].' '.$row['lastname'];
                       $total = $row['price']*$row['qtyok'];
                        $currency = "Malaysian Ringgit (MYR)" ;

                        $statusCode = $row['detail_status'];
                         if($statusCode == 1){
                              $statusCode = "Approved";
                          }
                          elseif($statusCode == 2){
                              $statusCode= "Rejected";
                          }
                          elseif($statusCode == 3){
                              $statusCode= "Item Returned";
                          }
                           elseif($statusCode == 0){
                              $statusCode= "Pending Request";
                          }
                                                
                  
                          echo "
                          <tr>
                          <td  class='hidden'></td> 
                          <td align='center'>".date('d.M.y', strtotime($row['sales_date']))."</td>
                          <td align='center'>".$fullname.' '.'('.$row['empid'].')'."</td>
                          <td align='center'>".$row['line']."</td>
                          <td align='center'>".$statusCode."</td>
                          <td align='center'>".$row['catname']."</td>
                          <td align='center'>".$row['prodname']."</td>                            
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['qtyok']."</td>                            
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