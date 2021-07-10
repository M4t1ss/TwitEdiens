<?php
$vards=urldecode($_GET['vieta']);
?>
<h2 style='margin:auto auto; text-align:center;'><?php echo $vards; ?></h2>
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
$tviti = mysqli_query($connection, "SELECT screen_name, text, created_at FROM tweets where geo = '$vards' order by created_at desc");

$krasa=TRUE;
echo "<table id='results' style='margin:auto auto;'>";
echo "<tr>
<th>Lietotājs</th>
<th>Tvīts</th>
<th>Laiks</th>
</tr>";
while($p=mysqli_fetch_array($tviti)){
	$niks = $p["screen_name"];
	$teksts = $p["text"];
	$datums = $p["created_at"];
	$laiks = strtotime($datums);
	$laiks = date("d.m.Y H:i", $laiks);
	
	if ($krasa==TRUE) {$kr=" class='even'";}else{$kr="";}
	echo '<tr'.$kr.'><td><b><a style="text-decoration:none;color:#658304;" href="/draugs/'.$niks.'">'.$niks.'</a></b></td><td>'.$teksts.'</td><td>'.$laiks.'</td></tr>';
	$krasa=!$krasa;
}
echo "</table>";
?>
</div>