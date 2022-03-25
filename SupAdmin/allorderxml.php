
<?php include 'conn1.php';  ?>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet"/>
<link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet"/>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/pdfmake.min.js"></script>

<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.bootstrap.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

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
               
                <th>Product Description</th>
                <th>SAP Number</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Total Cost</th>
                <th>Currency</th>   
                  
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    $start = $start1.' 00:00:00';
                    $end = $end1.' 23:59:59';


                   try{
                      
                      $stmt = $conn->prepare("SELECT * FROM details INNER JOIN products ON products.id=details.product_id
                                             INNER JOIN sales on details.sales_id=sales.id
                                             INNER JOIN users1 ON users1.id=sales.user_id
                                             WHERE sales_date BETWEEN '$start' AND '$end'
                                             ORDER BY sales_date DESC" );
                      $stmt->execute();
                      foreach($stmt as $row){
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
                         
                          <td align='center'>".$row['name']."</td>                            
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