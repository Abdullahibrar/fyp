
<?php 
require __DIR__ . '/vendor/autoload.php';
$client = new \Google_Client();   
$client->setApplicationName('FYP-Node_IL');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig(__DIR__ . '/credentials.json');
$service = new Google_Service_Sheets($client);
$spreadsheetId = "1SWeUS-pj0RXc14oetUN0yO1t8Y_sAYfCiaQEoB7GgHI"; //It is present in your URL

       $get_range = "Hostel_6!A1:C20";

	   $response = $service->spreadsheets_values->get($spreadsheetId, $get_range);

       $values = $response->getValues();
        
    if(empty($values)) {
	    print "data found.\n";
	} else {
		$mask = "%10s %-10s %s\n";
		foreach($values as $row){
			echo sprintf($mask, $row[2], $row[1], $row[0]);
		}
    }
    ?>