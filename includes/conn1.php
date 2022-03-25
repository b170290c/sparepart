


<?php
$serverName = "F2-LAPTOP-MPC\SQLEXPRESS"; //serverName\instanceName
$connectionInfo = array( "Database"=>"sps", "UID"=>"", "PWD"=>"");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    // echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>


