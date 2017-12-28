(function($) {
	
	
	function CollapsibleArea(el)
	{
		var options;
		this.$el = $(el);	//array or objects, not a single one
	}
	
	CollapsibleArea.prototype.init = function()
	{
		if(this.$el.attr('data-collapse')==1)
		{
			this.collapse();
		}		
	}
	
	CollapsibleArea.prototype.collapse = function()
	{
		this.$el.animate(
			{'height': '10px'},
			200
		);			
	}
	
	CollapsibleArea.prototype.expand = function()
	{
		this.$el.animate(
			{'height': ''},
			200
		);
	}
	
	$.fn.collapsibleArea = function() {
		var CA = new CollapsibleArea(this);
		CA.init();
	};
	
})(jQuery);