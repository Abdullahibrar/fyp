<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$StoreID = $_POST['StoreID'];
	$Brand = $_POST['Brand'];
	//$Location = $_POST['Location'];
	//$Size = $_POST['Size'];
    //$Brandid = $_POST['Brandid']


	$sql = "INSERT INTO store (StoreID, Brand ) VALUES ('$StoreID','$Brand')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST