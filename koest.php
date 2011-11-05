<h1 style='margin:auto auto; text-align:center;'>Ko ēst?</h1>
<br/>
<div style="font-size:20px;text-align:center;">
<?php
//Pieslēgums DB
include "init_sql.php";
$vardi = mysql_query("SELECT distinct nominativs FROM words WHERE nominativs != '' AND nominativs != '0' ORDER BY RAND( ) LIMIT 3 ");

echo "Šajā ēdienreizē Tev būs jāēd ";
$sk=0;
while($r=mysql_fetch_array($vardi)){
	$nominativs = $r["nominativs"];
	if ($sk==0)	{echo "<b>".$nominativs."</b>, "; $e1=$nominativs;}
	if ($sk==1)	{echo "<b>".$nominativs."</b> un "; $e2=$nominativs;}
	if ($sk==2)	{echo "<b>".$nominativs."</b>."; $e3=$nominativs;}
	$sk++;
}
?>
</div>
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
	
	
    google.load('search', '1');
    function searchComplete2(searcher) {
      if (searcher.results && searcher.results.length > 0) {
        var contentDiv = document.getElementById('content2');
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
	
	
    google.load('search', '1');
    function searchComplete3(searcher) {
      if (searcher.results && searcher.results.length > 0) {
        var contentDiv = document.getElementById('content3');
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
      imageSearch.execute("<?php echo $e1;?>");
	  
      var imageSearch2 = new google.search.ImageSearch();
      imageSearch2.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,
                                 google.search.ImageSearch.IMAGESIZE_MEDIUM);
      imageSearch2.setSearchCompleteCallback(this, searchComplete2, [imageSearch2]);
      imageSearch2.execute("<?php echo $e2;?>");
	  
      var imageSearch = new google.search.ImageSearch();
      imageSearch.setRestriction(google.search.ImageSearch.RESTRICT_IMAGESIZE,
                                 google.search.ImageSearch.IMAGESIZE_MEDIUM);
      imageSearch.setSearchCompleteCallback(this, searchComplete3, [imageSearch]);
      imageSearch.execute("<?php echo $e3;?>");
    }
    google.setOnLoadCallback(OnLoad);
    </script>
<div style="margin:auto auto; width:440px;">
	<div style="float:left;padding:5px;" id="content">Ielādē...</div> 
	<div style="float:left;padding:5px;" id="content2">Ielādē...</div> 
	<div style="float:left;padding:5px;" id="content3">Ielādē...</div>
</div>