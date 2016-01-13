/*Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.7*/

$(document).ready(function() {
	$("#results" ).load( " #results", function(e){
			
			$(".container .column").EHt();
			$(".container .list").EHt();
			$(".container .column2").EHt();
			
			$(".my-grid").WMGridfolio({	
			thumbnail : {	columns : ECPColumns,		},
			details : {	minHeight : ECPMinHeight,		},
			config : {     keepOpen      : false,           },
			  			 
			});
			
			$(function(){
				$("#EC_portfolio").mixitup({
				targetSelector: ".item",
				transitionSpeed: 450
					});
					});
					
			$(".EC_img").colorbox();
			
			}); 


	 $("#results").on( "click", ".pagination_cat a", function (e){
		e.preventDefault();
		$(".loading-div").show(); 
		var page = $(this).attr("data-page"); 
		$("#results").load(" #results",{"pag":page}, function(){ 
			$(".loading-div").hide(); 
				
			$(".container .column").EHt();
			$(".container .list").EHt();
			$(".container .column2").EHt();
			
			$("html, body").animate({
				scrollTop: $("#results").offset().top - 100 
					}, 500);
					
			
		});
		
	});

	
	$("#results").on( "click", ".sort li", function (e){
		e.preventDefault();
		$(".loading-div").show(); 
		var page = 1; 
		var sort = $(this).attr("data-sort"); 
		$("#results").load(" #results",{"pag":page,"sort":sort}, function(){ 
			$(".loading-div").hide(); 
				
				$(".container .column").EHt();
				$(".container .list").EHt();
				$(".container .column2").EHt();
			
					
		});
		
	});
	

	


$(".my-grid").WMGridfolio({	
			thumbnail : {	columns : ECPColumns,		},
			details : {	minHeight : ECPMinHeight,		},
			  			 
			});
		
$(function(){
  $("#EC_portfolio").mixitup({
    targetSelector: ".item",
    transitionSpeed: 450
  });
});	
	


      
$(".EC_img").colorbox();


$(window).bind('resize', function(event) {      


$(".container .column").EHt();
$(".container .list").EHt();
$(".container .column2").EHt();
$(".column h3").EHt();

});


	
});

(function($) { 
$.fn.EHt = function(){ 
		$(this).height('auto'); 
		var highestBox = 0;
	   
	   $(this).each(function(){  
					if($(this).height() > highestBox){  
					highestBox = $(this).height();  
			}
		});    
		$(this).height(highestBox);
return this; 
}; 
})(jQuery); 