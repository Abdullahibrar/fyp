<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$NodeID = $_POST['NodeID'];

if($NodeId) { 

 $sql = "DELETE FROM device WHERE NodeID = {$NodeID}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Successfully Removed";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST