<html>
<head>
    <title>Weight Tracker</title>
</head>
<body>
<?php

require_once 'php_action/db_connect.php';

session_start();
$_SESSION['userId'] = 1;

//execute query
$sql = "SELECT id, course_name, number FROM courses";
$results = $connect->query($sql);

//fetch data
while ($row = $results->fetch_array()) {
   $entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
    $entry1[] = ",['".$row['course_name']."',".$row['number']."]";
    //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
}

echo $format = json_encode($entry1);


    
//close the connection
#$dbhandle->close();
?>

<div id="piechart" style="width: 100%; height: 500px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["piechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['course',	'number']
            <?php 
           $sql = "SELECT id, course_name, number FROM courses";
           $results = $connect->query($sql);
           
           //fetch data
           while ($row = $results->fetch_array()) {
              //$entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
               //$entry1[] = ",['".$row['course_name']."',".$row['number']."]";
               //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
               echo ",['".$row['course_name']."',".$row['number']."]";
           }
            
            ?>,
           
        ]);

      


        var options = {
            title: 'Weight Tracker',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
</script>
</body>
</html>