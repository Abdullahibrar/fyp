<?php
require_once 'php_action/db_connect.php';

session_start();
#include('db.php');
$sql = "select * from courses";
$query = mysql_query($sql);
while($result = mysql_fetch_array($query))
{
    $errors[] = "Incorrect2";
$rows[]=array("c"=>array("0"=>array("v"=>$result['subject'],"f"=>NULL),"1"=>array("v"=>(int)$result['number'],"f" =>NULL)));

}

echo $format = '{
"cols":
[
{"id":"","label":"Subject","pattern":"","type":"string"},
{"id":"","label":"Number","pattern":"","type":"number"}
],
"rows":'.json_encode($rows).'}';

?>