(function($) {
	
	function CollapsibleArea(objects, options)
	{
		this.options = $.extend({
			// default
			collapse: 0,
		}, options);
		this.$objects = objects;
	}
	
	CollapsibleArea.prototype.init = function()
	{
		if(this.options.collapse)
			this.collapse(this.$objects);
		
		//assign handlers
		this.$objects.find('.ca-control-collapse').on('click', this.collapseClick);		
		this.$objects.find('.ca-control-expand').on('click', this.expandClick);		
	}
	
	CollapsibleArea.prototype.collapseClick = function()
	{
		CollapsibleArea.prototype.collapse($(this).closest('.collapsible-area'));
	}
	
	CollapsibleArea.prototype.collapse = function($el)
	{
		$el.animate(
			{'height': '45px'},
			200,
			'swing',
			function() {
				$el.addClass('ca-state-collapsed');
			}
		);
	}
	
	CollapsibleArea.prototype.expandClick = function()
	{
		CollapsibleArea.prototype.expand($(this).closest('.collapsible-area'));
	}
	
	CollapsibleArea.prototype.expand = function($el)
	{
		var currHeight = $el.css('height');
		$el.css('height', 'auto');
		var fullHeight = $el.css('height');
		$el.css('height', currHeight);
		
		$el.animate(
			{'height': fullHeight},
			200,
			'swing',
			function() {
				$el.removeClass('ca-state-collapsed');
			}
		);
	}
	
	$.fn.collapsibleArea = function(options) {
		var CA = new CollapsibleArea(this, options);
		CA.init();
	};
	
})(jQuery);