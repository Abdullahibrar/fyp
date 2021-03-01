<?php 	

require_once 'core.php';

$sql = "SELECT StoreID, Brand, Location, Size from store";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
	 $brandId = $row[0];
	 
 	// active 
 	$activeBrands = $row[1];
	 $location = $row[2];
	$storeid = $row[3];
 	$button = '<!-- Single button -->
	<div class="btn-group">
	  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    Action <span class="caret"></span>
	  </button>
	  <ul class="dropdown-menu">
	    <li><a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands('.$brandId.')"> <i class="glyphicon glyphicon-edit"></i> Edit</a></li>
	    <li><a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$brandId.')"> <i class="glyphicon glyphicon-trash"></i> Remove</a></li>       
	  </ul>
	</div>';

 	$output['data'][] = array( 		
		 $row[0], 
		 	
 		$activeBrands,
		 $location,
		 $storeid,
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);