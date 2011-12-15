<?php
header("Content-type: text/html; charset=utf-8");
include_once("ARC2.php");
$ns = array(
  'foaf' => 'http://xmlns.com/foaf/0.1/',
  'dc' => 'http://purl.org/dc/elements/1.1/'
);
$conf = array('ns' => $ns);
$ser = ARC2::getRDFXMLSerializer($conf);


$worddata['Alkohols']['nosaukums_lv'] = "Alkohols";
$worddata['Alkohols']['nosaukums_eng'] = "Alcohol";
$worddata['Alkohols']['grupa'] = "Alkoholiskie dzērieni";
$worddata['Alkohols']['vards'][] = "alkohols";
$worddata['Alkohols']['vards'][] = "alkāns";

$worddata['Apelsīns']['nosaukums_lv'] = "Apelsīns";
$worddata['Apelsīns']['nosaukums_eng'] = "Orange";
$worddata['Apelsīns']['grupa'] = "augļi, ogas";
$worddata['Apelsīns']['vards'][] = "apelsīns";
$worddata['Apelsīns']['vards'][] = "apelsinčiks";
$worddata['Apelsīns']['vards'][] = "apelsīni";
$doc = $ser->getSerializedIndex($worddata);


echo $doc;

?>