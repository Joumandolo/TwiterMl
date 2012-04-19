<?php
####### twiterML3.php ver:0.3.1
## Avanzando hacia Twiter Machine Learnig.
##
## Tomamos datos de un formulario de busqueda avanzada
## consultamos a Twiter con la Search API luego usamos el "text"
## o los statuses y los procesamos con varios filtros
##
##
##			By: Jou - joumandolo@gmail.com
#######
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<title>TwitML</title> 

   	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> 

	<script type="text/javascript"> 
		$(document).ready(function(){
			$('form#search').bind("submit", function(e){
				e.preventDefault();
				$('div#cargaSearch').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');

				//Recogemos los datos del formulario y creamos una estructura json
				var datosFormJson = {};
                                datosFormJson.buscaTerm = $('input[name="searchTerm"]').val();
				datosFormJson.rpp = $('select[name="searchCantidadResultados"] option:selected').val();
				datosFormJson.buscaIdioma = $('select[name="searchIdioma"] option:selected').val();
				datosFormJson.buscaUbicacion = $('select[name="searchUbicacion"] option:selected').val();
				datosFormJson.buscaFechaDesde = $('select[name="searchFechaDesde"] option:selected').val();
				datosFormJson.buscaFechaHasta = $('select[name="searchFechaHasta"] option:selected').val();
/*

				//Calcular las fechas para el query until y since
				if($('select[name="searchFechaHasta"] option:selected').val() > 0){
					var buscaFechaHasta = $('select[name="searchFechaHasta"] option:selected').val();
					var fechaHoy = new Date();
					var unDiaMil = 1000*60*60*24;
					var fechaHasta = Date(fechaHoy.getTime() - ((buscaFechaHasta - 0) * unDiaMil));
					
					var yyyy = fechaHasta.getFullYear();
					var mm = fechaHasta.getMonth() + 1;
					var dd = fechaHasta.getDate();
					fechaHasta = yyyy+'-'+mm+'-'+dd;
				}else{ var fechaHasta = ''; }
				datosFormJson.searchFechaHasta = fechaHasta;
 */
				//Hacemos la primera llamada al buscador y capturamos los resultados desde twiterAPI
				var datosTwitsJson;
				$.ajax({
					url: 'buscarTwitsJson.php',
					type: 'GET',
					dataType: 'json',
					data: datosFormJson,
					async: false,
					success: function(data, textStatus, jqXHR){
						datosTwitsJson = data;
						$('div#cargaSearch').empty();
					}
				});

				//Creamos una nube de tags con el resultado anterior
				$.ajax({
					url: 'nubePalabras.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#nube').empty();
						$('div#nube').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#nube').empty();
						$('div#nube').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});

				//Solicitamos los datos de estadisticas generales y los mostramos sobre la nube
				$.ajax({
					url: 'estadisticasGenerales.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#estatGen').empty();
						$('div#estatGen').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#estatGen').empty();
						$('div#estatGen').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});
				
				//Solicitamos ejemplos de los twits encontrados y los mostramos bajo el formulario
				$.ajax({
					url: 'ejemploTwits.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#ejemploTwits').empty();
						$('div#ejemploTwits').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#ejemploTwits').empty();
						$('div#ejemploTwits').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});
				//Solicitamos las palabras mas pesadas y los mostramos bajo las estadisticas
				$.ajax({
					url: 'palabrasPesadas.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#palabrasPesadas').empty();
						$('div#palabrasPesadas').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#palabrasPesadas').empty();
						$('div#palabrasPesadas').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});

				//Solicitamos las palabras mas pesadas y los mostramos bajo las estadisticas
				$.ajax({
					url: 'ejemploTwitsPesados.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#ejemploTwitsPesados').empty();
						$('div#ejemploTwitsPesados').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#ejemploTwitsPesados').empty();
						$('div#ejemploTwitsPesados').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});
				
				//Solicitamos los usuarios populares y los mostramos bajo la nube
				$.ajax({
					url: 'usuariosPopulares.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#usuariosPopulares').empty();
						$('div#usuariosPopulares').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#usuariosPopulares').empty();
						$('div#usuariosPopulares').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});

				//Solicitamos los twits populares segun tipo
				$.ajax({
					url: 'twitsPopulares.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosTwitsJson},
					async: true,
					success: function(data, textStatus, jqXHR){
						$('div#twitsPopulares').empty();
						$('div#twitsPopulares').append(data);
					},
					beforeSend: function (XMLHttpRequest) {
						$('div#twitsPopulares').empty();
						$('div#twitsPopulares').append('<img src="../fotos/ajax-loader.gif" alt="cargando..." />');
					}
				});
			});
		})

	</script> 
</head> 

<body> 
	<div id="main"> 
		<h2>Search Twitter</h2> 
		
		<div> 
			<form id="search" method="post" action="index.html"> 
				Palabra:
				<input type="text" name="searchTerm"/> 
				Ubicacion:
				<select name="searchUbicacion">
					<option value="chileNorte">Norte de Chile</option> 
					<option value="chileCentro">Centro de Chile</option>
					<option value="chileSur">Sur de Chile</option>
					<option value="Chile">Chile Continetal</option>
				</select>
				Idioma:
				<select name="searchIdioma"> 
					<option value="">Todos</option>
					<option value="es">Español</option>
					<option value="en">Ingles</option>
				</select>
				<br>
				Twitts desde:
				<select name="searchFechaDesde" disabled> 
					<option value="2011-10-11">5 Dias</option>
					<option value="2011-08-25">15 Dias</option>
					<option value="2011-08-15">30 Dias</option>
					<option value="2011-07-30">2 Meses</option>
					<option value="2011-06-30">3 Meses</option>
					<option value="2011-05-30">6 Meses</option>
				</select>
				Twitts hasta:
				<select name="searchFechaHasta" disabled> 
					<option value="2011-10-10">5 Dias</option>
					<option value="2011-08-24">15 Dias</option>
					<option value="2011-08-14">30 Dias</option>
					<option value="2011-07-29">2 Meses</option>
					<option value="2011-06-29">3 Meses</option>
					<option value="2011-05-29">6 Meses</option>
				</select>

				<input type="submit" name="submit" value="submit" /> 
				<div id="cargaSearch"></div>
			</form> 
		</div>

		<div id="ejemploTwits" style="float:left; position:absolute; top:120px; left:10px; border:3px solid; height:220px; width:660px"> </div> 
		<div id="twitsPopulares" style="float:left; position:absolute; top:350px; left:10px; border:3px solid; height:220px; width:660px"> </div> 
		<div id="ejemploTwitsPesados" style="float:left; position:absolute; top:580px; left:10px; border:3px solid; height:1000px; width:660px"> </div> 
		<div id="estatGen" style="float:right; position:absolute; top:40px; left:690px; border:3px solid; height:120px; width:300px"> </div> 
		<div id="palabrasPesadas" style="float:right; position:absolute; top:170px; left:690px; border:3px solid; height:130px; width:300px"> </div> 
		<div id="usuariosPopulares" style="float:right; position:absolute; top:310px; left:690px; border:3px solid; height:130px; width:300px"> </div> 
		<div id="nube" style="float:right; position:absolute; top:450px; left:690px; border:3px solid; height:300px; width:300px"> </div> 
	</div> 
</body> 
</html> 
