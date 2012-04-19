<?php

include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

//Creamos un nuevo objeto twits para recibir las lista por GET
$twits = new twits();
$twits->listaTwits = $_POST["d"]; 

$aleatorio = $twits->getTwitsUnicos();
shuffle($aleatorio);
//$aleatorio = $twits->listaTwits;
//$muestra = $aleatorio;
$muestra = array_slice($aleatorio,0,5);

//echo "<pre>".print_r($muestra,true)."</pre>";

foreach($muestra as $twit){
	echo "<br>* ".$twit["nombreUsuario"]."(".$twit['peso']."): ".$twit["texto"];
}
//echo count($aleatorio);
//echo "hola";
?>
