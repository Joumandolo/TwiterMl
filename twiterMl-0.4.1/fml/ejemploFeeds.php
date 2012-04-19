<?php

include("../clases/estadisticas.class.php");

$estats = new estadisticas();

$feed = array();
foreach($_POST["d"] as $post){
	array_push($feed,$post);
}

shuffle($feed);
$muestra = array_slice($feed,0,5);

//echo "<pre>".print_r($muestra,true)."</pre>";
//ordenar por cantidad de likes y messege*******
foreach($muestra as $post){
	echo "<br>* ".$post["actor_id"]."(likes:".$post['likes']['count'].",comments:".$post['comments']['count'].")-> ".$post['message'];
}

?>
