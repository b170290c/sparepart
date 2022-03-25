<?php include 'includes/session.php'; ?>
<?php
    
    if(!isset($_SESSION['user'])){
      header("Location:login.php");
    }
    ?>
<?php include 'includes/header.php'; ?>
<link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
  <!-- DataTables -->

 <script type="text/javascript" src="js/jquery-3.5.1.js"></script>

 <link rel="stylesheet" href="DataTables/datatables.js">
   <link rel="stylesheet" href="DataTables/datatables.min.css">





<body class="hold-transition skin-black layout-top-nav">
<div  class="wrapper">

<style>
  p {
  text-align: center;
  font-size: 20px;
  margin-top: 0px;
}

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
h2, .h2 {
 font-size: 1em; 
}
</style>
<script>
$(document).ready(function() {
    $('#example4').DataTable({
        dom: "Bflrtip",
        // buttons: [
        //  {extend: 'Copy', title: 'Copy Table'}
               
        //   ]
    });
} );




</script>
  <?php include 'includes/navbar1.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
      <strong>On-Going Order </strong>
        
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
<!--                 <th align="center">Item status</th> -->
                <th align="center">Note</th>

           
             
            </tr>
                </thead>
                <tbody >
                  <?php
                  //  $conn = $pdo->open();

   

                      try{

                        $sql = " SELECT *, sales.id AS salesid FROM sps.sales LEFT JOIN sps.details on details.sales_id=sales.id LEFT JOIN sps.ongoing o ON o.detailid=details.detailid LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE details.itemRec = 1 AND details.quantity <> details.qtyok AND sales.user_id = '" . $_SESSION['user'] . "'  ORDER BY sales_date DESC ";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                        $stmt = sqlsrv_query( $conn, $sql , $params, $options );


                      // $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN details on details.sales_id=sales.id LEFT JOIN ongoing o ON o.detailid=details.detailid LEFT JOIN users1 ON users1.id=sales.user_id WHERE details.itemRec = 1 AND details.quantity <> details.qtyok AND sales.user_id = '" . $_SESSION['user'] . "'  ORDER BY sales_date DESC");
                      // $stmt->execute();

                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                       
                        $salesid = $row['sales_id'];
                        $detailid = $row['detailid'];
                        $pid = $row['product_id'];
                        $qtyok = $row['qtyok'];
                        $sales_date = $row['sales_date']->format("d-M-y h:i a");

                        $sql1 = " SELECT p.photo AS photo, d.detail_status AS detail_status, o.quantity AS quantity1, d.itemRec AS itemRec ,d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, d.dates AS dates,  d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty, o.orderstat AS orderstat, o.dates AS ordates FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id LEFT JOIN sps.ongoing o ON o.detailid=d.detailid WHERE d.detailid= '".$row['detailid']."' ORDER BY o.dates ASC ";
                        $params1 = array();
                        $options1 =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                        $stmt1 = sqlsrv_query( $conn, $sql1 , $params1, $options1 );



                        // $stmt = $conn->prepare("SELECT p.photo AS photo, d.detail_status AS detail_status, o.quantity AS quantity1, d.itemRec AS itemRec ,d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, d.dates AS dates,  d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty, o.orderstat AS orderstat, o.dates AS ordates FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id LEFT JOIN sps.ongoing o ON o.detailid=d.detailid WHERE d.detailid=:id ORDER BY o.dates ASC");
                        // $stmt->execute(['id'=>$row['detailid']]);
                        $total = 0;
                      

                         while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {







                         $images = (!empty($details['photo'])) ? 'images/'.$details['photo'] : 'images/noimage.jpg';
                          $st = $details['detail_status'];
                          $retstat = $details['retstat'];
                          $comment = $details['notes'];
                          $rec = $details['itemRec'];
                          $eName = $details['empName'];
                          $eID = $details['empID'];
                          $qtyok = $details['qtyok'];
                          $reason = $details['reason'];
                          $date = $details['dates'];
                          $ordates = $details['ordates'];
                          $orderstat = $details['orderstat'];
                          $quantity = $details['quantity'];
                          $quantity1 = $details['quantity1'];


                          $bal =  $quantity-$qtyok;



            
                        }
                      echo "
                          <tr >
                          <td  class='hidden'></td>
                           
                            <td align='center'>".$sales_date."</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td >".'<b>Name :</b> '.strtoupper($details['name']).'<br>'
                                 .'<b>ID Location :</b> '.$details['idLoc'].'<br>'
                                 .'<b>SAP# :</b> '.$details['noSAP'].'<br>'
                                 .'<b>Parts# :</b> '.$details['noParts'].'<br>'
                                 .'<b>Serial# : </b> '.$details['noSerial']."</td>
                            
                            
                           
                                                   

                        ";
                      
                           

if( $rec == 1 && $orderstat == 1 && $quantity != $qtyok){ 
                                                          


                              echo "

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$row['detailid']."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qnty' value='".$qtyok."' data-id='".$row['salesid']."'>

                              <td align='center'><b>Requested Quantity : </b>".$quantity.'<br></br>'
                              .'<b>In-Hand Quantity : </b>'.$qtyok.'<br>'
                              .'<b>Balance Quantity  :  </b>'.$bal.
                             

                              "</td>

                              <td align='center' > 
                              ".'<b> Collection Date :  </b> '.date("l,  jS \of F ", strtotime($ordates))."<br><br>

                                                        
                             
                             </td>";




                            } 



if( $rec == 1 && $orderstat == 2 && $quantity != $qtyok){ 
                                                          


                              echo "

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$row['detailid']."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qnty' value='".$qtyok."' data-id='".$row['salesid']."'>

                              <td align='center'><b>Requested Quantity : </b>".$quantity.'<br></br>'
                              .'<b>In-Hand Quantity : </b>'.$qtyok.'<br>'
                              .'<b>Balance Quantity  :  </b>'.$bal.
                             

                              "</td>

                              <td align='center' > 
                              ".'<b> Collection Date :  </b> '.date("l,  jS \of F ", strtotime($ordates))."<br><br>
                              ".'<b> Please contact Sparepart Admin for remaining parts collection!  </b>'." <br>

                                                        
                             
                             </td>";




                            } 

if( $rec == 1 && $orderstat == 0 && $quantity != $qtyok){ 
                                                          


                              echo "

                              

                              <td align='center'><b>Requested Quantity : </b>".$quantity.'<br></br>'
                              .'<b>In-Hand Quantity : </b>'.$qtyok.'<br>'
                              .'<b>Balance Quantity  :  </b>'.$bal.
                             

                              "</td>

                              <td align='center' > 
                              ".'<b> Waiting for Admin to Assign Collection Date  </b> '."<br><br>
                              ".'<b> Please be patient!  </b>'." <br>

                                                        
                             
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
    </section>
     
  </div>
    <?php include 'admin/includes/footer.php'; ?>
    <?php include 'includes/profile_modal.php'; ?>


</div>
<!-- ./wrapper -->
<?php include 'includes/scripts.php'; ?>





</body>
</html>

