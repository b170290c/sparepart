
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
                <th>S/N</th>
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

                  $servername = "localhost";
                  $username = "root";
                  $password = "root";

                  try {
                    $conn = new PDO("mysql:host=$servername;dbname=sps", $username, $password);
                    // set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo "Connected successfully";
                  } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                  }

        

                  
                   try{
                      
                      $stmt = $conn->prepare("SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM products LEFT JOIN category ON category.id=products.category_id LEFT JOIN vendor ON vendor.id= products.vendor_id WHERE qnty <= minqnty" );
                      $stmt->execute();
                      foreach($stmt as $row){
                      
                       $total = $row['price']*$row['qnty'];
                       $total = number_format($total,2); 
                        $currency = "Malaysian Ringgit (MYR)" ;

                          echo "
                          <tr>
                          <td  class='hidden'></td> 
                          <td align='center'>".$row['noSerial']."</td>
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['noParts']."</td>
                          <td align='center'>".$row['vename']."</td>
                          <td align='center'>".$row['catname']."</td>
                          <td align='center'>".$row['prodname']."</td>     
                          <td align='center'>".date('d.M.y', strtotime($row['recdate']))."</td>                       
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