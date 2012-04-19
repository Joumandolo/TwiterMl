<?php

include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

//Creamos un nuevo objeto twits para recibir las lista por GET
$twits = new twits();
$twits->listaTwits = $_POST["d"]; 

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();
foreach($twits->listaTwits as $twit){
        $estats->addFrase($twit["texto"]);
}

$listaPalabrasPesadas = $estats->getPalabrasPesadas();

foreach($listaPalabrasPesadas as $palabra){
	echo "<br>".$palabra["palabra"]." -> ".$palabra["peso"];
	}
?>
