<?php
require_once("../fbsdk11/src/facebook.php");
require_once("../conf/facebook_keys.php");

//Recibimos los parametros desde facebookML
$a = time();
$b = time() - 3600*24;
$paramBusqueda = array(
	"pagina" => $_GET["buscaTerm"],
	//"pagina" => 'http://www.facebook.com/cocacola',
	//"fechaDesde" => $a,
	"fechaDesde" => $_GET["fechaDesde"],
	//"fechaHasta" => $b,
	"fechaHasta" => $_GET["fechaHasta"],
	//"geocode" => $_GET["buscaUbicacion"],
	//"lang" => $_GET["buscaIdioma"],
);

$facebook = new Facebook($config_keys);

/*
//get user access_token
$my_url = 'POST_AUTH_URL';
$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
	. $config_keys['appId'] . '&redirect_uri='
	. urlencode($my_url)
	. '&client_secret='
	. $config_keys['secret'];
        //. '&code=' . $code;
$access_token = file_get_contents($token_url);
 */

// Run fql query
$fql_query = "SELECT post_id, actor_id, message, comments, likes FROM stream WHERE"
	." source_id = ".$paramBusqueda['pagina']
	." AND created_time < ".$paramBusqueda['fechaDesde']
	." AND created_time > ".$paramBusqueda['fechaHasta']
	." LIMIT 500";

//$fql_query_url = 'https://graph.facebook.com/'
//	. '/fql?' . urlencode($fql_query)
//	. '&' . $access_token;

$ret = $facebook->api( array(
	'method' => 'fql.query',
	'query' => $fql_query,
));

//$fql_query_result = file_get_contents($fql_query_url);
//$fql_query_obj = json_decode($fql_query_result, true);

//alterar campos likes y comments, cambiamos el array por el campo count
foreach($ret as $key => $post){
	$nuevoAtt = array('cLikes' => $post['likes']['count'], 'cComments' => $post['comments']['count']);
	$ret[$key] = array_merge($ret[$key],$nuevoAtt);
}

$fql_query_obj = json_encode($ret);
//var_dump($ret);

//volcar el contenido
header('Content-type: application/json');
echo $fql_query_obj;
//echo "<pre>".print_r($ret,true)."</pre>";
//echo $ret;

?>
