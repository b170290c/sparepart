<?php
include 'includes/session.php';


$pid = $_POST['pID'];
$did = $_POST['dID'];
$sid = $_POST['sID'];
$balqty = $_POST['balqty'];
$qty = $_POST['qty'];
$oldqty = $_POST['oldqty'];
$relqty = $_POST['relqty'];
$ownqty = $_POST['ownqty'];



$date = date_default_timezone_set("Asia/Singapore");
$date = date('Y-m-d H:i:s');

//total released qnty
$newqty = $qty + $relqty;

//balance quantity to give
$balqty1 = $balqty - $relqty;

//product quantity
$pqty1 = $ownqty - $relqty;



//echo $balqty1;

//$conn = $pdo->open();


  if( $pqty1 < 0  ){



     header("location:ongoing.php?fail=fail");
     exit();

    }





try{
          if($newqty == $oldqty)
            {

              $sql = " UPDATE sps.ongoing SET  orderstat='2'  WHERE detailid='".$did."' ";
              $stmt = sqlsrv_query($conn , $sql);
            	 // $stmt = $conn->prepare("UPDATE ongoing SET  orderstat=:orderstat  WHERE detailid=:did");
            	 // $stmt->execute([ 'orderstat'=>2 , 'did'=>$did ]);

              $sql = " UPDATE sps.details SET  dates='".$date."'   WHERE detailid='".$did."' ";
              $stmt = sqlsrv_query($conn , $sql);

            	 // $stmt = $conn->prepare("UPDATE details SET  dates=:dates   WHERE detailid=:did");
            	 // $stmt->execute([ 'dates'=>$date,  'did'=>$did ]);

header("location:ongoing2.php?dID=$did");

            }
            
            else{

               $sql = " UPDATE sps.ongoing SET  orderstat='2'  WHERE detailid='".$did."' ";
              $stmt = sqlsrv_query($conn , $sql);


            // $stmt = $conn->prepare("UPDATE ongoing SET  orderstat=:orderstat  WHERE detailid=:did");
            // $stmt->execute([ 'orderstat'=>2 , 'did'=>$did ]);

             $sql = " UPDATE sps.details SET  dates='".$date."'   WHERE detailid='".$did."' ";
              $stmt = sqlsrv_query($conn , $sql);
 

            
 header("location:ongoing.php");
}

      
      }


    
      catch(PDOException $e){
        $_SESSION['error'] = $e->getMessage();
    }







    //$pdo->close();



 ?>
 






























?>