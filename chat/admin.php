<?php

include 'session.php';
$row=mysqli_fetch_array($query);

if ($row['access']==1){
  $_SESSION['id']=$row['userid'];
  ?>

  <script>
    alert('Login Success, Welcome Admin!');
    window.location.href='admin/';
  </script>
  <?php
}
?>
