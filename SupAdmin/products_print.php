<?php include 'session.php'; ?>
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
    <title>Celestica's Spare Part</title>


<section class="content">
      <div class="row">
<div class="container">


<script>
$(document).ready(function() {
    $('#example').DataTable({
        dom: "Bflrtip",
        buttons: [
         {extend: 'excel', title: 'Inventory List'},
                
          ]
    });
} );

</script>

<?php 
$from = new DateTimeZone('GMT');
$to   = new DateTimeZone('Asia/Singapore');
$currDate  = new DateTime('now', $from);
$currDate->setTimezone($to);

$dates = $currDate->format('l jS \of F Y');


$title = "Inventory Report";

$excelname = $title.'_'.$dates;
$file = $excelname.".xls";
    header("Content-type: application/vnd-ms-excel");

    header('Content-disposition: attachment; filename='.basename($file));  
?>




  <div class="box-body">
              <table id="example"  class="table table-bordered">
               <thead class="thead-dark">
  <br><br>
                <th class="hidden"></th>
                <th>Serial Number</th>
                <th>SAP Number</th>
                <th>Part Number</th>
                <th>Brand</th>
                <th>Product Description</th>
                <th>Location</th>
                <th>Cost</th>
                <th>Currency</th>
                <th>Inventory Quantity</th>
                <th>ROP</th>
                <th>MLS</th>
                <th>ROQ</th>
                <th>Lead Time</th>
                  
                  
                  
                  
                </thead>
                <tbody>
                  <?php
                    include 'conn.php';

                   $query =" SELECT *, products.name as pname, vendor.name as vename, category.name as catname FROM products LEFT JOIN vendor ON vendor.id=products.vendor_id LEFT JOIN category ON category.id=products.category_id ORDER BY pname ASC";  
                    $result = mysqli_query($conn, $query); 
                       while($row = mysqli_fetch_array($result)) {
                       $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                          
                  
                          echo "
                          <tr>
                          <td  class='hidden'></td>  
                          <td align='center'>".$row['noSerial']."</td> 
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['noParts']."</td>
                          <td align='center'>".$row['catname']."</td>
                          <td align='center'>".$row['pname']."</td>                            
                          <td align='center'>".$row['idLoc']."</td>
                          <td align='center'>".number_format($row['price'], 2)."</td>                            
                          <td align='center'>".'Malaysian Ringgit (MYR)'."</td>
                          <td align='center'>".$row['qnty']."</td>
                          <td align='center'>".$row['minqnty']."</td>
                          <td align='center'>".$row['mls']."</td>
                          <td align='center'>".$row['roq']."</td>
                          <td align='center'>".$row['leadtime']."</td>
                          
                          
                          
                          

                          ";  
                          
                          echo "</tr>" ;

      
                            }
                          
     

                 
      ?>



              </table>
            </div>
</div>

</div>
</section>