<?php include 'includes/session.php'; ?>
<?php
    
    if(!isset($_SESSION['user'])){
      header("Location:login.php");
    }
    ?>
<?php include 'includes/header.php'; ?>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
  <!-- DataTables -->
 <link rel="stylesheet" href="DataTables/datatables.js">
   <link rel="stylesheet" href="DataTables/datatables.min.css">

<script type="text/javascript" src="js/jquery-3.5.1.js"></script>



<body class="hold-transition skin-black layout-top-nav">
<div  class="wrapper">



<script>
$(document).ready(function() {
    $('#example4').DataTable({
        dom: "Bflrtip",
     
    });
} );




</script>
  <?php include 'includes/navbar1.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
      <strong>Parts Request Order</strong>
        
      </h1>
     
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="row">
      
              <table id="example4" class="table table-bordered table-hover">
                <thead>
                   <tr>
                <th class="hidden"></th>
             
                <th align="center">Date Requested</th>
                <th align="center">Photo</th>
                <th align="center">Product Info</th>
                <th align="center">Quantity</th>
                <th align="center">Item status</th>
               
             
            </tr>
                </thead>
                <tbody>
                  <?php
               //     $conn = $pdo->open();


                    //sales.php linked
   

                    try{

                      $sql = " SELECT *, sales.id AS salesid FROM sps.sales LEFT JOIN sps.details on details.sales_id=sales.id LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE sales.user_id = '".$_SESSION['user']."' ORDER BY details.detail_status ASC , sales_date DESC ";
                     
                      $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options );

                      // $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN details on details.sales_id=sales.id LEFT JOIN users1 ON users1.id=sales.user_id WHERE sales.user_id = '" . $_SESSION['user'] . "'  ORDER BY details.detail_status ASC , sales_date DESC");
                      // $stmt->execute();

                while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                       
                        $salesid = $row['sales_id'];
                        $pid = $row['product_id'];
                        $did = $row['detailid'];
                        $sales_date = $row['sales_date']->format("d-M-y h:i a");


                        $sql1 = " SELECT*, p.photo AS photo, d.detail_status AS detail_status, d.dates AS dates, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, o.quantity AS quantity1, o.orderstat AS orderstat, r.retstat AS retstat, r.retqty AS retqty , o.dates AS dates1, d.detailid AS detailid FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.ongoing o ON o.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id WHERE d.detailid='".$did."' ORDER BY d.detail_status ASC,d.detailid DESC ";

                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                        $stmt1 = sqlsrv_query( $conn, $sql1 , $params, $options );

                        // $stmt = $conn->prepare("SELECT p.photo AS photo, d.detail_status AS detail_status, d.dates AS dates, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, o.quantity AS quantity1, o.orderstat AS orderstat, r.retstat AS retstat, r.retqty AS retqty , o.dates AS dates1, d.detailid AS detailid FROM details d LEFT JOIN rdetails r ON r.detailid=d.detailid LEFT JOIN ongoing o ON o.detailid=d.detailid LEFT JOIN products p ON p.id=d.product_id WHERE d.detailid=:id ORDER BY d.detail_status ASC,d.detailid DESC");
                        // $stmt->execute(['id'=>$row['detailid']]);
                        $total = 0;


                while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {

                          $images = (!empty($details['photo'])) ? 'images/'.$details['photo'] : 'images/noimage.jpg';
                          $st = $details['detail_status'];
                          $st2 = $details['detail_status'];
                          $comment = $details['notes'];
                          $rec = $details['itemRec'];
                          $dates = $details['dates'];
                          $eName = $details['empName'];
                          $eID = $details['empID'];
                          $qtyok = $details['qtyok'];
                          $quantity = $details['quantity'];
                          $date1 = $details['time'];
                          $ostat = $details['orderstat'];
                          $reason = $details['reason'];
                          $odates = $details['dates1'];
                          $retstat = $details['retstat'];
                          $retqty = $details['retqty'];
                          $name = $details['name'];
                          $idLoc = $details['idLoc'];
                          $noSAP = $details['noSAP'];
                          $noParts = $details['noParts'];
                          $noSerial = $details['noSerial'];

                          $bal = $quantity - $qtyok;
                          $rbal = $qtyok - $retqty;
                        }



                          if ($st == 0) {
                             $st = 'Waiting for Approval';
                          } elseif ($st == 1) {
                              $st = 'Approved! ';

                          } elseif ($st == 2) {
                             $st = 'Rejected! ';
                          }
                          elseif ($st == 3) {
                            $st = 'Item Returned!';
                          }
                      
            
                        
                        echo "
                          <tr>
                          <td  class='hidden'></td>
                           
                            <td align='center'>".$sales_date."</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td>".'<b>Name :</b> '.$name.'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'.
                                 // .'<b>Serial# : </b> '.$noSerial.
                            
                                                   

                        "</td>";

                         if($st2 == 0 && $rec == 0){ 
                              echo " <td align='center'>".$quantity."</td>
                            
                              <td align='center'>".'<b>Status :</b> '.$st."<br>
                              <b>Please collect your item only after Admin approved your order!</b> <br>
                              

                              </td>";
                            }

                        elseif($st2 == 1 && $rec == 0 ){ 
                              echo " <td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Approved : </b>".$qtyok."<br>
                              <b>Balance : </b>".$bal."<br>


                              </td>
                            
                              <td align='center'>".'<b>Status :</b> '.$st."<br>
                                                               
                             ".'<b>Comment :</b> '.$comment."<br>

                              <b>Please collect your item!</b> <br>
                              

                              </td>";
                            }


                            elseif($st2 == 1 && $rec == 1 && $bal != 0){ 
                              echo "<td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Approved : </b>".$qtyok."<br>
                              <b>Balance : </b>".$bal."<br>


                              </td>
                            
                            <td bgcolor='#FF0000' align:'center'>".'<b>Status :</b> '.$st."<br>
                            
                             
                              ".'<b>Item collected by:</b> '.$eName.' ('.$eID.')'.'<br> <b> at</b> <br/>'.$dates->format("d-M-y h:i a")." <br> 


                              <h2> Order On-Going! </h2>

                             
                          

                             </td>";
                            } 
                             elseif($st2 == 1 && $rec == 1 && $bal == 0 ){ 
                              echo "<td align='center'><b>Requested Quantity: </b>".$quantity."<br><br>
                              <b>Approved Quantity: </b>".$qtyok."<br>

                              </td>
                            
                            <td bgcolor='#00FF00' align:'center'>".'<b>Status :</b> '.$st."<br>
                              
                            

                              ".'<b>Item collected by:</b> '.$eName.' ('.$eID.')'.'<br> <b> at</b> <br/>'.$dates->format("d-M-y h:i a")." <br> 

                             <h2> Order Closed! </h2>

                      

                             </td>";

                            }

                            elseif( $ostat == 1 ){ 
                              echo "<td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Approved : </b>".$qtyok."<br>
                              <b>Balance : </b>".$bal."<br>


                              </td>
                            
                            <td bgcolor='#FF0000' align:'center'>".'<b>Item reschedule  on:</b> <br/>'.$odates->format("d-M-y h:i a")." <br> 


                              <h2> Order On-Going! </h2>

                             
                              

                             </td>";
                         }


                             elseif($st2 == 3 && $rec == 1 && $retstat == 0){ 
                              echo "<td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Quantity Returned : </b>".$retqty."<br>
                              <b>In-Hand : </b>".$rbal."<br>
                            
                            <td align='center' bgcolor='#FFC0CB'>".'<b>Status :</b> '.$st."<br>
                             

                              ".'<h2>Item returned at:</h2>'.$date1->format("d-M-y h:i a")."<br>
                               

                             </td>";
                            } 



                            elseif($st2 == 3 && $rec == 1 && $retstat == 2){ 
                              echo "<td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Item Returned : </b>".$retqty."<br>
                              <b>In-Hand : </b>".$rbal."<br>


                            <td align='center' bgcolor='#FFC0CB'>".'<b>Status :</b> '.$st."<br>
                              
                               
                              ".'<h2>Item returned at:</h2>'.$date1->format("d-M-y h:i a")."<br>
                               

                             </td>";
                            } 

                            elseif($st2 == 3 && $rec == 1 && $retstat == 3){ 
                              echo "<td align='center'><b>Requested : </b>".$quantity."<br><br>
                              <b>Item Returned : </b>".$retqty."<br>
                              <b>In-Hand : </b>".$rbal."<br>


                            <td align='center' bgcolor='#FFC0CB'>".'<b>Status :</b> '.$st."<br>
                              
                               
                              ".'<h2>Item returned at:</h2>'.$date1->format("d-M-y h:i a")."<br>
                               

                             </td>";
                            } 





                            elseif($st2 == 2 && $rec == 0 ){ 
                              echo "<td align='center'>".$quantity."</td>
                            
                             <td bgcolor='#DD0896' align:'center'>".'<b>Status :</b>'.$st."<br>
                             ".'<b>Order rejected :</b> '.$comment."<b/> <br> 

                             <h2> Rejected! </h2>

                             </td>";
                            } 
                        
                      
                            echo "</tr>" ;

                      
                    
                  }

                  
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

             //       $pdo->close();
                      sqlsrv_free_stmt($stmt);
                      sqlsrv_close($conn);
                  ?>
                </tbody>
              </table>
        
      </div>
    </section>
     
  </div>
    <?php include 'admin/includes/footer.php'; ?>
    <?php include 'includes/profile_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>


</body>
</html>

