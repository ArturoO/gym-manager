(function($) {
	
	function CollapsibleArea(objects, options)
	{
		var self = this;
		this.defaults = {
			collapse: 0,
		};
		this.options = $.extend(true, {}, this.defaults, options); //deep copy
		this.$objects = objects;
		
		function collapseClick()
		{
			self.collapse($(this).closest('.collapsible-area'));
		}
		
		function expandClick()
		{
			self.expand($(this).closest('.collapsible-area'));
		}
		
		//assign handlers
		this.$objects.find('.ca-control-collapse').on('click', collapseClick);
		this.$objects.find('.ca-control-expand').on('click', expandClick);
		
	}
	
	CollapsibleArea.prototype.init = function()
	{
		if(this.options.collapse)
			this.collapse(this.$objects);
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
		return this;
	};
	
})(jQuery);