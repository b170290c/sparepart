<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
 include 'includes/session.php';
 
// Check connection
if($conn === false){
    die( print_r( sqlsrv_errors(), true));
}
 
if(isset($_REQUEST["term"])){
    // Prepare a select statement
    $sql = "SELECT * FROM sps.products WHERE name LIKE '?' ";

    $params = array(); 
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql , $params, $options );

    
    
        // Bind variables to the prepared statement as parameters
        sqlsrv_stmt_bind_param($stmt, "s", $param_term);
        
        // Set parameters
        $param_term = $_REQUEST["term"] . '%';
        
        // Attempt to execute the prepared statement
    
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                // Fetch result rows as an associative array
               while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {

                    echo "<p>" . $row["name"] . "</p>";
                }
            } else{
                echo "<p>No matches found</p>";
            }
         
    
     
    // Close statement
  sqlsrv_free_stmt($stmt);

 
// close connection
sqlsrv_close($conn);
?>