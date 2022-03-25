<?php
    include "conn.php";
    session_start();

    $empID = mysqli_real_escape_string($conn,$_REQUEST['empID']);
    $password = mysqli_real_escape_string($conn,$_REQUEST['password']);

    $sql = "SELECT * FROM sadmin where empID = '$empID' and password = '$password'";
    $res = mysqli_query($conn,$sql);
    $count = mysqli_num_rows($res);
    while ($row = mysqli_fetch_assoc($res)){
        $empID = $row['empID'];
        $userid = $row['userid'];
    }

    if($count == 1){
        $_SESSION['empID'] = $empID;
        $_SESSION['uname'] = $uname;
        header("location:index.php");
    }
    else{
        header("location:salogin.php?false=false");
    }

?>