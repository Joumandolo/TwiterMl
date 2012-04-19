<?php
require_once("../fbsdk11/src/facebook.php");
require_once("../conf/facebook_keys.php");
//require_once("../clases/estadisticas.class.php");

$facebook = new Facebook($config_keys);
//$estats = new estadisticas();

// Get the current access token
//$access_token = $facebook->getAccessToken();

//Recibimos los parametros desde facebookML
$paramBusqueda = array(
	"pagina" => $_GET["buscaTerm"],
	//"rpp" => 100,
	//"geocode" => $_GET["buscaUbicacion"],
	//"lang" => $_GET["buscaIdioma"],
	//"with_twitter_user_id" => true,
	//"result_type" => "mixed",
);                               
                                                      
$params = array(
	"path" => "cocacola/feed",
	//"path" => $paramBusqueda['pagina']."/feed",
	"method" => "GET",
	//"params" => array("acces_token" => "$access_token"),
	);

//$consulta = $facebook->api("cocacola/feed");
$consulta = $facebook->api($params['path'],$params['method']);
/*
if($consulta){
	try{
		echo "<pre>".print_r($consulta,true)."</pre>";
	}catch(FacebookApiException $e){
		error_log($e->getType());
		error_log($e->getMessage());
	}
}else{
	echo "La consulta no devolvio datos";
}
 */

//volcar el contenido
header('Content-type: application/json');
$data = json_encode($consulta);
echo $data;
//echo $consulta[0];

?>
