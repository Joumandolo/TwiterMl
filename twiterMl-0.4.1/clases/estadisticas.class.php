<?php
######## stadisticas.class.php
#
#
#
#
#
########

class estadisticas {
	public $version = '0.1.0';
	public $twits = array();
	public $listaPalabras = array();
	public $numeroPalabras = 0;
	public $numeroPalabrasLargas = 0;

	/*
	 * PHP 5 Constructor
	 * @parametros $palabras, Array() o String()
	 * @retorno void
	 */
	function __construct(){
		//Si recibe una lista de twits lo asigna el cosntructor
		//if(!$listaTwits){
		//	$this->twits = $listaTwits;
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
	 *
	 *
	 *
	 */
	function addPalabra($palabra = array()) {
		$this->numeroPalabras++;
		if (is_string($palabra) AND $this->esPalabraLarga($palabra)) {
			//$palabra = $this->limpiaCadenas($palabra);
			$palabraAtt = array('palabra' => $palabra);
			$this->numeroPalabrasLargas++;
		}else return null;
		
		if (!array_key_exists('peso', $palabraAtt)) {
			$palabraAtt = array_merge($palabraAtt, array('peso' => 1));
		}
		
		if (!array_key_exists('palabra', $palabraAtt)) {
			//return $this->notify('no word attribute', print_r($wordAttributes, true));
			//break;
		}
		
		$word = $palabraAtt['palabra'];
		
		if (empty($this->listaPalabras[$word])) {
			$this->listaPalabras[$word] = array();
		}
		
		if (!empty($this->listaPalabras[$word]['peso']) && !empty($palabraAtt['peso'])) {
			$palabraAtt['peso'] = ($this->listaPalabras[$word]['peso'] + $palabraAtt['peso']);
		} elseif (!empty($this->listaPalabras[$word]['peso'])) {
			$PalabraAtt['peso'] = $this->listaPalabras[$word]['peso'];
		}
		
		$this->listaPalabras[$word] = $palabraAtt;
		return $this->listaPalabras[$word];
	}

	/*
	 *
	 *
	 *
	 */
	function addPalabras($palabras = array()) {
		if (!is_array($palabras)) {
			$palabras = func_get_args();
		}
		foreach ($palabras as $palabraAtt) {
			$palabraAtt = $this->limpiaCadenas($palabraAtt);
			$this->addPalabra($palabraAtt);
		}
	}

	/*
	 *
	 *
	 *
	 *
	 */
	function addFrase($frase, $separador = ' ') {
		$inputArray = explode($separador, $frase);
		$wordArray = array();
		foreach ($inputArray as $inputWord) {
			$wordArray[]=$this->limpiaCadenas($inputWord);
		}
		$this->addPalabras($wordArray);
	}

	/*
	 *
	 *
	 *
	 */
	function addUsuarios($usuarios = array()) {
		if (!is_array($usuarios)) {
			$usuarios = func_get_args();
		}
		foreach ($usuarios as $usuarioId) {
			//$palabraAtt = $this->limpiaCadenas($palabraAtt);
			$this->addPalabra($usuarioId);
		}
	}

	/*
	 * Obtine a paratir de la listaPalabrsa una lista con palabras largas,
	 * elimina de la lista original las palabras con menos de 3 caracteres,
	 * quita los articulos, algunas prepociciones, ...
	 *  
	 * @parametros $listaPalabras
	 * @retorno $listaPalabrasLargas
	 */
	function getPalabrasLargas(){
		$listaPalabrasLargas = array();

		foreach($this->listaPalabras as $palabra => $cont){
			array_push($listaPalabrasLargas,$palabra);		
		}
		return $listaPalabrasLargas;
	}

	/*
	 * Verifica si la palabra entregada por argumento es una palabra
	 * larga
	 *  
	 * @parametros $palabra
	 * @retorno $palabraLarga
	 */
	function esPalabraLarga($palabra = array()){
		$palabraLarga = array();
		$listaArticulos = array('el','los','un','unos','la','las','una','unas','al','del');
		$listaPreposiciones = array('para', 'por', 'segun', 'sin', 'sobre', 'tras');
		$listaPalabrasOdiosas = array('que', 'con');
		
		//$palabraLarga[] = $palabra;
		//$palabraLarga = array_diff($palabra,$listaArticulos);
		//$palabraLarga = array_diff($palabraLarga,$listaPreposiciones);
		
		//if(strlen($palabra[0]) > 2) return 1; else return 0;
		if(in_array($palabra,$listaArticulos)) return 0;
		if(in_array($palabra,$listaPreposiciones)) return 0;
		if(in_array($palabra,$listaPalabrasOdiosas)) return 0;
		
		if(strlen($palabra) > 2) return 1; else return 0;
	}

	/*
	 * Ordenar la lista de palabras segun el campo especificado
	 *
	 * @argumentos $listaPalabras
	 * @retorno $listaPalabrasOrdenadas
	 */
	function ordenaListaPalabras($unsortedArray, $sortField, $sortWay = 'SORT_ASC') {
		$sortedArray = array();
		foreach ($unsortedArray as $uniqid => $row) {
			foreach ($row as $key => $value) {
				$sortedArray[$key][$uniqid] = strtolower($value);
			}	                        
		}
		if($sortWay){
			array_multisort($sortedArray[$sortField], constant($sortWay), $unsortedArray);
		}
		return $unsortedArray;
	}

	/*
	 * Obtener una lista con las 5 palabras mas pesadas
	 * 
	 * @parametros void
	 * @retorno listaPalabras Pesadas
	 */
	function getPalabrasPesadas(){
		$listaPalabrasOrdenadas = array();
		$palabrasPesadas = array();

		//ordenar la lista de palabras segun peso Desendente
		$listaPalabrasOrdenadas = $this->ordenaListaPalabras($this->listaPalabras, 'peso', 'SORT_DESC');
		//$listaPalabrasOrdenadas = $this->ordenaListaPalabras($this->getPalabrasLargas(), 'peso', 'SORT_DESC');
		$palabrasPesadas = array_slice($listaPalabrasOrdenadas,1,5);

		return $palabrasPesadas;
	}
	
	/*
	 * Obtener una lista con los 5 post mas pesados segun parametro de orden
	 * 
	 * @parametros $listaPost $campoOrden
	 * @retorno $listaPostPesados
	 */
	function getPostPesados($listaPost=array(),$campoOrden='likes'){
		$listaPostPesados = array();
		$listaPostOrdenados = array();

		//ordenar la lista de post segun campo desendente
		$listaPostOrdenados = $this->ordenaListaPalabras($listaPost, $campoOrden, 'SORT_DESC');
		$listaPostPesados = array_slice($listaPostOrdenados,0,5);

		return $listaPostPesados;
	}
	
	/*
	 * Calcular la fuerza de la palabra buscada, este indice se calcula
	 * sacando el procentaje del peso de la palbra buscada reespecto del 
	 * total de palabras
	 *
	 * @parametros
	 * @retorno
	 */
	function getFuerza(){
		$fuerza;

		$listaPalabras = $this->ordenaListaPalabras($this->listaPalabras, 'peso', 'SORT_DESC');
		$palabra = current($listaPalabras);

		$fuerza = $palabra["peso"]*100/$this->numeroPalabrasLargas;
		//$fuerza = $palabra["size"]*100/$this->numeroPalabras;
		//$fuerza = round(20*100/$this->numeroPalabras,2);
		return round($fuerza,2);
	}
}
