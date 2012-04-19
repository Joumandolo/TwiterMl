<?php

include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

include_once("../twitteroauth2/twitteroauth/twitteroauth.php");
include_once("../conf/twiter_keys.php");

//Crear objeto que contiene las credenciales de autenticacion
$consulta = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

//Creamos un nuevo objeto twits para recibir las lista por GET
$twits = new twits();
$twits->listaTwits = $_POST["d"]; 

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();

foreach($twits->listaTwits as $twit){
	$listaUsuariosId[] = $twit['nombreUsuario'];
}

$estats->addUsuarios($listaUsuariosId);
$listaPalabrasPesadas = $estats->getPalabrasPesadas();

foreach($listaPalabrasPesadas as $palabra){
	$respuesta = $consulta->get("followers/ids.json?", array("screen_name"=>$palabra["palabra"]));
	$contenido = json_decode($respuesta, true);
	echo "<br>".$palabra["palabra"]."(".count($contenido).") -> ".$palabra["peso"];
}

?>
