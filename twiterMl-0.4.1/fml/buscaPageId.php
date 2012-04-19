<?php
require_once("../fbsdk11/src/facebook.php");
require_once("../conf/facebook_keys.php");

$facebook = new Facebook($config_keys);

$q = strtolower($_GET["term"]);
if (!$q) return;

$params = array("path"=>"/search?q=".$q."&type=page&limit=5", "method"=>"GET");
$consulta = $facebook->api($params['path'],$params['method']);

$r = array();
$consulta = $consulta['data'];
foreach($consulta as $item){
	array_push($r,array("label"=>$item['name'],"value" => $item['id']));
}

header('Content-type: application/json');
echo json_encode($r);

?>
