$(document).ready(function() {
	
	// Expand slide2
	$("#open").click(function(){
		$("div#slide2").slideDown("slow");
	
	});	
	
	// Collapse slide2
	$("#close").click(function(){
		$("div#slide2").slideUp("slow");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close slide2" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
		
});