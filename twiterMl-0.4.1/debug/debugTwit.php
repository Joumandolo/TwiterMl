<?php
######## debugTwit.php
## Estes escript forma parte del sistema TwiterML
## 
##
##			By: Jou - joumandolo@gmail.com
########

include_once("../twitteroauth2/twitteroauth/twitteroauth.php");
include("../tagCloud/classes/wordcloud.class.php");

echo '<link rel="stylesheet" href="../tagCloud/css/wordcloud.css" type="text/css">';
 
$consumerKey    = 'FrdXQ67TWkCYrre59y2NA';
$consumerSecret = 'P5rLruQhM96ZgSgAa3WZBahfilFEDYhgXDuhlUcR2lI';
$oAuthToken     = '76760096-zCQXaqkK1RFQibNaimCNRqGa8RcJUcOpctWfOeLW0';
$oAuthSecret    = 'TFgsHSYwfpFVCWrrVq8fQbLiSumu0rie4GT9xTU97w';

//Crear objeto que contiene las credenciales de autenticacion
$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

//Recibir datos por get desde la funcion externa que invoca en formato Json
$query = array(
	"q" => "educacion",
	//"until" => "2011-10-20",
	//"max_id" => "1.50E+16",
	"since" => "2011-1-2",
	"page" => 1,
	"rpp" => 10,
	"result_type" => "popular",
	//"since_id" => 12,
	//"max_id_str" => "100000",
	);

//Buscar twitts
$respuesta = $tweet->get("search.json?", $query);
$contenido = json_decode($respuesta, true);

// Agregamos las palabras a la Nube y generamos un arreglo con las palbras originales
//var_dump($contenido);
//array_pop("results",$contenido);
foreach($contenido as $key => $twit){
	if($key != "results"){
		echo "<br>".$key." -> ".$twit;
	}else{
		echo "<br>".$key." -> ".$twit;
		foreach($twit as $key2 => $res){
			echo "<br>--".$key2." -> ";
			foreach($res as $key3 => $res2){
				if($key3 != "metadata"){
					//if($key3 == "created_at"){
					echo "<br>----".$key3." -> ".$res2;
					//}
				}else{
					echo "<br>----".$key3." -> ".$res2;
					foreach($res2 as $key4 => $res3){
						echo "<br>------".$key4." -> ".$res3;
					}
				}

			}
		}
	}
	       	//echo "<br>".$key." -> ".count($twit);
}

?>
 
