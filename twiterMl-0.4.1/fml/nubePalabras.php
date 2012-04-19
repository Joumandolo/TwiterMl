<?php
include("../tagCloud/classes/wordcloud.class.php");
include("../clases/estadisticas.class.php");

echo '<link rel="stylesheet" href="../tagCloud/css/wordcloud.css" type="text/css">';

//Creamos un nuevo objeto twits para recibir las lista por GET
//$twits = new twits();
//$twits->listaTwits = $_POST["d"]; 

$nube = new wordCloud();
$nube->orderBy("size","desc");
$nube->setLimit("20");

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();

$feed = array();
foreach($_POST["d"] as $post){
	array_push($feed,$post["message"]);
	$message = $estats->limpiaCadenas($post["message"]);
	$palabras = explode(" ",$message);

	foreach($palabras as $palabra){
		if($estats->esPalabraLarga($palabra)){
			$nube->addWord($palabra);
		}
	}

}
/*	
foreach(s as $twit){
	$frase = $estats->limpiaCadenas($twit["texto"]);
	$palabras = explode(" ",$frase);
	foreach($palabras as $palabra){
		if($estats->esPalabraLarga($palabra)){
				$nube->addWord($palabra);
		}
	}
}
 */

echo $nube->showCloud();
	
?>
