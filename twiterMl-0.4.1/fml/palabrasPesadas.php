<?php

//include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

$estats = new estadisticas();

$feed = array();
foreach($_POST["d"] as $post){
	array_push($feed,$post["message"]);
	$estats->addFrase($post["message"]);
}

$listaPalabrasPesadas = $estats->getPalabrasPesadas();

foreach($listaPalabrasPesadas as $palabra){
	echo "<br>".$palabra["palabra"]." -> ".$palabra["peso"];
	}
?>
