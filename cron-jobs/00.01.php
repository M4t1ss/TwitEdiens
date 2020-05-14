<?php
//pieslēdzamies vietējam SQL serverim
$db_server = "localhost";
$db_database = "twitter_alerts";
$db_user = "root";
$db_password = "root";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");

// Šo tagad dara hourly.php reizi stundā, lai grafiks atjaunotos biežāk...
// $vardi = mysqli_query($connection, "INSERT INTO baumuin_food.vardiDiena (vards, skaits, datums)
// SELECT DISTINCT ss.nominativs, count(ss.nominativs) skaits, curdate() - INTERVAL 24 HOUR FROM(
    // SELECT DISTINCT words.tvits, words.nominativs
    // FROM words, tweets
    // WHERE tweets.id = words.tvits
    // AND tweets.created_at
    // BETWEEN now( ) - INTERVAL 48 HOUR
    // AND now( ) - INTERVAL 24 HOUR
    // AND words.irediens =1
    // group by words.tvits
// ) ss
// group by ss.nominativs
// ORDER BY skaits DESC
// LIMIT 0 , 50");


   //izdzēš tvītu tabulu, ja tāda ir, un izveido jaunu
   //jeb... pārvieto informāciju uz noliktavas datubāzi
	$file_content = file("/home/baumuin/public_html/foodbot/inserts.sql");
	// Šis tika noņemts 13.05.2020
	// hourly.php to dara katru stundu
	// INSERT INTO baumuin_twitediens.vardiDiena (vards,skaits,datums)
		// SELECT vards,skaits,datums FROM baumuin_food.vardiDiena
		// WHERE vardiDiena.datums
		// BETWEEN now( ) - INTERVAL 48 HOUR
		// AND now( );
		
	$query = "";
	foreach($file_content as $sql_line){
	  if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
		$query .= $sql_line;
		if (substr(rtrim($query), -1) == ';'){
		  $result = mysqli_query($connection, $query)or die(mysqli_error($connection));
		  $query = "";
		}
	  }
	 }
?>