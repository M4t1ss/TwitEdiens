<?php
	//SQL pieslçgðanâs informâcija
	$db_server = "localhost";
	$db_database = "twitter_alerts";
	$db_user = "root";
	$db_password = "root";

	//pieslçdzamies SQL serverim
	$connection = @mysql_connect($db_server, $db_user, $db_password);
	mysql_set_charset("utf8", $connection);
	mysql_select_db($db_database);
	
	//Now, two possibilities: if we don't have a start parameter, we print the last ten tweets.
	//Otherwise, we print all the tweets with IDs bigger than start, if any
	$start = mysql_real_escape_string($_GET['start']);
	if(! $start){
		$query = "SELECT * FROM (SELECT * FROM tweets ORDER BY id DESC LIMIT 0,10) AS last_ten ORDER BY id ASC";
	}else{
		$query = "SELECT * FROM (SELECT * FROM tweets WHERE id>".$start." ORDER BY id DESC LIMIT 0,10) AS new_tweets ORDER BY id ASC";
	}

	$result = mysql_query($query);
	$data = array(); //Initializing the results array
    
	while ($row = mysql_fetch_assoc($result)){
		array_push($data, $row);
	}
	$json = json_encode($data);
	print $json;
?>