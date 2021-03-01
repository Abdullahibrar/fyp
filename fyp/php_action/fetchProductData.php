<?php 	

require_once 'core.php';

$sql = "SELECT NodeID, Status, Location, StoreID from device";
$result = $connect->query($sql);

$data = $result->fetch_all();

$connect->close();

echo json_encode($data);