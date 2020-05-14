<?php
//pieslēdzamies vietējam SQL serverim
$db_server = "localhost";
$db_database = "baumuin_food";
$db_user = "baumuin_bauma";
$db_password = "{GIwlpQ<?3>g";
//pieslēdzamies SQL serverim
$connection = mysqli_connect($db_server, $db_user, $db_password, $db_database);
mysqli_set_charset($connection, "utf8mb4");

$date = date("Y-m-d");
$from = $date." 00:00:01";
$to = $date." 23:59:59";



$TEST = "SELECT * FROM baumuin_twitediens.vardiDiena WHERE datums = \"$date\"";

$DELETE = "DELETE FROM baumuin_food.vardiDiena WHERE datums = \"$date\"";
$DELETE2 = "DELETE FROM baumuin_twitediens.vardiDiena WHERE datums = \"$date\"";

$SELECT = "SELECT DISTINCT ss.nominativs, count(ss.nominativs) skaits, \"$date\" FROM(
    SELECT DISTINCT words.tvits, words.nominativs
    FROM words, tweets
    WHERE tweets.id = words.tvits
    AND tweets.created_at
    BETWEEN \"$from\"
    AND \"$to\"
    AND words.irediens =1
    group by words.tvits
) ss
group by ss.nominativs
ORDER BY skaits DESC
LIMIT 0 , 50";


$INSERT = "INSERT INTO baumuin_food.vardiDiena (vards, skaits, datums)
".$SELECT;

$COPY = "INSERT INTO baumuin_twitediens.vardiDiena (vards, skaits, datums)
	SELECT vards, skaits, datums FROM baumuin_food.vardiDiena
	WHERE vardiDiena.datums = \"$date\"";

// $vardi = mysqli_query($connection, $TEST);
// run_test($vardi);
$vardi = mysqli_query($connection, $DELETE);
$vardi = mysqli_query($connection, $INSERT);
$vardi = mysqli_query($connection, $DELETE2);
$vardi = mysqli_query($connection, $COPY);
// $vardi = mysqli_query($connection, $TEST);
// run_test($vardi);


// //izdzēš tvītu tabulu, ja tāda ir, un izveido jaunu
// //jeb... pārvieto informāciju uz noliktavas datubāzi
// $file_content = file("/home/baumuin/public_html/foodbot/inserts.sql");
// $query = "";
// foreach($file_content as $sql_line){
  // if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
	// $query .= $sql_line;
	// if (substr(rtrim($query), -1) == ';'){
	  // $result = mysqli_query($connection, $query)or die(mysqli_error());
	  // $query = "";
	// }
  // }
 // }



function run_test($rez){
	$i = 0;
	while($r = mysqli_fetch_array($rez)){
		$i+=1;
		$vards	= $r["vards"];
		$skaits	= $r["skaits"];
		$datums	= $r["datums"];
		
		echo trim($vards)." - ";
		echo trim($skaits)." - ";
		echo trim($datums);
		echo "</br></br>";
	}
		echo trim($i);
		echo "</br>";
}