<?php
//pirms cik dienām bija pirmais tvīts?
$die = mysqli_query($connection, "SELECT min( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$days = ceil($seconds / 60 / 60 / 24);

//pirms cik dienām bija jaunākais tvīts?
$die = mysqli_query($connection, "SELECT max( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$maxdays = floor($seconds / 60 / 60 / 24);

if(isset($_POST['submit'])) //ja piespiests parādīt
{
	header('Content-type: text/HTML; charset=utf-8');
   //ievācam visus mainīgos
   $no = strip_tags($_POST['from']);
   $lidz = strip_tags($_POST['to']);
	if($no==""){
	$no=date("y-m-d");
	}
	if($lidz==""){
	$lidz=date("y-m-d");
	}
	if($no==$lidz) {
		$no--;
		$no = date("y-m-d",strtotime($no."-24 hours"));
	}
	$ns=strtotime($no);
	$ls=strtotime($lidz);
	if($ns>$ls){
	$x=$no;
	$no=$lidz;
	$lidz=$x;
	}
	$no=strtotime($no);
	$no=date("Y-m-d", $no);
	$lidz=strtotime($lidz);
	$lidz=date("Y-m-d", $lidz);
}else{//ja ne, lai parādās pēdējā mēneša dati...
	$lidz =date("y-m-d", $laiks);
	$no = date("y-m-d", strtotime("-1 months", $laiks));
}
	$nn=strtotime($no);
	$nn=date("d-m-Y", $nn);
	$ll=strtotime($lidz);
	$ll=date("d-m-Y", $ll);
//pirms cik dienām bija pirmais tvīts?
$die = mysqli_query($connection, "SELECT min( created_at ) diena FROM tweets");
$mdie=mysqli_fetch_array($die);
$laiks=strtotime($mdie['diena']);
$laiks=date("U", $laiks);
$seconds = time() - $laiks;
$days = ceil($seconds / 60 / 60 / 24);
?>
<script type="text/javascript">
$(function() {
	$( "#from, #to" ).datepicker({ minDate: -<?php echo $days; ?>, maxDate: -<?php echo $maxdays; ?> });
	var dates = $( "#from, #to" ).datepicker({
		defaultDate: "+1w",
		changeMonth: true,
		onSelect: function( selectedDate ) {
			var option = this.id == "from" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
	$( "#from, #to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
	$( "#from, #to" ).datepicker($.datepicker.regional['fr']);
	$( "#to" ).datepicker({ currentText: 'Today' });
});
</script>
<?php
//pozitīvie
$kopa = mysqli_query($connection, "SELECT distinct emo, count( * ) skaits FROM tweets where created_at between '$no' AND '$lidz' group by emo order by skaits desc");
while($p=mysqli_fetch_array($kopa)){
	$noskanojums = $p["emo"];
	$text = $p["skaits"];
	switch ($noskanojums) {
		case 0:
			$nei = $text;
			break;
		case 1:
			$poz = $text;
			break;
		case -1:
			$neg = $text;
			break;
	}
}
//Ēdienu grupas
$g1 = mysqli_query($connection, "SELECT distinct grupa, count( * ) skaits FROM words, tweets  where words.tvits = tweets.id AND tweets.created_at between '$no' AND '$lidz' group by grupa order by skaits desc");
while($p=mysqli_fetch_array($g1)){
	$noskanojums = $p["grupa"];
	$text = $p["skaits"];
	switch ($noskanojums) {
		case 1:
			$g11 = $text;
			break;
		case 2:
			$g21 = $text;
			break;
		case 3:
			$g31 = $text;
			break;
		case 4:
			$g41 = $text;
			break;
		case 5:
			$g51 = $text;
			break;
		case 6:
			$g61 = $text;
			break;
		case 7:
			$g71 = $text;
			break;
		case 8:
			$g81 = $text;
			break;
	}
}
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      var chart;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart2);
      $(window).resize(drawChart2);
      function drawChart2() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Pozitīvi', <?php echo $poz ?>],
        ['Negatīvi', <?php echo $neg ?>],
        ['Neitrāli', <?php echo $nei ?>]]);
      var options = {'title':'Tvītu noskaņojums',
                     'backgroundColor':'transparent',
					 'colors': ['green', 'red', 'gray'],
                     'is3D':'true'};
      chart = new google.visualization.PieChart(document.getElementById('emo-stat'));
      chart.draw(data, options);
      google.visualization.events.addListener(chart, 'select', selectHandler);
	  }
		function selectHandler() {
		  var selection = chart.getSelection();
		  var item = selection[0];
		  if (item.row == 0){
		  setTimeout("window.location = 'grupa/pozitivi'",1);
		  }else if (item.row == 1){
		  setTimeout("window.location = 'grupa/negativi'",1);
		  }else if (item.row == 2){
		  setTimeout("window.location = 'grupa/neitrali'",1);
		  }
		}
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
	var chart1;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart1);
      $(window).resize(drawChart1);
      function drawChart1() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Alkoholisks dzēriens', <?php echo $g71; ?>],
        ['Bezalkoholisks dzēriens', <?php echo $g81; ?>]]);
      var options = {'title':'Dzērieni',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart1 = new google.visualization.PieChart(document.getElementById('dzer-stat'));
      chart1.draw(data, options);
      google.visualization.events.addListener(chart1, 'select', selectHandler2);
	  }
		function selectHandler2() {
		  var selection1 = chart1.getSelection();
		  var item1 = selection1[0];
		  if (item1.row == 0){
		  setTimeout("window.location = 'grupa/alkoholiskie'",1);
		  }else if (item1.row == 1){
		  setTimeout("window.location = 'grupa/bezalkoholiskie'",1);
		  }
		}
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
	var chart2;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      $(window).resize(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Tauki, saldumi', <?php echo $g11; ?>],
        ['Gaļa, olas, zivis', <?php echo $g21; ?>],
        ['Piena produkti', <?php echo $g31; ?>],
        ['Dārzeņi', <?php echo $g41; ?>],
        ['Augļi, ogas', <?php echo $g51; ?>],
        ['Maize, graudaugu produkti, makaroni, rīsi, biezputras, kartupeļi', <?php echo $g61; ?>]]);
      var options = {'title':'Twitter uztura piramīda',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart2 = new google.visualization.PieChart(document.getElementById('grup-stat'));
      chart2.draw(data, options);
      google.visualization.events.addListener(chart2, 'select', selectHandler1);
	  }
		function selectHandler1() {
		  var selection2 = chart2.getSelection();
		  var item2 = selection2[0];
		  if (item2.row == 0){
		  setTimeout("window.location = 'grupa/saldumi'",1);
		  }else if (item2.row == 1){
		  setTimeout("window.location = 'grupa/gala'",1);
		  }else if (item2.row == 2){
		  setTimeout("window.location = 'grupa/piens'",1);
		  }else if (item2.row == 3){
		  setTimeout("window.location = 'grupa/darzeni'",1);
		  }else if (item2.row == 4){
		  setTimeout("window.location = 'grupa/augli'",1);
		  }else if (item2.row == 5){
		  setTimeout("window.location = 'grupa/maize'",1);
		  }
		}
</script>
<h2 style='margin:auto auto; text-align:center;'>Twitter gardēžu statistika</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="statistika">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<br/>
<div id="statcontent">
	<?php
	//Tvītu kopskaits
	$kopa = mysqli_query($connection, "
	select count(text) skaits from tweets, vietas where created_at between '$no' AND '$lidz' and vietas.nosaukums = tweets.geo and vietas.valsts = 'Latvia' union
	SELECT count( distinct screen_name ) skaits FROM tweets where created_at between '$no' AND '$lidz' union
	SELECT count( distinct nominativs ) skaits FROM words union
	SELECT count( DISTINCT words.tvits ) skaits FROM words, tweets WHERE words.tvits = tweets.id AND tweets.created_at between '$no' AND '$lidz' union
	SELECT count( * ) skaits FROM tweets where created_at between '$no' AND '$lidz' union
	SELECT count( geo ) skaits FROM tweets where created_at between '$no' AND '$lidz' and geo!=''
	");
	$geogr = mysqli_query($connection, "SELECT count( nosaukums ) vietas,  count( distinct valsts ) valstis FROM vietas");
		$h=mysqli_fetch_array($geogr);
		$dazvietas = $h["vietas"];
		$dazvalst = $h["valstis"];
	for($i=1;$i<7;$i++){
		$p=mysqli_fetch_array($kopa);
		$text = $p["skaits"];
		switch ($i) {
			case 1:
				$lv = $text;
				break;
			case 2:
				$scrnme = $text;
				break;
			case 3:
				$vardi = $text;
				break;
			case 4:
				$tvparedkopa = $text;
				break;
			case 5:
				$tvkopa = $text;
				break;
			case 6:
				$atrviet = $text;
				break;
		}
	}
	echo "Kopā par ēšanas tēmām ir <b>".$tvkopa."</b> tvītu.<br/>";
	echo "Kopā ir <b>".$tvparedkopa."</b> tvītu, kuros pieminēts kāds ēdiens vai dzēriens.<br/>";
	echo "Tos rakstījuši <b>".$scrnme."</b> dažādi lietotāji.<br/>";
	echo "<b>".$atrviet."</b> no tiem norādīta atrašanās vieta.<br/>";
	echo "<b>".$lv."</b> no tiem ir rakstīti Latvijā.<br/>";
	echo "<b>".($atrviet-$lv)."</b> no tiem ir rakstīti ārzemēs.<br/>";
	echo "Kopā ir <b>".$dazvietas."</b> dažādas atrašanās vietas <b>".$dazvalst."</b> dažādās valstīs.<br/>";
	echo "Kopā ir pieminēti <b>".$vardi."</b> dažādi ēdieni un dzērieni.<br/>";
	?>
	<h4><a href="smaidi"><button class="classname" type="button">Smaidiņu statistika</button></a></h4>
</div>
<script type="text/javascript">
  function drawVisualization() {
	// Create and populate the data table.
	var data = new google.visualization.DataTable();
	var raw_data = [['Ievāktie tvīti kopā', <?php echo $tvkopa; ?>],
					['Tvīti, kuros minēts ēdiens vai dzēriens', <?php echo $tvparedkopa; ?>],
					['Tvīti, kuriem norādīta atrašanās vieta', <?php echo $atrviet; ?>],
					['Tvīti, kuri rakstīti Latvijā', <?php echo $lv; ?>],
					['Tvīti, kuri rakstīti ārzemēs', <?php echo $nlv; ?>]
					];
	var years = [''];
	var options = {'title':'Twitter uztura piramīda',
				 'backgroundColor':'transparent',
				 };
	data.addColumn('string', 'Year');
	for (var i = 0; i  < raw_data.length; ++i) {
	  data.addColumn('number', raw_data[i][0]);    
	}
	data.addRows(years.length);
	for (var j = 0; j < years.length; ++j) {    
	  data.setValue(j, 0, years[j].toString());    
	}
	for (var i = 0; i  < raw_data.length; ++i) {
	  for (var j = 1; j  < raw_data[i].length; ++j) {
		data.setValue(j-1, i+1, raw_data[i][j]);    
	  }
	}
	new google.visualization.BarChart(document.getElementById('kop-stat')).
		draw(data,
			 {	title:"Tvītu statistika",
				hAxis: {title: "Tvīti"},
				backgroundColor:'transparent'
			  }
		);
  }
  google.setOnLoadCallback(drawVisualization);
  $(window).resize(drawVisualization);
</script>
<br/>
<div style="text-align:center;">
	<div class="chart" id="emo-stat"></div>
    <div class="chart" id="kop-stat"></div>
	<br/ style="clear:both;">
	<div class="chart" id="grup-stat"></div>
	<div class="chart" id="dzer-stat"></div>
</div>
