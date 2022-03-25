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


<body class="hold-transition skin-black layout-top-nav">
<div  class="wrapper">
<script type="text/javascript" src="js/jquery-3.5.1.js"></script>

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
      <strong>Parts Return </strong>
        
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
                <th align="center">Current Quantity</th>
<!--                 <th align="center">Item status</th> -->
                <th align="center">Return Item</th>
               
             
            </tr>
                </thead>
                <tbody>
                  <?php
            

   

                    try{

                      $sql = " SELECT *, sales.id AS salesid FROM sps.sales LEFT JOIN sps.details on details.sales_id=sales.id LEFT JOIN sps.users1 ON users1.id=sales.user_id WHERE details.itemRec = '1' AND sales.user_id = '" . $_SESSION['user'] . "'  ORDER BY sales_date DESC ";
					  
                       $params = array();
                      $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

                      $stmt = sqlsrv_query( $conn, $sql , $params, $options );


                      // $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN details on details.sales_id=sales.id LEFT JOIN users1 ON users1.id=sales.user_id WHERE details.itemRec = 1 AND sales.user_id = '" . $_SESSION['user'] . "'  ORDER BY sales_date DESC");
                      // $stmt->execute();

                      while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                       
                        $salesid = $row['sales_id'];
                        $pid = $row['product_id'];
                        $qtyok = $row['qtyok'];

                        $sql1 = " SELECT * FROM sps.details LEFT JOIN sps.rdetails ON details.detailid=rdetails.detailid LEFT JOIN sps.products ON products.id=details.product_id WHERE details.detailid='".$row['detailid']."'  ORDER BY details.detailid DESC ";
//echo $sql1;
                        

                      $stmt1 = sqlsrv_query( $conn, $sql1 );

                        // $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN rdetails ON details.detailid=rdetails.detailid LEFT JOIN products ON products.id=details.product_id WHERE details.detailid=:id  ORDER BY details.detailid DESC");
                        // $stmt->execute(['id'=>$row['detailid']]);
                        $total = 0;
                      


                         while($details = sqlsrv_fetch_array( $stmt1, SQLSRV_FETCH_ASSOC)) {


						  $detailid = $details['detailid'];
                          $images = (!empty($details['photo'])) ? 'images/'.$details['photo'] : 'images/noimage.jpg';
                          $st = $details['detail_status'];
                          $retstat = $details['retstat'];
                          $comment = $details['notes'];
                          $rec = $details['itemRec'];
                          $eName = $details['empName'];
                          $eID = $details['empID'];
                          $qtyok = $details['qtyok'];
                          $retqty = $details['retqty']; 
                          $reason = $details['reason'];
                          $date = $details['time'];
    
						  $prodname = $details['name'];
						  $idLoc =  $details['idLoc'];
						  $noSAP = $details['noSAP'];
						  $noParts = $details['noParts'];
						 

            
                        }
                        echo "
                          <tr>
                          <td  class='hidden'></td>
                           
                            <td align='center'>".$row['sales_date']->format("d-M-y h:i a")."</td>
                            <td align='center'><img src=".$images." width='65px' height='70px'></td>
                            <td align>".'<b>Name :</b> '.strtoupper($prodname).'<br>'
                                 .'<b>ID Location :</b> '.$idLoc.'<br>'
                                 .'<b>SAP# :</b> '.$noSAP.'<br>'
                                 .'<b>Parts# :</b> '.$noParts.'<br>'
                                ."</td>


                            <td align='center'>".$qtyok."</td>
                            
                                                    

                        ";
                      
                            if( $rec == 1 && $st == 1){ 
                              echo "<form action='retupd.php' method='POST'>

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$row['detailid']."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='qnty' value='".$qtyok."' data-id='".$row['salesid']."'>

                              <td align='center'> ".'<b>Adjust Quantity to Return: </b> '." 
                               <input type='number' size='5' name='retqty' min= '1'  max='".$qtyok."'  data-id='".$row['salesid']."' required >
                               <br/><br/>

                                <input type='submit' value='Return Parts' data-id='".$row['salesid']."'> 

                                  
                              </form>

                             </td>";
                            } 
                            elseif($st == 3 && $rec == 1 && $retstat == 0){ 
                              echo "<form action='updret.php' method='POST'>

                              <input type='hidden' name='pID' value='".$pid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='dID' value='".$detailid."' data-id='".$row['salesid']."'>
                              <input type='hidden' name='sID' value='".$salesid."' data-id='".$row['salesid']."'>

                              <td>".'<b>Return Quantity : </b> '.$retqty." <br>
                              ".'<b>Please return the parts! </b> '." <br>
                              ".'OR '." <br>
                              ".'<b>Click the button to request Admin for self-collect! </b>'." <br>
                              <input type='submit' name='ping' value='Ping Admin' data-id='".$row['salesid']."'>


                              
                             </td>";
                            } 

                            elseif($st == 3 && $rec == 1 && $retstat == 1 ){ 
                              echo " <td>".'<b>Return Quantity : </b> '.$retqty." <br>
                              ".'<b>Admin has been notified!<br> Please standby with the item! </b> '." <br>
                           

                             </td>";
                            } 


                            elseif($st == 3 && $rec == 1 && $retstat == 2 || $retstat == 3 ){ 
                              echo " <td>".'<b>Return Process has been Completed at  : </b><br> '.$date->format("d-M-y h:i a")." <br>
                              
                           

                             </td>";
                            } 
                        
                        
                      
                            echo "</tr>" ;

                      }
                  
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                 //   $pdo->close();
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

