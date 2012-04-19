<?php

include("../clases/estadisticas.class.php");

echo "Ejemplo Posts con mas Likes<br>";

//recibimos la listga de posts de facebookML
$feeds = $_POST["d"]; 

//Creamos el objeto estadisticas y lo llenamos con palabras
$estats = new estadisticas();
$feedsPesados = $estats->getPostPesados($feeds,'cLikes');

foreach($feedsPesados as $post){
	        echo "<br>* ".$post["actor_id"]."(likes:".$post['likes']['count'].")-> ".$post['message'];
}

?>
