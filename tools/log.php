<?php
$myfile = '/home/baumuin/error_log';
$command = "tac $myfile > /tmp/myfilereversed.txt";
exec($command);
$currentRow = 0;
$numRows = 35;  // stops after this number of rows
$handle = fopen("/tmp/myfilereversed.txt", "r");
while (!feof($handle) && $currentRow <= $numRows) {
   $currentRow++;
   $buffer = fgets($handle, 4096);
   echo $buffer."<br>";
}
fclose($handle);
?>