<?php

include("../clases/estadisticas.class.php");

echo "Ejemplo Posts con mas Comments<br>";

//recibimos la listga de posts de facebookML
$feeds = $_POST["d"]; 

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();
$feedsPesados = $estats->getPostPesados($feeds,'cComments');

foreach($feedsPesados as $post){
	        echo "<br>* ".$post["actor_id"]."[".$post['post_id']."]"."(comments:".$post['comments']['count'].")-> ".$post['message'];
}

?>
