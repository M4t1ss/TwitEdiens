<?php

header("Content-type: text/html; charset=utf-8");
include "includes/init_sql.php";



if($_POST['submit']) //ja piespiests gatavs
{
	$vards = array_keys($_POST);
	$i=0;
	foreach ($_POST as $irnav) {
		if(isset($irnav) && $irnav!=''){
		$vards[$i] = str_replace('1','',$vards[$i]);
		$vards[$i] = str_replace('2','',$vards[$i]);
		$result=mysqli_query($connection, "UPDATE words set grupa = '$irnav' where nominativs = '$vards[$i]'"); 
		}
		$i++;
	}
   echo "<script type=\"text/javascript\">setTimeout(\"window.location = 'grup.php'\",5);</script>";

}else{

$q = mysqli_query($connection, "SELECT DISTINCT nominativs FROM words where nominativs!='0' and grupa='0' order by nominativs LIMIT 0 , 20");
$bg = TRUE;
?>
<form method="post" action="grup.php">
<TABLE>
<tr>
<th>Vārds</th>
<th>Grupa</th>
</tr>
<?php

while($r=mysqli_fetch_array($q)){
   $vards=$r["nominativs"];   
?>

<TR <?php if($bg) echo 'style="background-color:#D9D9D9;"';?> >
   <TD><?php echo $vards; ?></TD>
   <td>
   <select NAME="<?php echo $vards; ?>2">
		   <OPTION VALUE="">
		   <OPTION VALUE="1">Tauki, saldumi
		   <OPTION VALUE="2">Gaļa, olas, zivis
		   <OPTION VALUE="3">Piena produkti
		   <OPTION VALUE="4">Dārzeņi
		   <OPTION VALUE="5">Augļi, ogas
		   <OPTION VALUE="6">Maize, graudaugu produkti, makaroni, rīsi, biezputras, kartupeļi
		   <OPTION VALUE="7">Alkoholisks dzēriens
		   <OPTION VALUE="8">Bezalkoholisks dzēriens
   </select>
   </TD>
</TR>

<?php
$bg=!$bg;
}
}
?>
   <TD><INPUT style="float:left;" TYPE="submit" name="submit" value="gatavs"/></TD> 
</TABLE>
</form>