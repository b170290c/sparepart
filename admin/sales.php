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

<?php
 if (isset($_GET['fail'])){
    echo ("<script>alert('Unable to process the order! Insufficient Product Quantity !!');</script>");
   }

   if (isset($_GET['success'])){
    echo ("<script>alert('Order Processed Successfully!');</script>");
   }

     if (isset($_GET['success1'])){
    echo ("<script>alert('Order Closed Successfully!');</script>");
   }
?>


<script>
$(document).ready(function() {
    $('#example1').DataTable({
        dom: "flrtip",
   
   
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
        Parts Order History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Parts Order</li>
      </ol>
    </section>

    <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
 
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                 <thead>
                   <th class="hidden"></th>
               
                  <th align='center'>Date</th>
                  <th align='center'>Requester Info</th>
                  <th align='center'>Product Image</th>
                  <th align='center'>Product Name</th>
                  <th align='center'>Quantity Requested</th>
                  <th align='center'>Product Info</th>
                  <th align='center'>Status</th>
                  <th align='center'>Note</th>
                <!--   <th align='center'>Receiver</th> -->
                
                </thead>
                <tbody>
                  <?php
                  //  $conn = $pdo->open();

                    try{

                      $sql = " SELECT *, sales.id AS salesid FROM sps.sales LEFT JOIN sps.details on details.sales_id=sales.id LEFT JOIN sps.users1 ON users1.id=sales.user_id ORDER BY  details.detail_status ASC , sales.sales_date DESC ";
                      $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 


                     // $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN details on details.sales_id=sales.id LEFT JOIN users1 ON users1.id=sales.user_id ORDER BY  details.detail_status ASC , sales.sales_date DESC");
                     //  $stmt->execute();
                       while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $salesid = $row['sales_id'];
                        $pid = $row['product_id'];

                        $sql1 = " SELECT p.photo AS photo, d.detail_status AS detail_status, d.itemRec AS itemRec, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, d.dates AS dates, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.ownqnty AS ownqnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty, o.quantity AS quantity1, o.orderstat AS orderstat, o.dates AS dates1 FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id LEFT JOIN sps.ongoing o ON o.detailid=d.detailid WHERE d.detailid='".$row['detailid']."' ORDER BY d.dates , d.detail_status ASC  ";
                        $params1 = array();
                        $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                        $stmt1 = sqlsrv_query( $conn, $sql1 , $params1, $options1 );

                        $total = 0;
                         $photo = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';


                        while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {
                       
                          $detailid = $details['detailid'];
                          $empID = $details['empID'];
                          $empName = $details['empName'];
                          $subtotal = $details['price']*$details['qtyok'];
                          $total += $subtotal;
                          $images = (!empty($details['photo'])) ? '../images/'.$details['photo'] : '../images/noimage.jpg';
                          $statusCode = $details['detail_status'];
                          $note = $details['notes'];
                          $retqty = $details['retqty'];
                          $badqty = $details['badqty'];
                          $reason = $details['reason'];
                          $qtyok = $details['qtyok'];
                          $time = $details['time'];
                          $qnty = $details['qnty'];
                          $dates = $details['dates'];
                          $dates1 = $details['dates1'];
                          $itemRec = $details['itemRec']; 
                          $retstat = $details['retstat'];
                          $ostat = $details['orderstat'];
                          $ownqnty = $details['ownqnty'];
                          $prodname = $details['name'];
                          $quantity = $details['quantity'];
                          $qnty = $details['qnty'];
                          $ownqnty = $details['ownqnty'];
                          $idLoc = $details['idLoc'];
                          $noSAP = $details['noSAP'];
                          $noParts = $details['noParts'];
                          $orderstat = $details['orderstat'];

                          $goodqty = $retqty - $badqty; 

                          //check stock in-hand

                            
                         }
                         

 echo "
                          <tr >

                            <td  class='hidden'></td>

                            <td align='center'>".$row['sales_date']->format("d-M-y h:i a")."</td>
                            <td align='center'><img src=".$photo." width='45px' height='60px'>".'<br>'.$row['firstname'].' '.$row['lastname'].'<br>'.$row['empid'].'<br>'.$row['line'].'<br>'.$row['plant'].   "</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td align='center'>".$prodname."</td>
                            <td align='center'>".$quantity."</td>
                                                 
                            <td>".'<b>Stock Avail. :</b> '.$qnty.'<br>'
                                 .'<b>In-Hand. :</b> '.$ownqnty.'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'
                                 
                                 ."</td>


                           ";


 if($statusCode=='0'){ 
                              echo "<form action='update.php' method='POST'>
                              <td>
                               <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='newQnty' value='".$quantity."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='oldQnty' value='".$qnty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='ownQnty' value='".$ownqnty."' data-id='".$row['salesid']."'>
                              

                              <input type='textarea' name='note' placeholder='Enter Notes Here!' value='' data-id='".$row['salesid']."' autocomplete = 'off' required/><br><br>
                              <b>Enter Quantity to Release : </b>
                              <input type='number' size='5' name='qtyok' value='1' min='1' max='".$quantity."'  data-id='".$row['salesid']."'  > <br/><br/>
                              <input type='submit' name='status' value='Accept' data-id='".$row['salesid']."'> &nbsp;&nbsp;
                              <input type='submit' name='status' value='Reject' data-id='".$row['salesid']."'> 

                              
                              </form></td>
                              <td>Pending Request!</td>";
                            }


 elseif($statusCode=='1' && $itemRec == '0'){ 

                              echo "
                              <td>Accepted <br><br>"
                              .' Stock Releasing :  '.'<strong>'. $qtyok.'</strong>'.
                              "</td>";

                              echo "<form action='update1.php' method='POST'>
                              <td>
                              <b>Filled in by parts collector!</b></br>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              
                              <input type='textarea' name='eName' autocomplete='off' placeholder=' Employee Name!' data-id='".$row['salesid']."'required/> 
                              <input type='textarea' name='eID' autocomplete='off' placeholder=' Employee ID!' data-id='".$row['salesid']."'required/><br/><br/>

                               <input type='submit' class='btn btn-primary' name='itemrec' value='Item Received' data-id='".$row['salesid']."'>
                                                                              
                              </form></td>";
                           
                            }
                            
elseif($statusCode=='1' && $itemRec == '1' &&  $quantity == $qtyok && $ostat== '3' ||  $quantity == $qtyok && $statusCode == '1'){ 

                              echo "
                              <td bgcolor='#90ee90' align:'center'>Accepted <br><br>"

                              .' Stock Released :  '.'<strong>'.$qtyok.'</strong><br><br>'.
                              '<strong>Order Closed Successfully!</strong>'.
                              "</td>";

                              echo "
                              <td  align:'center'> 
                          ".'Item collected by: <br/> '.'<strong>'.$empName.' '.' ('.$empID.')'.'</strong>'.'<br/> at <br/><b>'. $dates->format("d-M-y h:i a")."<b/> <br> 

                              

                             </td>";
                           
                            }



elseif($statusCode=='1' && $itemRec == '1' &&  $quantity != $qtyok &&  $orderstat == '0'){ 

                              echo "
                              <td bgcolor='#FF0000' align:'center'>Accepted <br><br>"

                              .' Stock Released :  '.'<strong>'. $qtyok.'</strong><br><br>'.

                              '<strong> Order is ongoing!</strong><br><br>'. 

                                
                             " <form method='POST' action='ongoing1.php'>
                               <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>  
                                  <input type='submit' name='set' value='Set Date'/>  
                                  </form>       

                                 


                              </td>";

                              echo "
                              <td  align:'center'> <strong> ".$note."</strong> <br/><br/>
                          ".'Item collected by: <br/> '.'<strong>'.$empName.' '.' ('.$empID.')'.'</strong>'.'<br/> at <br/><b>'.$dates->format("d-M-y h:i a")."<b/> <br> 

                              

                             </td>";
                           
                            }

elseif($statusCode=='1' && $itemRec == '1' &&  $quantity != $qtyok &&  $orderstat == '1' ){ 

                              echo "
                              <td bgcolor='#FF0000' align:'center'>Accepted <br><br>"

                              .' Stock Released :  '.'<strong>'. $qtyok.'</strong><br><br>'.

                              '<strong> Order is ongoing!</strong><br><br>'. 

                              '<strong>Date had been set to : </strong><br>' .$dates1->format("d-M-y h:i a").


                              "</td>";

                              echo "
                              <td  align:'center'> <strong> ".$note."</strong> <br/><br/>
                          ".'Item collected by: <br/> '.'<strong>'.$empName.' '.' ('.$empID.')'.'</strong>'.'<br/> at <br/><b>'.$dates->format("d-M-y h:i a")."<b/> <br> 

                              

                             </td>";
                           
                            }


elseif($statusCode=='1' && $itemRec == '1' &&  $quantity != $qtyok &&  $orderstat == '2' ){ 

                              echo "
                              <td bgcolor='#FF0000' align:'center'>Accepted <br><br>"

                              .' Stock Released :  '.'<strong>'. $qtyok.'</strong><br><br>'.

                              '<strong> Order is ongoing!</strong><br><br>'.

                              '<strong> Waiting for user to collect 2nd round!</strong><br><br>'. 

                             


                              "</td>";

                              echo "
                              <td  align:'center'> <strong> ".$note."</strong> <br/><br/>
                          ".'Item collected by: <br/> '.'<strong>'.$empName.' '.' ('.$empID.')'.'</strong>'.'<br/> at <br/><b>'.$dates->format("d-M-y h:i a")."<b/> <br> 

                              

                             </td>";
                           
                            }                            


 elseif($statusCode=='2'){
                                echo "<td bgcolor='#a1ada3' align:'center'>Rejected</td>";
                                echo "<td>".$note."</td>";
                            }
                            
 elseif($statusCode=='3' && $retstat == '3'){
                                echo "<td bgcolor='#d718f0' align:'center'>".'Item Returned<br><br>'.'Quantity Returned : '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";

                               echo "  <td> Return Process <br> Completed at: <strong><br>'".$time->format("d-M-y h:i a")."'</strong> <br><br>
                                      Good Parts : <strong>".$goodqty."</strong>  <br> Bad Parts : </b><strong>".$badqty."</strong>

                            
                               

                             </td>";
                            }
     
      elseif($statusCode=='3' && $retstat == '0' || $retstat == '1'){
                                echo "<td >".'Item to be Returned<br><br>'.'Quantity to be Returned : '.'<strong>'.$retqty.'</strong>'."
                               

                               </td><br>";



                               echo "  <td'> Return Process <br> Started at: <strong><br>'".$time->format("d-M-y h:i a")."'</strong> 
                            
                               

                             </td>";
                            }
     
  
                            

                            echo "</tr>" ;




                         }
                       
                    
          

                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }


                   // $pdo->close();
                       sqlsrv_free_stmt($stmt);
                      sqlsrv_close($conn);
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
