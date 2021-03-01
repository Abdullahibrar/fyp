


<?php require_once 'includes/header.php'; ?>

<?php 

require_once 'php_action/db_connect.php';










$sql1 = "SELECT * FROM brand";
$query = $connect->query($sql1);
$countbrands = $query->num_rows;

$nodesql1 = "SELECT * FROM device";
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
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==1) { ?>
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Total Brands
					<span class="badge pull pull-right"><?php echo $countbrands; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
	
	
	<div class="col-md-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;">
					Active Nodes
					<span class="badge pull pull-right"><?php echo $countnodes; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
			<div class="panel panel-info">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Stores
					<span class="badge pull pull-right"><?php echo $countstores; ?></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
		</div> <!--/col-md-4-->


	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo date('d'); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><?php echo date('l') .' '.date('d').', '.date('Y'); ?></p>
		  </div>
		</div> 
		<br/>
	</div>
	<div class="col-md-8">
	<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Store Info</div>
			<div class="panel-body">
				<table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Storeshariq</th>
						  <th style="width:20%;">Brand</th>
						  <th style="width:20%;">Location</th>
						  <th style="width:20%;">Node</th>
						  <th style="width:20%;">Status</th>
			  		</tr>
			  	</thead>
			  	<tbody>
					<?php while ($row = $userwiseQuery->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $row['StoreID']?></td>
							<td><?php echo $row['Brand']?></td>
							<td><?php echo $row['Location']?></td>
							<td><?php echo $row['NodeID']?></td>
							<td><?php echo $row['Status']?></td>
							
							
							
						</tr>
						
					<?php } ?>
				</tbody>
				</table>
				<!--<div id="calendar"></div>-->
			</div>	
		</div>
		
	</div> 
	</div>

	
	
	
	<?php } ?>  

	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==15) header('location:'.$store_url.'client.php');?>	
	
	
	<?php  if(isset($_SESSION['userId']) && $_SESSION['userId']==16) {?>
		
		
	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Total Devices
					<span class="badge pull pull-right"><?php echo $countbrands; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Active Devices
					<span class="badge pull pull-right"><?php echo $countbrands; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-4">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php" style="text-decoration:none;color:black;">
					Total Stores
					<span class="badge pull pull-right"><?php echo $countbrands; ?></span>	
				</a>
				
			</div> <!--/panel-hdeaing-->
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

	<div class="col-md-8">
   

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Node ID');
        data.addColumn('number', 'Count Brand');
        data.addRows([
			<?php 
           
		   $sql1 = "SELECT data.NodeID, Count(Mac) from data, device WHERE data.NodeID = device.NodeID && StoreID = 1 GROUP BY NodeID";
           $results1 = $connect->query($sql1);
           //echo "[".$row['0'].",".$row['0']."]";
           //fetch data
           while ($row = $results1->fetch_array()) {
             // $entry[] =array("0"=>array("v"=>$row['StoreID'],"f"=>NULL),"1"=>array("v"=>(int)$row['Brand'],"f" =>NULL));
               //$entry1[] = ",['".$row['StoreID']."',".$row['Brand']."]";
               //$entry2[] = array("v"=>(int)$row['Brand'],"f" =>NULL);
               
			   echo ",[".$row['NodeID'].",".$row['Count(Mac)']."]";

			}
			#connect->close();

            ?>,
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>		

<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['table']});
      google.charts.setOnLoadCallback(drawTable);

      function drawTable() {
        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Name');
        data.addColumn('number', 'Salary');
        data.addRows([
          [12,  765],
          [144,   543],
          [133, 3124],
          [211,   322],
        ]);

        var table = new google.visualization.Table(document.getElementById('table_div'));

        table.draw(data, {showRowNumber: true, width: '100%', height: '100%'});
      }
    </script>
  </head>
  <body>
    <div id="table_div"></div>
  </body>
</html>		

		<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Store Info</div>
			<div class="panel-body">
				<table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;">Storeshariq</th>
						  <th style="width:20%;">Brand</th>
						  <th style="width:20%;">Location</th>
						  <th style="width:20%;">Node</th>
						  <th style="width:20%;">Status</th>
			  		</tr>
			  	</thead>
			  	<tbody>
					<?php while ($row = $userwiseQuery->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $row['StoreID']?></td>
							<td><?php echo $row['Brand']?></td>
							<td><?php echo $row['Location']?></td>
							<td><?php echo $row['NodeID']?></td>
							<td><?php echo $row['Status']?></td>
							
							
							
						</tr>
						
					<?php } ?>
				</tbody>
				</table>
				<!--<div id="calendar"></div>-->
			</div>	
		</div>
		
	</div> 
	

	<?php  } ?>

			

</div> <!--/row-->



						
			
	   

<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
	require __DIR__ . '/vendor/autoload.php';
$client = new \Google_Client();

$client->setApplicationName('Google Sheets and PHP');

$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);

$client->setAccessType('offline');

$client->setAuthConfig(__DIR__ . '/credentials.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "1SWeUS-pj0RXc14oetUN0yO1t8Y_sAYfCiaQEoB7GgHI"; //It is present in your URL

       $get_range = "Hostel_6 A1:C20”;

	   $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);

       $values = $response->getValues();
    
	if(empty($values)){
		print"No data found.\n";
	} else {
		$mask = "%10s %-10s %s\n";
		foreach($values as $row){
			echo sprintf($mask, $row[2], $row[1], $row[0])
		}
	}




</script>






<?php require_once 'includes/footer.php'; ?>  






