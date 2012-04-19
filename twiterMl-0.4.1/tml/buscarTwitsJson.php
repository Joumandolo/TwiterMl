<?php
######## buscarTwitsJson.php ver.0.3.1
# Este scrip es la base de twiterML, recibe parametros de busqueda desde
# twiterML3.php y realiza la consulta a la API, luego retorna en formato 
# JSON el resultado de todos los twits encontrados.
#
#		by: Jou - joumandolo@gmail.com
#
########

include_once("../twitteroauth2/twitteroauth/twitteroauth.php");
include_once("../conf/twiter_keys.php");
include_once("../clases/twits.class.php");

//Crear objeto que contiene las credenciales de autenticacion
$consulta = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

//Recibir los parametros de busqueda
$paramBusqueda = array(
	"q" => $_GET["buscaTerm"],
	"rpp" => 100,
	"geocode" => $_GET["buscaUbicacion"],
	"lang" => $_GET["buscaIdioma"],
	"with_twitter_user_id" => true,
	"result_type" => "mixed",
	//"q" => "playa",//$_GET["buscaTerm"],
	//"rpp" => 100,
	//"geocode" => "chileNorte",//$_GET["buscaUbicacion"],
	//"lang" => "es",//$_GET["buscaIdioma"]
	//"place" => $_GET["buscaUbicacion"],
	//"since" => $_GET["buscaFechaHasta"],
	//"until" => $_GET["buscaFechaDesde"]
	//"since_id" => 0,
	);

//Lista de Geocodes de las regiones de chile RM->13 losRios->14 aricaParin->15 
$geocodeChile = array("-20.217,-70.314,115.93km","-23.644,-70.411,115.93km","-27.367,-70.333,200.31km","-29.908,-71.254,113.65km","-33.063,-71.639,72.24km","-34.167,-70.727,72.22km","-35.427,-71.672,98.16km","-36.773,-73.063,108.62km","-38.740,-72.590,100.68km","-41.472,-72.937,124.36km","-45.570,-72.066,185.84km","-53.163,-70.923,205.01km","-33.438,-70.650,70.02km","-39.808,-73.242,76.59km","-18.479,-70.305,73.29km");

//Definir grupos de geocodes para busquedas de mas de una region
$geocodeZonas = array(
	//"chileNorte" => array(1),
	"chileNorte" => array(1,2,3,4,15),
	"chileCentro" => array(13,5,6,7,8),
	"chileSur" => array(9,10,11,12,14),
	"Chile" => array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15)
);

$geocode = $geocodeZonas[$paramBusqueda["geocode"]];
$twits = new twits();

// Realizamos una busqueda por cada region que se solicito en los parametros de busqueda
foreach($geocode as $region){
	// Modificamos el geocode de paramBusqueda con la region
	$paramBusqueda["geocode"] = $geocodeChile[$region];
	
	//Buscar twitts
	$respuesta = $consulta->get("search.json?", $paramBusqueda);
	$contenido = json_decode($respuesta, true);

	foreach($contenido["results"] as $twit){
		$a = $twits->addTwit($twit);
	}
}

//volcar el contenido
header('Content-type: application/json');
$data = $twits->twitsJson();
echo $data;
?>
 
