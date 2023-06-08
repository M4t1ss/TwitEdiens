<?php
$page = $_SERVER['PHP_SELF'];
$sec = "10";

$myfile = '/home/baumuin/error_log';
$command = "tac $myfile > /tmp/myfilereversed.txt";
exec($command);
$currentRow = 0;
$numRows = 55;  // stops after this number of rows
$handle = fopen("/tmp/myfilereversed.txt", "r");
?>
<html>
    <head>
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
	<?php
	while (!feof($handle) && $currentRow <= $numRows) {
	   $currentRow++;
	   $buffer = fgets($handle, 4096);
	   echo $buffer."<br>";
	}
	fclose($handle);
	?>
    </body>
</html>