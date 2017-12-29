(function($) {
	
	
	function CollapsibleArea(objects)
	{
		var options;
		this.$objects = $(objects);	//array or objects, not a single object
	}
	
	CollapsibleArea.prototype.init = function()
	{
		for(var i=0; i<this.$objects.length; i++)
		{
			if(this.$objects.eq(i).attr('data-collapse')==1)
			{
				this.collapse(this.$objects.eq(i));
			}
		}
	}
	
	CollapsibleArea.prototype.collapse = function($el)
	{
		$el.animate(
			{'height': '10px'},
			200
		);
	}
	
	CollapsibleArea.prototype.expand = function($el)
	{
		$el.animate(
			{'height': ''},
			200
		);
	}
	
	$.fn.collapsibleArea = function() {
		var CA = new CollapsibleArea(this);
		CA.init();
	};
	
})(jQuery);