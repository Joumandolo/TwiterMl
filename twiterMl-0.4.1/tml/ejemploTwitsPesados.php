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

$ejemploTwitsPesados = $twits->getTwitsPesados($estats->getPalabrasPesadas());
//var_dump($ejemploTwitsPesados);
//var_dump($estats->getPalabrasPesadas());

foreach($ejemploTwitsPesados as $palabra => $twits){
	echo "<p>Twits pesados con la palabra: ".$palabra;
	foreach($twits as $twit){
		echo "<br>   * ".$twit["nombreUsuario"]."(".$twit["peso"]."): ".$twit["texto"];
	}	
}
?>
