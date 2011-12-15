<?php
//pozitīvie
$kopa = mysql_query("SELECT count( * ) skaits FROM tweets where emo = 1");
$r=mysql_fetch_array($kopa);
$poz = $r["skaits"];
//negatīvie
$kopa = mysql_query("SELECT count( * ) skaits FROM tweets where emo = 2");
$r=mysql_fetch_array($kopa);
$neg = $r["skaits"];
//neitrālie
$kopa = mysql_query("SELECT count( * ) skaits FROM tweets where emo = 3");
$r=mysql_fetch_array($kopa);
$nei = $r["skaits"];
//Tauki, saldumi
$g1 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 1");
$r1=mysql_fetch_array($g1);
$g11 = $r1["skaits"];
//Gaļa, olas, zivis
$g2 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 2");
$r2=mysql_fetch_array($g2);
$g21 = $r2["skaits"];
//Piena produkti
$g3 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 3");
$r3=mysql_fetch_array($g3);
$g31 = $r3["skaits"];
//Dārzeņi
$g4 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 4");
$r4=mysql_fetch_array($g4);
$g41 = $r4["skaits"];
//Augļi, ogas
$g5 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 5");
$r5=mysql_fetch_array($g5);
$g51 = $r5["skaits"];
//Maize, graudaugu produkti, makaroni, rīsi, biezputras, kartupeļi
$g6 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 6");
$r6=mysql_fetch_array($g6);
$g61 = $r6["skaits"];
//Alkoholisks dzēriens
$g7 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 7");
$r7=mysql_fetch_array($g7);
$g71 = $r7["skaits"];
//Bezalkoholisks dzēriens
$g8 = mysql_query("SELECT count( * ) skaits FROM words where grupa = 8");
$r8=mysql_fetch_array($g8);
$g81 = $r8["skaits"];
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      var chart;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Pozitīvi', <?php echo $poz ?>],
        ['Negatīvi', <?php echo $neg ?>],
        ['Neitrāli', <?php echo $nei ?>]]);
      var options = {'title':'Tvītu noskaņojums',
                     'width':485,
                     'height':300,
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart = new google.visualization.PieChart(document.getElementById('chart_div'));
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
      google.setOnLoadCallback(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Alkoholisks dzēriens', <?php echo $g71; ?>],
        ['Bezalkoholisks dzēriens', <?php echo $g81; ?>]]);
      var options = {'title':'Dzērieni',
                     'width':470,
                     'height':300,
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
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
                     'width':470,
                     'height':300,
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
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
<br/>
<div style='margin:auto auto; width:500px;text-align:center;'>
<?php
//Tvītu kopskaits
$kopa = mysql_query("SELECT count( * ) skaits FROM tweets");
//Tvītu skaits, kuros norādīta atrašānās vieta
$geo = mysql_query("SELECT count( geo ) skaits FROM tweets where geo!=''");
//Tvītu skaits no Latvijas
$geolv = mysql_query("select count(text) skaits from tweets, vietas where vietas.nosaukums = tweets.geo and vietas.valsts = 'Latvia'");
//Tvītu skaits no ārzemēm
$geonlv = mysql_query("select count(text) skaits from tweets, vietas where vietas.nosaukums = tweets.geo and vietas.valsts != 'Latvia'");
//Dažādās atrašanās vietas
$geod = mysql_query("SELECT count( nosaukums ) skaits FROM vietas");
//Dažādās atrašanās valstis
$valst = mysql_query("SELECT count( distinct valsts ) skaits FROM vietas");
//Twitter lietotāju kopskaits
$scrnme = mysql_query("SELECT count( distinct screen_name ) skaits FROM tweets");
//Dažādie ēdieni / dzērieni
$vardi = mysql_query("SELECT count( distinct nominativs ) skaits FROM words");
//Tvītu skaits, kuros ir minēti ēdieni / dzērieni
$edsk = mysql_query("select count(distinct tvits) skaits from words");

$r=mysql_fetch_array($kopa);
$tvkopa = $r["skaits"];
echo "Kopā par ēšanas tēmām ir <b>".$tvkopa."</b> tvītu.<br/>";
$r=mysql_fetch_array($edsk);
$tvparedkopa = $r["skaits"];
echo "Kopā ir <b>".$tvparedkopa."</b> tvītu, kuros pieminēts kāds ēdiens vai dzēriens.<br/>";
$r=mysql_fetch_array($scrnme);
echo "Tos rakstījuši <b>".$r["skaits"]."</b> dažādi lietotāji.<br/>";
$r=mysql_fetch_array($geo);
$atrviet = $r["skaits"];
echo "<b>".$atrviet."</b> no tiem norādīta atrašanās vieta.<br/>";
$r=mysql_fetch_array($geolv);
$lv = $r["skaits"];
echo "<b>".$r["skaits"]."</b> no tiem ir rakstīti Latvijā.<br/>";
$r=mysql_fetch_array($geonlv);
$nlv = $r["skaits"];
echo "<b>".$r["skaits"]."</b> no tiem ir rakstīti ārzemēs.<br/>";
$r=mysql_fetch_array($geod);
$q=mysql_fetch_array($valst);
echo "Kopā ir <b>".$r["skaits"]."</b> dažādas atrašanās vietas <b>".$q["skaits"]."</b> dažādās valstīs.<br/>";
$r=mysql_fetch_array($vardi);
echo "Kopā ir pieminēti <b>".$r["skaits"]."</b> dažādi ēdieni un dzērieni.<br/>";
?>
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
				 'width':485,
				 'height':300,
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
	new google.visualization.BarChart(document.getElementById('visualization')).
		draw(data,
			 {	title:"Tvītu statistika",
				width:800, height:400,
				hAxis: {title: "Tvīti"},
				backgroundColor:'transparent'
			  }
		);
  }
  google.setOnLoadCallback(drawVisualization);
</script>
<br/>
<div style="text-align:center;">
	<div id="chart_div"></div>
    <div id="visualization"></div>
	<div style="float:left;" id="chart_div2"></div>
	<div style="float:right;" id="chart_div1"></div>
</div>
