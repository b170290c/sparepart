<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<head>
<link rel="icon" type="image/x-icon" href="../assets/img/favicon.png" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- DataTables -->

  <link href="bootstrap/css/bootstrap.css" rel="stylesheet" />
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>
<script type="text/javascript" src="../DataTables/datatables.js"></script>
<script type="text/javascript" src="../DataTables/datatables.min.js"></script>


<body class="hold-transition skin-red sidebar-mini">
<div  class="wrapper">

<?php
 if (isset($_GET['fail'])){
    echo ("<script>alert('Selection Invalid! Please restock to release the product!');</script>");
   }
?>

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

  @viewport {
width:device-width;
zoom:1;
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
</style>



  <?php include 'includes/menubar.php'; ?>
  <?php include 'includes/navbar.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
        On-Going Parts History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">On-Going Parts </li>
      </ol>
    </section>
  </head>

    <!-- Main content -->
   <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
 
            <div class="box-body">
              <table id="example4" class="table table-bordered">
                 <thead>
                   <th class="hidden"></th>
               
                  <th align='center'>Collected Date</th>
                 <th align='center'>Requester Info</th>
                  <th align='center'>Product Image</th>
                  <th align='center'>Product Name</th>
            
                  <th align='center'>Product Info</th>
                  <th align='center'>Quantity</th>
              
                
                  <th align='center'>Action</th>
                
                </thead>
                <tbody>
                  <?php

                    $today =  date('Y-m-d H:i:s');
                  
                

                  //  $conn = $pdo->open();

                    try{

                      $sql = " SELECT sales.id AS salesid, details.product_id AS product_id, details.detailid AS detailid, details.quantity AS quantity, details.qtyok AS qtyok, users1.line AS line, users1.plant AS plant, users1.empid AS empid, users1.firstname AS firstname, users1.lastname AS lastname, o.dates AS odates FROM sps.sales LEFT JOIN sps.details ON details.sales_id=sales.id LEFT JOIN sps.ongoing o ON o.salesid = sales.id LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE details.qtyok <> details.quantity AND details.itemRec=1   ORDER BY o.dates ASC , users1.firstname ASC ";
                      $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 





                     // $stmt = $conn->prepare("SELECT sales.id AS salesid, details.product_id AS product_id, details.detailid AS detailid, details.quantity AS quantity, details.qtyok AS qtyok, users1.line AS line, users1.plant AS plant, users1.empid AS empid, users1.firstname AS firstname, users1.lastname AS lastname, o.dates AS odates FROM sales LEFT JOIN details ON details.sales_id=sales.id LEFT JOIN ongoing o ON o.salesid = sales.id LEFT JOIN users1 ON users1.id=sales.user_id WHERE details.qtyok <> details.quantity AND details.itemRec=1   ORDER BY o.dates ASC , users1.firstname ASC");
                     //  $stmt->execute();

                       while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $pid = $row['product_id'];
                        $salesid = $row['salesid'];
                        $line = $row['line'];
                        $plant = $row['plant'];

                        $sql1 = " SELECT p.photo AS photo, d.detail_status AS detail_status, o.quantity AS quantity1, d.itemRec AS itemRec ,d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, d.dates AS dates,  d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.ownqnty AS ownqnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty, o.orderstat AS orderstat, o.dates AS ordates FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id LEFT JOIN sps.ongoing o ON o.detailid=d.detailid WHERE d.detailid='".$row['detailid']."' ORDER BY o.dates ASC ";
                        $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt1 = sqlsrv_query( $conn, $sql1 , $params, $options ); 


                        // $stmt = $conn->prepare("SELECT p.photo AS photo, d.detail_status AS detail_status, o.quantity AS quantity1, d.itemRec AS itemRec ,d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, d.dates AS dates,  d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.ownqnty AS ownqnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty, o.orderstat AS orderstat, o.dates AS ordates FROM details d LEFT JOIN rdetails r ON r.detailid=d.detailid LEFT JOIN products p ON p.id=d.product_id LEFT JOIN ongoing o ON o.detailid=d.detailid WHERE d.detailid=:id ORDER BY o.dates ASC");
                        // $stmt->execute(['id'=>$row['detailid']]);
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
                          $retstat = $details['retstat'];
                          $reason = $details['reason'];
                          $quantity = $details['quantity'];
                          $qtyok = $details['qtyok'];
                          $retqty = $details['retqty'];
                          $badqty = $details['badqty'];
                          $itemRec = $details['itemRec'];
                          $dates = $details['dates'];
                          $dates1 = $details['ordates'];
                          $ostat = $details['orderstat']; 
                          $oquantity = $details['quantity1'];
                          $ordates = $details['ordates'];
                          $prodname = $details['name'];
                          $qnty = $details['qnty'];
                          $ownqnty = $details['ownqnty'];
                          $idLoc = $details['idLoc'];
                          $noSAP = $details['noSAP'];
                          $noParts = $details['noParts'];
                          $recdate = $details['recdate'];
                          $price = $details['price'];


                          $goodqty = $retqty - $badqty;
                          $blnc = $quantity - $qtyok;

                          $result =  $ordates;


                        }                                                                      
               // echo $result. ' - '.$today;          
                      
                        echo "
                          <tr>

                            <td  class='hidden'></td>

                            <td align='center'>".$dates->format("d-M-y h:i a")."</td>
                            <td align='center'><img src=".$photo." width='45px' height='60px'>".'<br>'.$row['firstname'].' '.$row['lastname'].'<br>'.$row['empid'].'<br>'.$row['line'].'<br>'.$row['plant'].   "</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td align='center'>".$prodname."</td>
                           
                            


                     
                            <td>".'<b>Stock Left :</b> '.$qnty.'<br>'
                                 .'<b>In-Hand :</b> '.$ownqnty.'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'
                                 .'<b>Receive Date :</b> '.$recdate.'<br>'
                                 .'<b>Price Per Piece :<br> RM</b> '.number_format($price,2).'<br>'
                                 ."</td>


                       ";


                               echo "<td align='center'>".'<strong>Total Ordered: </strong><br>'.$quantity.'<br/><br/>'.
                                                          '<strong>Stock Released: </strong><br>'.$qtyok.'<br/><br/>'.
                                                          '<strong>Remaining : </strong><br>'.$blnc.

                               "</td><br>";

                           


if( $ostat == 0 ){





 

                               echo "<form action='order.php' method='POST'>

                              <td>
                               <strong> Select date & quantity for remaining parts collections!</strong><br/>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='blnc' value='".$blnc."' data-id='".$row['salesid']."'>

                              <input type='date' min='" . date("Y-m-d") . "' id='date' name='order'   data-id='".$row['salesid']."'required/>
                              <input type='number' size='5' name='blnc1' value='".$blnc."' min='1' max='".$blnc."'  data-id='".$row['salesid']."' required > <br/><br/>

                           <input type='submit' class='btn btn-primary' name='set' value='Go' data-id='".$row['salesid']."'>

                            <br><br>                            
                              </td>";


                            }
                          
if( $ostat == 1 && $today < $result){


                               echo "<form action='ordermodi.php' method='POST'>
                              <td>
                               <strong> Quantity Scheduled : </strong>".$oquantity. "<br/>
                               ".'<strong> on </strong>'.$qtyok."<br><br> 

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='blnc' value='".$blnc."' data-id='".$row['salesid']."'>
                            

                              <input type='submit' name='status' value='Now' data-id='".$row['salesid']."'> &nbsp;&nbsp;
                              <input type='submit' name='status' value='Reschedule' data-id='".$row['salesid']."'> 




                           </form>                   

                          </td>";


                         }





if( $today >= $result && $ostat == 1){


                              echo "<form action='order1.php' method='POST'>
                              <td>
                               <strong> Quantity Scheduled : </strong>".$oquantity. " <br> <b> ON </b>".date('M d, Y ', strtotime($ordates))." <br><b>Please prepare the scheduled quantity!<br/>
                               Quantity to release:</b>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qty' value='".$qtyok."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='oldqty' value='".$quantity."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='ownqty' value='".$ownqnty."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='balqty' value='".$oquantity."' data-id='".$row['salesid']."'></br>

                              <input type='number' size='5' name='relqty' value='".$oquantity."' data-id='".$row['salesid']."' min='1' max='".$oquantity."'>
                              <input type='submit' class='btn btn-primary' name='set' value='Go' data-id='".$row['salesid']."'>



                            <br><br> 


                              </td>";

                            }

//2nd collection
if(  $ostat == 2 && $qtyok != $quantity){


                            
                               echo "<form action='order2.php' method='POST'>
                                      <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='oldqty' value='".$qtyok."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='oriqty' value='".$quantity."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='ownqty' value='".$ownqnty."' data-id='".$row['salesid']."'>
                                      <input type='hidden' name='balqty' value='".$oquantity."' data-id='".$row['salesid']."'>

                              <td>
                              <b>Filled in by parts collector!</b></br>
                               <strong> Quantity received : </strong><br/>
                               <input type='number' size='5' name='blnc'  min='1' max='".$oquantity."'  data-id='".$row['salesid']."' required > <br/>

                               
                              <input type='text' name='eName' autocomplete='off' placeholder=' Employee Name' data-id='".$row['salesid']."'required/> 
                              <input type='text' name='eID' autocomplete='off' placeholder=' Employee ID' data-id='".$row['salesid']."'required/><br/><br/>

                               <input type='submit' class='btn btn-primary' name='itemrec' value='Item Collected' data-id='".$row['salesid']."'>
                                                                              
                              </form>

                       


                              </td>";

                            }






                            echo "</tr>" ;



                        
                      }

                      

                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }



                    //$pdo->close();
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
