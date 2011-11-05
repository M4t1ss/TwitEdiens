<?php
$vards=urldecode($_GET['vards']);
?>
<h1 style='margin:auto auto; text-align:center;'><?php echo $vards; ?></h1>
<br/>
    <script src="https://www.google.com/jsapi?key=ABQIAAAAwNLfFSirmOLKkKGBImYROhR-aFOkHTCPd8GmiU2WFD4CBmb8xhT4K2zPKmh7e3lAi4XgaludyidIAw" type="text/javascript"></script>
    <script type="text/javascript">
    google.load('search', '1');
    function searchComplete(searcher) {
      if (searcher.results && searcher.results.length > 0) {
        var contentDiv = document.getElementById('content');
        contentDiv.innerHTML = '';
        var results = searcher.results;
          var result = results[0];
          var imgContainer = document.createElement('div');
          var newImg = document.createElement('img');
          newImg.src = result.tbUrl;
          imgContainer.appendChild(newImg);
          contentDiv.appendChild(imgContainer);
      }
    }
    function OnLoad() {
      var imageSearch = new google.search.ImageSearch();
      imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,
                                 google.search.ImageSearch.IMAGESIZE_MEDIUM);
      imageSearch.setSearchCompleteCallback(this, searchComplete, [imageSearch]);
      imageSearch.execute("<?php echo $vards;?>");
    }
    google.setOnLoadCallback(OnLoad);
    </script>
<div style="margin:auto auto; width:100px;">
	<div style="padding:5px;" id="content">Ielādē...</div> 
</div>
<div >
<?php
//Pieslēgums DB
include "init_sql.php";
$vardi = mysql_query("SELECT tvits FROM words where nominativs = '$vards'");

$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
</tr>";
while($r=mysql_fetch_array($vardi)){
	$tvits = $r["tvits"];
	$tviti = mysql_query("SELECT screen_name, text FROM tweets where id = '$tvits'");
	$p=mysql_fetch_array($tviti);
	$niks = $p["screen_name"];
	$teksts = $p["text"];
	if ($krasa==TRUE) {$kr=" style='background-color:#E0E0E0'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="?id=draugs&dra='.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
?>
</div>