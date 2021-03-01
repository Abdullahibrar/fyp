


<?php require_once 'includes/header.php'; ?>

<?php 

require_once 'php_action/db_connect.php';










$sql1 = "SELECT NodeID FROM device as d, store as s, brands as b WHERE d.StoreID = s.StoreID && b.brand_id = s.BrandID && b.brand_id = 1";
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
                    Total Devices
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
                    Available Devices
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
                    Total Stores
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
<div id="piechart" style="width: 100%; height: 500px;"></div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["piechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['location','Count(NodeID)']
            <?php 
           $sql = "SELECT store.location, Count(NodeID) from store, device, brands where brands.brand_id = store.brandID && store.StoreID = device.StoreID && brands.brand_id = 1 GROUP BY store.location";
           $results = $connect->query($sql);
           
       
           //fetch data
           while ($row = $results->fetch_array()) {
              //$entry[] =array("0"=>array("v"=>$row['course_name'],"f"=>NULL),"1"=>array("v"=>(int)$row['number'],"f" =>NULL));
               //$entry1[] = ",['".$row['course_name']."',".$row['number']."]";
               //$entry2[] = array("v"=>(int)$row['number'],"f" =>NULL);
               echo ",['".$row['location']."',".$row['Count(NodeID)']."]";

              
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
<div class="card">

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Store ID');
        data.addColumn('string', 'Store Location');
        data.addColumn('number', 'NodeID');
        data.addColumn('string', 'Node Location');
        data.addRows([
             /*
	 	   $sql1 = "SELECT store.StoreID, store.location, NodeID, device.Location from store, device, brands where brands.brand_id = store.brandID && store.StoreID = device.StoreID && brands.brand_id = 1";
           $results1 = $connect->query($sql1);
           //echo "[".$row['0'].",".$row['0']."]";
           //fetch data
          $counttable = 0;
           while ($row = $results1->fetch_array()) {
             // $entry[] =array("0"=>array("v"=>$row['StoreID'],"f"=>NULL),"1"=>array("v"=>(int)$row['Brand'],"f" =>NULL));
               //$entry1[] = ",['".$row['StoreID']."',".$row['Brand']."]";
               //$entry2[] = array("v"=>(int)$row['Brand'],"f" =>NULL);
               
               if($counttable == 0){
                echo "[".$row['StoreID'].",   ".$row['location'].",   ".$row['NodeID'].",   ".$row['Location']."]";
               }

               else{
			    echo ",[".$row['StoreID'].",   ".$row['location'].",   ".$row['NodeID'].",   ".$row['Location']."]";
               //echo "<br> id: " . $row["NodeID"]. " - Name: " . $row["Count(Mac)"]. "<br>";
               }
                $counttable = $counttable + 1;
			}
            ?>*/
        [1,'Centaurus',1,'North'],[1,'Centaurus',2,'South'],[1,'Centaurus',3,'West'],[11,'Dolmen Mall',4,'North'],[11,'Dolmen Mall',5,'South']
        ]);

        var options = {
           
            
        };

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>		
	</div>	
    </div>	

</div> <!--/row-->




<?php require_once 'includes/footer.php'; ?>  






