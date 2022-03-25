<?php
session_start();
if(isset($_SESSION['empID'])){
    session_destroy();
    header("Location: salogin.php");
    exit();
}
?>