/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8*/

(function($) { 
$.fn.EHt = function(options){ 
	var opt = $.extend({ 
						minwidth: 0, 
					}, options );

		$(window).width()>opt.minwidth ? $(this).height(max_heigth($(this))) : $(this).css("height", "");
			
		var $this = $(this);
		$(window).on('resize', function () {
			$(window).width()>opt.minwidth ? $this.height(max_heigth($this)) : $this.css("height", "");	
		});
		
		function max_heigth(e){
			var max = 0;
			$(e).css("height", "");
			e.each(function(i, item) {
				max = Math.max( max, $(item).height() );
			});
		 return max;
		}
		
return this; 
}; 
})(jQuery); 