<?php
// db settings
include 'includes/session.php';

 $counter = 1;
  

// fetch records
$sql = " SELECT products.id AS prodid,  category.name AS catname, vendor.name AS vename,products.name AS prodname, products.description AS description, products.photo AS photo, products.date_view AS date_view, products.price AS price, products.qnty AS qnty,  products.ownqnty AS ownqnty, products.minqnty AS minqnty, products.mls AS mls, products.roq AS roq, products.leadtime AS leadtime, products.recdate AS recdate, products.idLoc AS idLoc, products.noSerial AS noSerial, products.noSAP AS noSAP, products.noParts AS noParts FROM sps.products LEFT JOIN sps.category ON category.id=products.category_id LEFT JOIN sps.vendor ON vendor.id= products.vendor_id ";
$result = sqlsrv_query($conn, $sql);

while($row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC)) {
	 $image = (!empty($row['photo'])) ? '../images/'.$row['photo'] : '../images/noimage.jpg';

     $editphoto = " <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['prodid']."'><i class='fa fa-edit'></i></a></span> ";

     //product photo
     $prodimg = $image. " ".$editphoto;

    // Update Button
     $updateButton = " <button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['prodid']."'><i class='fa fa-edit'></i> Edit</button>";

     // Delete Button
     $deleteButton = " <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['prodid']."'><i class='fa fa-trash'></i> Delete</button>";

    // $array[] = $row;
      $action = $updateButton." ".$deleteButton;
  
 $data[] = array(
  				"id"=>$counter,
                "name"=> $row['prodname'],
                "vendor" => $row['vename'],
                "photo"=>$image,
                "price"=> $row['price'],
                "qnty"=> $row['qnty'],
                "ownqnty"=> $row['ownqnty'],
                "rop"=> $row['minqnty'],
                "mls"=> $row['mls'],
                "roq"=> $row['roq'],
                "leadtime"=> $row['leadtime'],
                "recdate"=> $row['recdate']->format("d/M/y"),
                "idLoc"=> $row['idLoc'],
                "noSAP"=> $row['noSAP'],
                "noParts"=> $row['noParts'],
                "tools" => $action,
                "prodimg"=>$prodimg,

            );

$counter++;
}

$dataset = array(
   
    "totalrecords" => count($data),
    "totaldisplayrecords" => count($data),
    "data" => $data
);

echo json_encode($dataset);
?>