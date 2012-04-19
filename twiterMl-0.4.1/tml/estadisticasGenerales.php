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

$twits->numeroTwits = count($twits->listaTwits);//arreglo temporal
//mostramos el total de twits encontrados
//echo "<br>Cantidad de Twits procesados: ".$twits->x;
echo "<br>Cantidad de Twits procesados: ".$twits->numeroTwits;
echo "<br>Cantidad de palabras procesadas: ".$estats->numeroPalabras;
echo "<br>Cantidad de palabras significativas: ".$estats->numeroPalabrasLargas;
echo "<br>Fuerza de la palabra buscada: ".$estats->getFuerza()."%";
?>
