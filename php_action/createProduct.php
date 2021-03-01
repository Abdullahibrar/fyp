<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$StoreID 		= $_POST['Store ID'];
  // $productImage 	= $_POST['productImage'];
  $NodeID 			= $_POST['Node ID'];
  

/*	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
*/				$valid['messages'] = 'Omarrrr';
				$sql = "INSERT INTO device (StoreID, NodeID) 
				VALUES ('$StoreID', '$NodeID')";
				
				if($connect->query($sql) === TRUE) {
					$valid['success'] = true;
					$valid['messages'] = "Successfully Added";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}

		//	}	
			else {
				return false;
			}	// /else	
		//} // if
	//} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST