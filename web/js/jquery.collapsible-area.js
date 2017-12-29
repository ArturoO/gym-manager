(function($) {
	
	function CollapsibleArea(objects)
	{
//		this.$objects = $(objects);
		this.$objects = objects;
	}
	
	CollapsibleArea.prototype.init = function()
	{
		for(var i=0; i<this.$objects.length; i++)
		{
			if(this.$objects.eq(i).attr('data-collapse')==1)
			{
				this.collapse(this.$objects.eq(i));
//				this.$objects.eq(i).css('height', '45px').addClass('ca-state-collapsed');
			}
		}
		
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
	
	$.fn.collapsibleArea = function() {
		var CA = new CollapsibleArea(this);
		CA.init();
	};
	
})(jQuery);