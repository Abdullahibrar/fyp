


<?php require_once 'includes/header.php'; ?>

<?php 

require_once 'php_action/db_connect.php';










$sql1 = "SELECT MAX(countmac) FROM hourlyrate";
$query = $connect->query($sql1);
$counttotal = $query->num_rows;

$nodesql1 = "SELECT NodeID FROM device as d, store as s, brands as b WHERE d.StoreID = s.StoreID && b.brand_id = s.BrandID && b.brand_id = 1 && d.status = 'True'";
$nodequery = $connect->query($nodesql1);
$countnodes = $nodequery->num_rows;

$storesql1 = "SELECT * FROM store";
$storequery = $connect->query($storesql1);
$countstores = $storequery->num_rows;

$orderSql = "SELECT * FROM orders WHERE order_status = 1";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;

$totalRevenue = "";
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

$lowStockSql = "SELECT * FROM product WHERE quantity <= 3 AND status = 1";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

$userwisesql = "SELECT Store.StoreID, Store.Brand, Store.Location,  Device.NodeID, Device.Status
FROM Store, Device
WHERE Device.StoreID=Store.StoreID
Group by Device.NodeID; ";
$userwiseQuery = $connect->query($userwisesql);
//$userwieseOrder = $userwiseQuery->num_rows;

$sql = "SELECT id, course_name, number FROM courses";
           $results = $connect->query($sql);





?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row">

<div class="col-md-4">
		<div class="card">

		  <div class="cardContainer">
          <a href="product.php" style="text-decoration:none;color:black;">
                    Peak Consumer
					<span class="badge pull pull-right" style="text-align:center"><?php echo $counttotal; ?></span>	
		    </a>
                
		  </div>
		</div> 
		<br/>
</div>
	
<div class="col-md-4">
		<div class="card">

		  <div class="cardContainer">
          <a href="product.php" style="text-decoration:none;color:black;">
                    Peak Hour
					<span class="badge pull pull-right" style="text-align:center"><?php echo $countnodes; ?></span>	
				</a>
                
		  </div>
		</div> 
		<br/>
</div>

<div class="col-md-4">
		<div class="card">

		  <div class="cardContainer">
          <a href="product.php" style="text-decoration:none;color:black;">
                    Average Consumer
					<span class="badge pull pull-right" style="text-align:center"><?php echo $countstores; ?></span>	
				</a>
                
		  </div>
		</div> 
		<br/>
</div>

</div>


<div class="row">

<div class="col-md-4">
<div class="card">

<a style="text-decoration:none;color:black;">Store Coverage</a>
<div id="piechart" style="width: 100; height: 600px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["piechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['store.StoreID','Count(MAC)']
            <?php 
           $sql = "SELECT store.StoreID, Count(MAC) from data, device, store WHERE device.NodeID = data.NodeID && device.StoreID = store.StoreID && store.BrandID = 1 GROUP BY StoreID";
           $results = $connect->query($sql);
           
       
           //fetch data
           while ($row = $results->fetch_array()) {
              //$entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
               //$entry1[] = ",['".$row['course_name']."',".$row['number']."]";
               //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
               echo ",['".$row['StoreID']."',".$row['Count(MAC)']."]";

              
           }
            ?>,
        ]);

        var options = {
            curveType: 'function',
            legend: { position: 'left' },
            animation: {"startup": true}
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    </script>
  </head>
  <body>
    <div id="pie_div"></div>
  </body>
</html>		
	
</div>
</div>




<div class="col-md-8">
<div class="card" style="padding: 15px">


<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['cast(Time as time)','Consumer']
            <?php 
           $sql = "SELECT cast(Time as time), countmac FROM hourlyrate WHERE countmac <> 0";
           $results = $connect->query($sql);
           
       
           //fetch data
           while ($row = $results->fetch_array()) {
              //$entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
               //$entry1[] = ",['".$row['course_name']."',".$row['number']."]";
               //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
               echo ",['".$row['cast(Time as time)']."',".$row['countmac']."]";

              
           }
            ?>,
        ]);

        var options = {
          title: 'Company Performance',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="curve_chart" style="width: 700px; height: 400px; padding: 5px"></div>
  </body>
</html>

</div>	
</div>

<div class="col-md-8">
<div class="card">

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Date','Sum(countmac)']
            <?php 
           $sql = "SELECT cast(Time as date), Sum(countmac) FROM hourlyrate WHERE countmac <> 0 GROUP BY DATE(hourlyrate.Time)";
           $results = $connect->query($sql);
           
       
           //fetch data
           while ($row = $results->fetch_array()) {
              //$entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
               //$entry1[] = ",['".$row['course_name']."',".$row['number']."]";
               //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
               echo ",['".$row['cast(Time as date)']."',".$row['Sum(countmac)']."]";

              
           }
            ?>,
        ]);

        var options = {
          chart: {
            title: 'Day based performace',
            subtitle: '',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
    <div id="barchart_material" style="width: 800px; height: 300px; border:10px; padding: 50px"></div>
  </body>
</html>


</div>	
</div>

</div> <!--/row-->





<?php require_once 'includes/footer.php'; ?>  






