<?php include 'includes/session.php'; ?>
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../DataTables/datatables.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Celestica's Spare Part</title>


<section class="content">
      <div class="row">
<div class="container">

<style>
  
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}

</style>

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
                <th>#</th>
               
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
                <th>Lead Time</th>
                  
                  
                  
                  
                </thead>
                <tbody>
                  <?php
                    // $conn = $pdo->open();
$i=1;
                   try{
                      
                      // $stmt = $conn->prepare("SELECT *, category.name AS catname, products.name AS prodname FROM products LEFT JOIN category ON category.id=products.category_id ");
                      // $stmt->execute();
                      // foreach($stmt as $row){

                    $sql = " SELECT *, category.name AS catname, products.name AS prodname FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id ";
                    $params = array();
                     $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                     $stmt = sqlsrv_query( $conn, $sql , $params, $options );

                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                       $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';
                          
                  
                          echo "
                          <tr>
                          <td>".$i."</td>  
                          
                          <td align='center'>".$row['noSAP']."</td>
                          <td align='center'>".$row['noParts']."</td>
                          <td align='center'>".$row['catname']."</td>
                          <td align='center'>".$row['prodname']."</td>                            
                          <td align='center'>".$row['idLoc']."</td>
                          <td align='center'>".number_format($row['price'], 2)."</td>                            
                          <td align='center'>".'Malaysian Ringgit (MYR)'."</td>
                          <td align='center'>".$row['qnty']."</td>
                          <td align='center'>".$row['minqnty']."</td>
                          <td align='center'>".$row['mls']."</td>
                          <td align='center'>".$row['leadtime']."</td>
                          
                          
                          
                          

                          ";  
                          
                          echo "</tr>" ;

       $i++;
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