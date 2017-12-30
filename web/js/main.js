jQuery(document).ready(function($) {
	
	$('.collapsible-area.closed').collapsibleArea();
	
	$('.collapsible-area.opened').collapsibleArea({
		'collapse' : 1
	});
});