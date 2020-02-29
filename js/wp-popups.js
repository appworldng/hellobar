(function($) {
	
	$("a:not(.wp-popups)").on("click", function(event) {
		event.preventDefault();
		$("#wp-popups").fadeIn("fast");
	});
	
	$("#wp-popups > div:first-child").click(function() {
	    $("#wp-popups").fadeOut("fast");
	});
	
})( jQuery );