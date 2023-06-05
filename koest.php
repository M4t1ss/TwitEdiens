<h2 style='margin:auto auto; text-align:center;'>Ko ēst?</h2>
<br/>
<div style="font-size:20px;text-align:center;">
<?php
$vardi = mysqli_query($connection, "SELECT distinct nominativs FROM words WHERE nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 3 ");

function replace($word){
		$word = str_replace('ē','e',$word);
		$word = str_replace('ū','u',$word);
		$word = str_replace('ī','i',$word);
		$word = str_replace('ā','a',$word);
		$word = str_replace('š','s',$word);
		$word = str_replace('ģ','g',$word);
		$word = str_replace('ķ','k',$word);
		$word = str_replace('ļ','l',$word);
		$word = str_replace('ž','z',$word);
		$word = str_replace('č','c',$word);
		$word = str_replace('ņ','n',$word);
		$word = str_replace('ñ','n',$word);
		$word = str_replace('ä','a',$word);
		return $word;
}

echo "Šajā ēdienreizē Tev būs jāēd ";
$sk=0;
while($r=mysqli_fetch_array($vardi)){
	$nominativs = $r["nominativs"];
	if ($sk==0)	{
		echo "<b>".$nominativs."</b>, "; 
		$e1=replace($nominativs);
	}
	if ($sk==1)	{
		echo "<b>".$nominativs."</b> un "; 
		$e2=replace($nominativs);
	}
	if ($sk==2)	{
		echo "<b>".$nominativs."</b>."; 
		$e3 = replace($nominativs);
	}
	$sk++;
}
$path='/img/food/';
?>
</div>

<div id="koest-box">
	<div style="float:left; padding:5px; display:inline;"><img class="koest" src="<?php echo $path.$e1.'.jpg'; ?>" /></div> 
	<div style="float:left; padding:5px; display:inline;"><img class="koest" src="<?php echo $path.$e2.'.jpg'; ?>" /></div> 
	<div style="float:left; padding:5px; display:inline;"><img class="koest" src="<?php echo $path.$e3.'.jpg'; ?>" /></div>
</div>