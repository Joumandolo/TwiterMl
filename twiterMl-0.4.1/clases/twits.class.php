<?php
######## twits.class.php
#
#
#
#
#
########

class twits {
	public $version = '0.3.7';
	public $listaTwits = array();
	public $numeroTwits = 0;
	public $listaPalabras = array();

	/*
	 * PHP 5 Constructor
	 * @parametros $palabras, Array() o String()
	 * @retorno void
	 */
	function __construct(){
		//puede recibir una lista de twits o un solo twit****

		//Si recibe una lista de twits lo asigna el cosntructor
		//if(!$listaTwits){
		//	$this->listaTwits = $listaTwits;
		//}
	}

	/*
	 * Convertir las palabras a un formato estandart
	 * @parametros: string $string
	 * @retorno: $string
	 */
	function limpiaCadenas($string) {
		$string = strtolower($string);
		$string = trim($string);
		$string = strip_tags($string);
		$string = preg_replace('/[^a-z ]/', '', $string);
		return $string;
	}

	/*
	 * Funcion añade un twit nuevo
	 * @parametros $twit proveniente de la consulta a la api
	 * @"retorno void
	 */
	function addTwit($twitAPI){
		//Si recivimos un twit añadimos a la lista
		$this->numeroTwits++;

		if(isset($twitAPI["metadata"]["recent_retweets"])){
			$popularidad = $twitAPI["metadata"]["recent_retweets"];
		}else{
			$popularidad = "null";
		}
		
		if($twitAPI){
			$att = array(
				"texto" => $twitAPI["text"],
				"idUsuario" => $twitAPI["from_user_id_str"],
				"nombreUsuario" => $twitAPI["from_user"],
				"tipo" => $twitAPI["metadata"]["result_type"],
				"popularidad" => $popularidad,
			);
			array_push($this->listaTwits,$att);
		}
	//return $texto;
	}

	/*
	 * Procesa la lista de twits, pesa los twits repetidos y
	 * devuelve una lista con twits unicos, para que un twit sea
	 * igual a otro su texto y su usuario deben ser iguales
	 * @parametros: void
	 * @retorno: $listaTwitsUnicos
	 */

	function getTwitsUnicos(){
		$listaTwitsUnicos = array();

		foreach($this->listaTwits as $twit){
			if (!array_key_exists('peso', $twit)) {
				$twit = array_merge($twit, array('peso' => 1));
			}
			
			foreach($listaTwitsUnicos as $key2 => $twit2){
				if($twit['texto'] == $twit2['texto']){
					$key = $key2;
					break;
				}else{ $key = false; }
			}
			//$key = $this->in_array_field_key($twit['texto'],'texto',$listaTwitsUnicos);
			if(!$key){
				//array_push($listaTwitsUnicos,$twit);
				array_push($listaTwitsUnicos,$twit);
			}else{
				$listaTwitsUnicos[$key]['peso'] = $listaTwitsUnicos[$key]['peso'] + $twit['peso'];
			}
		}
		return $listaTwitsUnicos;
	}

	/*
	 * Devuelde el contenido de $listaTwits en formato JSON
	 * @parametros: void
	 * @retorno: $listaTwitsJson
	 */ 
	function twitsJson(){
		return json_encode($this->listaTwits);
	}

	/*
	 * Devuelve una lista con ejemplos de twits para las 5 palabras 
	 * mas pesadas
	 *
	 * @parametrs $palabrasPesadas
	 * @retorno $ejemploTwitsPesados
	 */
	function getTwitsPesados($palabrasPesadas = array()){
		$ejemploTwitsPesados = array();
		$twits = array();

		foreach($palabrasPesadas as $palabra => $contenido){
			$ejemploTwitsPesados[$palabra] = array();
			//$twits = array_slice(shuffle($this->lis taTwits),0,5);
			//$twits = array_slice($this->listaTwits,0,5);
			$twits = $this->getTwitsUnicos();
			//$twits = $this->listaTwits;

			foreach($twits as $twit){
				if(in_array($palabra, explode(" ",$this->limpiaCadenas($twit["texto"])))){
					array_push($ejemploTwitsPesados[$palabra],$twit);
				}
			}
			shuffle($ejemploTwitsPesados[$palabra]);
			$ejemploTwitsPesados[$palabra] = array_slice($ejemploTwitsPesados[$palabra],0,5);
		}
		return $ejemploTwitsPesados; 
	}

/*
	function contarTwits($texto = null){
		if (is_string($texto)){
			$palabraAtt = array('palabra' => $texto);
		}else return null;

		if (!array_key_exists('peso', $palabraAtt)) {
			$palabraAtt = array_merge($palabraAtt, array('peso' => 1));
		}
		
		$word = $palabraAtt['palabra'];

		if (!empty($this->listaPalabras[$word]['peso']) && !empty($palabraAtt['peso'])) {
			$palabraAtt['peso'] = ($this->listaPalabras[$word]['peso'] + $palabraAtt['peso']);
		} elseif (!empty($this->listaPalabras[$word]['peso'])) {
			$PalabraAtt['peso'] = $this->listaPalabras[$word]['peso'];
		}
		
		$this->listaPalabras[$word] = $palabraAtt;
		return $this->listaPalabras[$word];
	}
 */
	/*
	 * Chequea si existe un valor en un array multidimencional
	 * usando un campo especifico
	 * @parametros $needle, $needle_field, $haystack
	 * @retorno $key o false, devuelve la clave de donde se encontro el $needle
	 */
/*
	function in_array_field_key($needle, $needle_field, $haystack, $strict = false){
		if($strict){ 
			foreach($haystack as $key => $item){ 
				if (isset($item->$needle_field) && $item->$needle_field === $needle) 
				return $key;
			}	
		}else{ 
			foreach ($haystack as $key => $item){
				if (isset($item->$needle_field) && $item->$needle_field == $needle) 
				return $key; 
			}
		}
		return false;
	}*/ 
}
