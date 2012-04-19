<?php

//include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

$estats = new estadisticas();

$feed = array();
foreach($_POST["d"] as $post){
	array_push($feed,$post["message"]);
	$estats->addFrase($post["message"]);
}

//mostramos el total de twits encontrados
echo "<br>Cantidad de post procesados: ".count($feed);
echo "<br>Cantidad de palabras procesadas: ".$estats->numeroPalabras;
echo "<br>Cantidad de palabras significativas: ".$estats->numeroPalabrasLargas;
echo "<br>Fuerza de la palabra buscada: ".$estats->getFuerza()."%";
?>
