<?php

include("../clases/estadisticas.class.php");
require_once("../fbsdk11/src/facebook.php");
include_once("../conf/facebook_keys.php");

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();

$listaUsuariosId = array();
foreach($_POST["d"] as $post){
	array_push($listaUsuariosId,$post["actor_id"]);
}

$estats->addUsuarios($listaUsuariosId);
$listaPalabrasPesadas = $estats->getPalabrasPesadas();

$facebook = new Facebook($config_keys);

foreach($listaPalabrasPesadas as $palabra){
	$fql_query = "SELECT name FROM profile WHERE id = ".$palabra['palabra'];
	$respuesta = $facebook->api( array( 'method' => 'fql.query', 'query' => $fql_query ));
	//$contenido = json_decode($respuesta, true);
	echo "<br>".$respuesta[0]['name']." -> ".$palabra["peso"];
	//echo $palabra['palabra']."<br>";
}

?>
