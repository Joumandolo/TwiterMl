<?php

include("../clases/twits.class.php");
include("../clases/estadisticas.class.php");

include_once("../twitteroauth2/twitteroauth/twitteroauth.php");
include_once("../conf/twiter_keys.php");

//Crear objeto que contiene las credenciales de autenticacion
$consulta = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

//Creamos un nuevo objeto twits para recibir las lista por GET
$twits = new twits();

//solo rescatamos los twits marcado como populares
foreach($_POST["d"] as $twit){
	if($twit["tipo"] == "popular"){
		$twits->listaTwits[] = $twit;
	}
}
//$muestra = $twits->listaTwits;
$muestra = $twits->getTwitsUnicos();
shuffle($muestra);
$muestra = array_slice($muestra,0,5);

if($muestra){
	foreach($muestra as $twit){
		$respuesta = $consulta->get("followers/ids.json?", array("screen_name"=>$twit["nombreUsuario"]));
		$contenido = json_decode($respuesta, true);
		echo "<br>* (".count($contenido).")".$twit["nombreUsuario"]."(".$twit["popularidad"].") -> ".$twit["texto"];
	}
}else{
	echo "<br>* No existen twits populares en la muestra";
}

?>
