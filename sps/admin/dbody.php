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
        Scrap Body Parts History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Scrap Body Parts</li>
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
               
                  <th align='center'>Defect Date</th>
                
                  <th align='center'>Product Image</th>
                  <th align='center'>Product Name</th>
            
                  <th align='center'>Product Info</th>
                  <th align='center'>Defect Quantity</th>
                  <th align='center'>Note</th>
                
                </thead>
                <tbody>
                  <?php
                 //   $conn = $pdo->open();

                    try{

                      $sql = " SELECT sales.id AS salesid, details.product_id AS product_id, details.detailid AS detailid, users1.line AS line, users1.plant AS plant, users1.empid AS empid, users1.firstname AS firstname, users1.lastname AS lastname, rdetails.badqty AS badqty  FROM sps.sales LEFT JOIN sps.details ON details.sales_id=sales.id LEFT JOIN sps.rdetails ON details.detailid=rdetails.detailid LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE details.detail_status= 3 AND rdetails.badqty <> 0  ORDER BY time DESC ";
                        $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options ); 

                     // $stmt = $conn->prepare("SELECT sales.id AS salesid, details.product_id AS product_id, details.detailid AS detailid, users1.line AS line, users1.plant AS plant, users1.empid AS empid, users1.firstname AS firstname, users1.lastname AS lastname, rdetails.badqty AS badqty  FROM sales LEFT JOIN details ON details.sales_id=sales.id LEFT JOIN rdetails ON details.detailid=rdetails.detailid LEFT JOIN users1 ON users1.id=sales.user_id WHERE details.detail_status= 3 AND rdetails.badqty <> 0  ORDER BY time DESC");
                     //  $stmt->execute();

                     while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
                        $pid = $row['product_id'];
                        $salesid = $row['salesid'];
                        $line = $row['line'];
                        $plant = $row['plant'];

                        $sql = " SELECT p.photo AS photo, d.detail_status AS detail_status, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty FROM sps.details d LEFT JOIN sps.rdetails r ON r.detailid=d.detailid LEFT JOIN sps.products p ON p.id=d.product_id WHERE d.detailid='".$row['detailid']."' ORDER BY r.time DESC ";
                         $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt1 = sqlsrv_query( $conn, $sql1 , $params, $options ); 

                        // $stmt = $conn->prepare("SELECT p.photo AS photo, d.detail_status AS detail_status, d.notes AS notes, d.itemRec AS itemRec, d.empName AS empName, d.empID AS empID, d.qtyok AS qtyok, r.time AS time, d.reason AS reason, p.name AS name, p.idLoc AS idLoc, p.noSAP AS noSAP, p.noParts AS noParts, p.noSerial AS noSerial, d.quantity AS quantity, d.detailid AS detailid, r.retqty AS retqty, p.qnty AS qnty, p.recdate AS recdate, p.price AS price, d.notes AS notes, d.detail_status AS detail_status, r.retstat AS retstat, r.badqty AS badqty FROM details d LEFT JOIN rdetails r ON r.detailid=d.detailid LEFT JOIN products p ON p.id=d.product_id WHERE d.detailid=:id ORDER BY r.time DESC");
                        // $stmt->execute(['id'=>$row['detailid']]);
                        $total = 0;
                         $photo = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';


                       while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {
                       
  
                          $empID = $details['empID'];
                          $empName = $details['empName'];
                          $subtotal = $details['price']*$details['badqty'];
                          $total += $subtotal;
                          $images = (!empty($details['photo'])) ? '../images/'.$details['photo'] : '../images/noimage.jpg';
                          $statusCode = $details['detail_status'];
                          $note = $details['notes'];
                          $retstat = $details['retstat'];
                          $reason = $details['reason'];
                          $qtyok = $details['qtyok'];
                          $retqty = $details['retqty'];
                          $badqty = $details['badqty'];
                          $detailid = $details['detailid'];
                          $prodname = $details['name'];
                          $qnty = $details['qnty'];
                          $ownqnty = $details['ownqnty'];
                          $idLoc = $details['idLoc'];
                          $noSAP = $details['noSAP'];
                          $noParts = $details['noParts'];
                          $recdate = $details['recdate'];
                          $price = $details['price'];
                          $time = $details['time'];

                          $goodqty = $retqty - $badqty;
                         
                                              

                            
                         }
                      
                        echo "
                          <tr>

                            <td  class='hidden'></td>

                            <td align='center'>".$time->format("d-M-y h:i a")."</td>
                      
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td align='center'>".$prodname."</td>
                           
                            


                     
                            <td>".'<b>Stock Left :</b> '.$qnty.'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'
                                 .'<b>Receive Date :</b> '.$recdate.'<br>'
                                 .'<b>Price Per Piece :<br> RM</b> '.number_format($price,2).'<br>'
                                 .'<b>Subtotal : RM  '.number_format($total,2)."</b></td>


                       ";


                               echo "<td align='center'>".'<strong>'.$badqty.'</strong>'."
                               

                               </td><br>";
if($badqty > 0){


                               echo "
                              <td>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>

                            <strong> Defected/Scrap !</strong>

                            <br><br>
                             
                             

                              
                              </td>";
                          }  

if($badqty == 0){


                               echo "
                              <td>
                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>

                            <strong> Good body parts!</strong>

                            <br><br>
                             
                             

                              
                              </td>";
                          }






                            echo "</tr>" ;



                        
                      }

                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }


                   // $pdo->close();
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
