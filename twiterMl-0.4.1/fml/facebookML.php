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
	<title>FacebookML</title> 

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js"></script> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script> 

<link rel="stylesheet" type="text/css" href="../jquery-ui-1.8.16.custom/css/le-frog/jquery-ui-1.8.16.custom.css" />

	<script type="text/javascript"> 
		$(document).ready(function(){
			$('#bucaPagina').autocomplete({
				selectFirst: false,
				source: function(request, response) {
					$.ajax({
						url: "buscaPageId.php",
						data: request,
						dataType: "json",
						type: "GET",
						success: function(data){
							response(data);
						}
					});
				},
			});

			$('form#search').bind("submit", function(e){
				e.preventDefault();
				$('#nube').html('');

				//Recogemos los datos del formulario y creamos una estructura json
				var datosFormJson = {};
                                datosFormJson.buscaTerm = $('input[name="searchTerm"]').val();
				datosFormJson.rpp = $('select[name="searchCantidadResultados"] option:selected').val();
				datosFormJson.buscaIdioma = $('select[name="searchIdioma"] option:selected').val();
				datosFormJson.buscaUbicacion = $('select[name="searchUbicacion"] option:selected').val();
				//datosFormJson.buscaFechaDesde = $('select[name="searchFechaDesde"] option:selected').val();
				//datosFormJson.buscaFechaHasta = $('select[name="searchFechaHasta"] option:selected').val();


				//Calcular las fechas para el query until y since
				var buscaFechaDesde = $('select[name="searchFechaDesde"] option:selected').val();
				var buscaFechaHasta = $('select[name="searchFechaHasta"] option:selected').val();
				var fechaHoy = new Date();
				var unDia = 60*60*24;
				var fechaDesde = Math.ceil(fechaHoy.getTime()/1000) - (buscaFechaDesde * unDia);
				var fechaHasta = fechaDesde - (buscaFechaHasta * unDia) - unDia;
				
				datosFormJson.fechaDesde = fechaDesde;
				datosFormJson.fechaHasta = fechaHasta;

				//Hacemos la primera llamada al buscador y capturamos los resultados desde twiterAPI
				var datosFeedJson;
				$.ajax({
					url: 'buscarFeedFql.php',
					type: 'GET',
					dataType: 'json',
					data: datosFormJson,
					async: false,
					success: function(data, textStatus, jqXHR){
						datosFeedJson = data;
					}
				});

				//Creamos una nube de tags con el resultado anterior
				$.ajax({
					url: 'nubePalabras.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosFeedJson},
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
					data: {"d":datosFeedJson},
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
					url: 'ejemploFeeds.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosFeedJson},
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
					data: {"d":datosFeedJson},
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
					url: 'ejemploLikesPesados.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosFeedJson},
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
					data: {"d":datosFeedJson},
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
					url: 'ejemploCommentsPesados.php',
					type:'POST',
					dataType: 'html',
					data: {"d":datosFeedJson},
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
		<h2></h2> 
		
		<div> 
			<form id="search" method="post" action="index.html"> 
				<div class="ui-widget">
					<label for="tags">Pagina a analizar:</label>
					<input id="bucaPagina" type="text" name="searchTerm"/>
				</div> 
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
				<select name="searchFechaDesde"> 
					<option value="0">hoy</option>
					<option value="5"> 5 dias atras</option>
					<option value="15">15 dias atras</option>
					<option value="30">30 dias atras</option>
					<option value="60">60 dias atras</option>
					<option value="120">120 dias atras</option>
				</select>
				Twitts hasta:
				<select name="searchFechaHasta"> 
					<option value="0">hoy</option>
					<option value="5">5 dias atras</option>
					<option value="15">15 dias atras</option>
					<option value="30">30 dias atras</option>
					<option value="60">60 dias atras</option>
					<option value="120">120 dias atras</option>
				</select>

				<input type="submit" name="submit" value="submit" /> 
			</form> 
		</div>

		<div id="ejemploTwits" style="float:left; position:absolute; top:110px; left:10px; border:3px solid; height:250px; width:660px"> </div> 
		<div id="twitsPopulares" style="float:left; position:absolute; top:370px; left:10px; border:3px solid; height:260px; width:660px"> </div> 
		<div id="ejemploTwitsPesados" style="float:left; position:absolute; top:640px; left:10px; border:3px solid; height:1000px; width:660px"> </div> 
		<div id="estatGen" style="float:right; position:absolute; top:40px; left:690px; border:3px solid; height:120px; width:300px"> </div> 
		<div id="palabrasPesadas" style="float:right; position:absolute; top:170px; left:690px; border:3px solid; height:130px; width:300px"> </div> 
		<div id="usuariosPopulares" style="float:right; position:absolute; top:310px; left:690px; border:3px solid; height:130px; width:300px"> </div> 
		<div id="nube" style="float:right; position:absolute; top:450px; left:690px; border:3px solid; height:300px; width:300px"> </div> 
	</div> 
</body> 
</html> 
