<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="../jquery/jquery-autocomplete/jquery.autocomplete.js"></script>     

<script>
	$(function() {
				var availableTags = [
								"ActionScript",
											"AppleScript",
														"Asp",
																	"BASIC",
																				"C",
																							"C++",
																										"Clojure",
																													"COBOL",
																																"ColdFusion",
																																			"Erlang",
																																						"Fortran",
																																									"Groovy",
																																												"Haskell",
																																															"Java",
																																																		"JavaScript",
																																																					"Lisp",
																																																								"Perl",
																																																											"PHP",
																																																														"Python",
																																																																	"Ruby",
																																																																				"Scala",
																																																																							"Scheme"
																																																																									];
						$( "#tags" ).autocomplete({
										source: availableTags
													});
					});
		</script>


	
<div class="demo">

<div class="ui-widget">
	<label for="tags">Tags: </label>
	<input id="tags">
</div>

</div><!-- End demo -->



<div class="demo-description" style="display: none; ">
<p>The Autocomplete widgets provides suggestions while you type into the field. Here the suggestions are tags for programming languages, give "ja" (for Java or JavaScript) a try.</p>
<p>The datasource is a simple JavaScript array, provided to the widget using the source-option.</p>
</div><!-- End demo-description -->
