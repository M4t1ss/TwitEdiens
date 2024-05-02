<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "/home/baumuin/public_html/twitediens.tk/includes/init_sql.php";
include('/home/baumuin/public_html/twitediens.tk/includes/functions.php');

function mysqli_field_name($result, $field_offset)
{
    $properties = mysqli_fetch_field_direct($result, $field_offset);
    return is_object($properties) ? $properties->name : null;
}

//Atslēgvārds?
if (isset($_GET['atslegvards']) && strlen($_GET['atslegvards']) > 0){
	$vards = urldecode($_GET['atslegvards']);
	$tlvards = translit($vards);
	$tl2vards = translit2($vards);

	if (isset($_GET['nevards']) && strlen($_GET['nevards']) > 0){
		$nevards = urldecode($_GET['nevards']);
		$NOTLIKE = " AND text NOT LIKE '%$nevards%' ";
	}else{
		$NOTLIKE = "";
	}


	//Vīr.dz. <=> Siev.dz.
	if(substr($vards, -1) == "s"){
		$svards = substr($vards, 0, -1)."a";
		$tlsvards = translit($svards);
		$tl2svards = translit2($svards);
		$SELECT="OR text LIKE '%$svards%'
				OR text LIKE '%$tlsvards%'
				OR text LIKE '%$tl2svards%'
				";
	}elseif(substr($vards, -1) == "a"){
		$svards = substr($vards, 0, -1)."s";
		$tlsvards = translit($svards);
		$tl2svards = translit2($svards);
		$SELECT="OR text LIKE '%$svards%'
				OR text LIKE '%$tlsvards%'
				OR text LIKE '%$tl2svards%'
				";
	}else{
		$SELECT="";
	}
	//Iz DB
	$qry = "SELECT distinct `text`, `id`, `screen_name`, `created_at`, `geo`, `emo`, `quoted_id` FROM `tweets`
				where (`text` LIKE '%$vards%'
				OR text LIKE '%$tlvards%'
				OR text LIKE '%$tl2vards%'
				".$SELECT.")".$NOTLIKE." group by tweets.text
				order by `created_at` desc";

	$export = mysqli_query ( $connection, $qry ) or die ( "Sql error : " . mysqli_error( ) );

	$fields = mysqli_num_fields ( $export );

	$header = "";
	$data = "";

	for ( $i = 0; $i < $fields; $i++ )
	{
	    $header .= mysqli_field_name( $export , $i ) . "\t";
	}

	while( $row = mysqli_fetch_row( $export ) )
	{
	    $line = '';
	    foreach( $row as $value )
	    {                                            
	        if ( ( !isset( $value ) ) || ( $value == "" ) )
	        {
	            $value = "\t";
	        }
	        else
	        {
	            $value = str_replace( '"' , '""' , $value );
	            $value = '"' . $value . '"' . "\t";
	        }
	        $line .= $value;
	    }
	    $data .= trim( $line ) . "\n";
	}
	$data = str_replace( "\r" , "" , $data );

	if ( $data == "" )
	{
	    $data = "\n(0) Records Found!\n";                        
	}

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=meklesanas-rezultati-".$vards.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	print "$header\n$data";
}
