<html>
<head>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js"></script> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script> 

<link rel="stylesheet" type="text/css" href="../jquery-ui-1.8.16.custom/css/le-frog/jquery-ui-1.8.16.custom.css" />

<script type="text/javascript">
$().ready(function(){
	$( "#tags" ).autocomplete({
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

});

</script>
</head>
<body>

<div class="ui-widget">
	<label for="tags">Tags: </label>
	<input id="tags">
</div>
</body>
</html>
