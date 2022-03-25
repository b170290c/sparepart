<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- DataTables -->
<link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>


<script type="text/javascript" src="datatable/datatables.min.js"></script>

<link rel="stylesheet" href="datatable/DataTables/css/jquery.dataTables.min.css"></script>
<script type="text/javascript" src="DataTables/js/jquery.dataTables.min.js"></script>


<body class="hold-transition skin-red sidebar-mini">
<div  class="wrapper">


<script>
$(document).ready(function() {
    $('#example4').DataTable({
        dom: "flrtip",
        // buttons: [
        //  {extend: 'Copy', title: 'Copy Table'}
               
        //   ]
    });
} );
</script>

<style>
input[type=text] {
    padding:5px; 
    border:2px solid #ccc; 
    -webkit-border-radius: 5px;
    border-radius: 5px;
}

input[type=text]:focus {
    border-color:#333;
}

input[type=submit] {
    padding:5px 15px; 
    background:#ccc; 
    border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px; 
}
</style>



  <?php include 'includes/menubar.php'; ?>
  <?php include 'includes/navbar.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
        Return Parts History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Return Parts Order</li>
      </ol>
    </section>

    <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
 
     
            <div class="box-body">
              <table id="example4" class="table table-bordered">
                 <thead>
                   <th class="hidden"></th>
               
                  <th align='center'>Return Date</th>
                  <th align='center'>User Info</th>
                  <th align='center'>Product Image</th>
                  <th align='center'>Product Name</th>
                  <th align='center'>User Quantity</th>
                  <th align='center'>Product Info</th>
                  <th align='center'>Status</th>
                  <th align='center'>Note</th>
                <!--   <th align='center'>Receiver</th> -->
                
                </thead>
                <tbody>
                  <?php
                  //  $conn = $pdo->open();

                    try{

                      $sql = " SELECT sales.id AS salesid, details.product_id AS product_id, details.detailid AS detailid, users1.line AS line, users1.plant AS plant, users1.empid AS empid, users1.firstname AS firstname, users1.lastname AS lastname  FROM sps.sales LEFT JOIN sps.details on details.sales_id=sales.id LEFT JOIN sps.rdetails ON details.detailid=rdetails.detailid LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE details.detail_status= 3 ORDER BY time DESC ";
                       $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 


                  
                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $pid = $row['product_id'];
                        $salesid = $row['salesid'];
                        $line = $row['line'];
                        $plant = $row['plant'];

                        $sql1 = " SELECT p.photo AS photo, d.detail_status AS detail_status, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.ownqnty AS ownqnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id WHERE d.detailid='".$row['detailid']."' ORDER BY r.time DESC ";



                      
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                        $stmt1 = sqlsrv_query( $conn, $sql1 , $params, $options ); 

                        $total = 0;
                        $photo = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';


                       

                      while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {
                       
  
                          $empID = $details['empID'];
                          $empName = $details['empName'];
                          $subtotal = $details['price']*$details['qtyok'];
                          $total += $subtotal;
                          $images = (!empty($details['photo'])) ? '../images/'.$details['photo'] : '../images/noimage.jpg';
                          $statusCode = $details['detail_status'];
                          $note = $details['notes'];
                          $retstat = $details['retstat'];
                          $reason = $details['reason'];
                          $qtyok = $details['qtyok'];
                          $retqty = $details['retqty'];
                          $badqty = $details['badqty'];
                          $time = $details['time'];
                          $prodname = $details['name'];
                          $qnty = $details['qnty'];
                          $ownqnty = $details['ownqnty'];
                          $idLoc = $details['idLoc'];
                          $noSAP = $details['noSAP'];
                          $noParts = $details['noParts'];
                          $recdate = $details['recdate'];
                          $price = $details['price'];
                          $detailid = $details['detailid'];
                          $quantity = $details['quantity'];


                          $goodqty = $retqty - $badqty;
                         
                                              

                            
                         }
                      
                        echo "
                          <tr>

                            <td  class='hidden'></td>
                            <td align='center'>".$time->format('Y-m-d h:i:s')."</td>
                            <td align='center'><img src=".$photo." width='45px' height='60px'>".'<br>'.$row['firstname'].' '.$row['lastname'].'<br>'.$row['empid']."</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td align='center'>".$prodname."</td>
                            <td align='center'>".$qtyok."</td>
                            


                     
                            <td>".'<b>Stock Left :</b> '.$qnty.'<br>'
                                 .'<b>In-Hand :</b> '.$ownqnty.'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'
                                 .'<b>Receive Date :</b> '.$recdate->format('d-M-y h:i a').'<br>'
                                 .'<b>Price Per Piece :<br> RM</b> '.number_format($price,2).'<br>'
                                 


                       ."</td>";


if($statusCode=='3' && $retstat == '0'){
                               echo "<td>".'User wants to return the product!<br><br>'.'Quantity to Return: '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";



                               echo "<form action='return1.php' method='POST'>
                              <td>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='retqty' value='".$retqty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qtyok' value='".$qtyok."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='quantity' value='".$quantity."' data-id='".$row['salesid']."'>

                            <strong> User has requested to return the parts on :</strong><br>".$time->format("d-M-y h:i a")."

                            <br><br>
                              <input type='submit' name='status' value='Received' data-id='".$row['salesid']."'> &nbsp;&nbsp;
                             

                              
                              </form></td>";
                            }




 if($statusCode=='3' && $retstat == '1'){
                               echo "<td>".'User wants to return the product!<br><br>'.'Quantity Returned: '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";



                               echo "<form action='return1.php' method='POST'>
                              <td>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='retqty' value='".$retqty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qtyok' value='".$qtyok."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='quantity' value='".$quantity."' data-id='".$row['salesid']."'>

                            <strong> User has requested for self-pickup at :</strong><br>Plant: <strong>".$plant."</strong> <br>Line: <strong>".$line."</strong> <br>on <strong>".$time->format("d-M-y h:i a")."</strong>

                            <br><br>
                              <input type='submit' name='status' value='Collected' data-id='".$row['salesid']."'> &nbsp;&nbsp;
                             

                              
                              </form></td>";
                            }
     
if($statusCode=='3' && $retstat == '2'){
                               echo "<td>".'Item Returned<br><br>'.'Quantity Returned: '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";



                               echo "<form action='return2.php' method='POST'>

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='retqty' value='".$retqty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qtyok' value='".$qtyok."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qnty' value='".$qnty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='ownqnty' value='".$ownqnty."' data-id='".$row['salesid']."'>

                           <td align='center'> ".'<b>Check For Dead Body Parts: </b> '." </br>
                           <input type='number' size='5' name='badqty' value='0'  min='0' max='".$retqty."'  data-id='".$row['salesid']."' required> 
                           <input type='textarea' name='note' placeholder='Enter Notes Here!' value='' data-id='".$row['salesid']."' ><br><br>
                              
                              

                                <input type='submit' value='Approve' data-id='".$row['salesid']."'> 

                           
                             

                              
                              </form></td>";
                            }

if($statusCode=='3' && $retstat == '3'){
                               echo "<td>".'Item Returned<br><br>'.'Quantity Returned: '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";



                               echo "  <td> Return Process Has Been Completed! <br><br>
                                      Good Parts : <strong>".$goodqty."</strong>  <br> Bad Parts : </b><strong>".$badqty."</strong>
                             

                              
                              </td>";
                            }



                            echo "</tr>" ;



                        
                      }

                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }


                  //  $pdo->close();
                  ?>                   


                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
</div>     
    <?php include 'includes/footer.php'; ?>
    <?php include '../includes/profile_modal.php'; ?>


<!-- ./wrapper -->
<?php include 'includes/scripts.php'; ?>
<!-- Date Picker -->



</body>
</html>
