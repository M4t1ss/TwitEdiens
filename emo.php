<?php
if($_POST['submit']) //ja piespiests parādīt
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
	//dabū šodienas datumu
	$menesiss = $menesis = date("m");
	$dienasz = $diena = date("d");
	$gadss = $gads = date("Y");
	//izrēķina datumu pirms mēneša
	$menesis--;
	if($menesis==0){
		$menesis=12;
		$gads--;
	}
	$no = $gads."-".$menesis."-".$diena;
	$lidz = $gadss."-".$menesiss."-".$dienasz;
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
	$( "#from, #to" ).datepicker({ minDate: -<?php echo $days; ?>, maxDate: "+0D" });
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
//kopskaits visi
$kopa = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  created_at between '$no' AND '$lidz'");
$r=mysqli_fetch_array($kopa);
$kopskaits = $r["skaits"];
//pozitīvie
$kopa = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  (`text` LIKE '%:D%' OR `text` LIKE '%:)%' OR `text` LIKE '%(:%' OR `text` LIKE '%;)%' OR `text` LIKE '%;]%' OR `text` LIKE '%:-)%' OR `text` LIKE '%:]%' OR `text` LIKE '%[:%' OR `text` LIKE '%:D%' OR `text` LIKE '%;D%' OR `text` LIKE '%xD%' OR `text` LIKE '%:^_^%' OR `text` LIKE '%:^^%' OR `text` LIKE '%:8)%' OR `text` LIKE '%:P%' OR `text` LIKE '%:*%' OR `text` LIKE '%;*%') AND tweets.created_at between '$no' AND '$lidz'");
$r=mysqli_fetch_array($kopa);
$poz = $r["skaits"];
//negatīvie
$kopa = mysqli_query($connection, "SELECT count( * ) skaits FROM tweets where (`text` LIKE '%:S%' OR `text` LIKE '%:(%' OR `text` LIKE '%):%' OR `text` LIKE '%:-(%' OR `text` LIKE '%:[%' OR `text` LIKE '%]:%' OR `text` LIKE '%;(%' OR `text` LIKE '%);%' OR `text` LIKE '%];%' OR `text` LIKE '%;[%' OR `text` LIKE '%:@%' OR `text` LIKE '%:/%' OR `text` LIKE '%:|%' OR `text` LIKE '%:?%' OR `text` LIKE '%:-_-%' OR `text` LIKE '%:O%' OR `text` LIKE '%O:%') AND tweets.created_at between '$no' AND '$lidz'");
$r=mysqli_fetch_array($kopa);
$neg = $r["skaits"];
//ar smaidiņiem
$arsm = $neg+$poz;
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:)%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s0 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%(:%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s1 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;)%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s2 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;]%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s3 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:-%)' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s4 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:]%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s5 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:D%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s6 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;D%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s7 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%xD%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s8 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:P%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s9 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:*%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s10 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;*%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s11 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%^_^%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s12 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%^^%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s13 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%8)%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s14 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:O%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s15 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%O:%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s16 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:S%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s17 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:(%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s18 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%):%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s19 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%]:%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s20 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;(%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s21 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%;[%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s22 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:@%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s23 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:/%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s24 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%:|%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s25 = $r1["skaits"];
//Smaidiņš
$g1 = mysqli_query($connection, "SELECT count(*) skaits FROM `tweets` WHERE  `text` LIKE '%-_-%' AND tweets.created_at between '$no' AND '$lidz'");
$r1=mysqli_fetch_array($g1);
$s26 = $r1["skaits"];
?>
<h2 style='margin:auto auto; text-align:center;'>Ēdāju smaidiņu statistika</h2>
<h5 style='margin:auto auto; text-align:center;'>
<form method="post" action="smaidi">
No <input value="<?php echo $nn;?>" readonly size=9 type="text" id="from" name="from"/> līdz <input value="<?php echo $ll;?>" readonly size=9 type="text" id="to" name="to"/>
<INPUT TYPE="submit" name="submit" value="Parādīt"/>
</form>
</h5>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      var chart;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart);
      $(window).resize(drawChart);
      function drawChart() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Ar smaidiņiem', <?php echo $arsm; ?>],
        ['Bez smaidiņiem', <?php echo $kopskaits - $arsm; ?>]
		]);
      var options = {'title':'Smaidiņi tvītos',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart = new google.visualization.PieChart(document.getElementById('smile1'));
      chart.draw(data, options);
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
        ['Pozitīvie', <?php echo $poz; ?>],
        ['Negatīvie', <?php echo $neg; ?>]]);
      var options = {'title':'Noskaņojums',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart1 = new google.visualization.PieChart(document.getElementById('smile2'));
      chart1.draw(data, options);
	  }
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
	var chart2;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart2);
      $(window).resize(drawChart2);
      function drawChart2() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        [':)', <?php echo $s0; ?>],
        ['(:', <?php echo $s1; ?>],
        [';)', <?php echo $s2; ?>],
        [';]', <?php echo $s3; ?>],
        [':-)', <?php echo $s4; ?>],
        [':]', <?php echo $s5; ?>],
        [':D', <?php echo $s6; ?>],
        [';D', <?php echo $s7; ?>],
        ['xD', <?php echo $s8; ?>],
        [':P', <?php echo $s9; ?>],
        [':*', <?php echo $s10; ?>],
        [';*', <?php echo $s11; ?>],
        ['^_^', <?php echo $s12; ?>],
        ['^^', <?php echo $s13; ?>],
        ['8)', <?php echo $s14; ?>]
        ]);
      var options = {'title':'Pozitīvie smaidiņi',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart2 = new google.visualization.PieChart(document.getElementById('smile3'));
      chart2.draw(data, options);
	  }
</script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
	var chart3;
      google.load('visualization', '1.0', {'packages':['corechart']});
      google.setOnLoadCallback(drawChart3);
      $(window).resize(drawChart3);
      function drawChart3() {
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        [':O', <?php echo $s15; ?>],
        ['O:', <?php echo $s16; ?>],
        [':S', <?php echo $s17; ?>],
        [':(', <?php echo $s18; ?>],
        ['):', <?php echo $s19; ?>],
        [']:', <?php echo $s20; ?>],
        [';(', <?php echo $s21; ?>],
        [';[', <?php echo $s22; ?>],
        [':@', <?php echo $s23; ?>],
        [':/', <?php echo $s24; ?>],
        [':|', <?php echo $s25; ?>],
        ['-_-', <?php echo $s26; ?>]
        ]);
      var options = {'title':'Negatīvie smaidiņi',
                     'backgroundColor':'transparent',
                     'is3D':'true'};
      chart3 = new google.visualization.PieChart(document.getElementById('smile4'));
      chart3.draw(data, options);
	  }
</script>
<br/>
	<div id="smile1"></div>
	<div id="smile2"></div>
	<br style="clear:both;"/>
	<div id="smile3"></div>
	<div id="smile4"></div>