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
$sql = "SELECT * FROM store";
$results = $connect->query($sql);

//fetch data
while ($row = $results->fetch_array()) {
   $entry[] =array("0"=>array("v"=>$row['StoreID'],"f"=>NULL),"1"=>array("v"=>(int)$row['Brand'],"f" =>NULL));
    $entry1[] = ",['".$row['Location']."',".$row['Brand']."]";
    //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
}

echo $format = json_encode($entry1);




    
//close the connection
#$dbhandle->close();
?>

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Work',     11],
          ['Eat',      2],
          ['Commute',  2],
          ['Watch TV', 2],
          ['Sleep',    7]
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.BarChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>









<div id="piechart" style="width: 100%; height: 500px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["piechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['NodeID', 'Count(MAC)']

            <?php 
           $sql = "SELECT data.NodeID, Count(Mac) from data, device WHERE data.NodeID = device.NodeID && StoreID = 1 GROUP BY NodeID";
           $results = $connect->query($sql);
           
           //fetch data
           while ($row = $results->fetch_array()) {
             // $entry[] =array("0"=>array("v"=>$row['StoreID'],"f"=>NULL),"1"=>array("v"=>(int)$row['Brand'],"f" =>NULL));
               //$entry1[] = ",['".$row['StoreID']."',".$row['Brand']."]";
               //$entry2[] = array("v"=>(int)$row['Brand'],"f" =>NULL);
               echo ",['".$row['NodeID']."',".$row['Count(Mac)']."]";
           }
            ?>,
           
        ]);

           
        var options = {
            title: 'Nike Store',
            curveType: 'function',
            legend: { position: 'bottom' }
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);

        
    }
    $dbhandle->close();

</script>
</body>
</html>