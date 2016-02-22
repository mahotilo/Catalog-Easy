/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8*/

$(document).ready(function() {



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
	

	

$(".container .column").EHt();
$(".container .list").EHt();
$(".container .column2").EHt();

		
$(".my-grid").each(function(){
	 var pg = $(this).attr("data-column");	
	 var tes = Number($(this).attr("data-mheight"));	
	$(this).WMGridfolio({	
				thumbnail : {	columns : pg,		},
				details : {	minHeight : tes,		},
				config : {     keepOpen      : false,          },
							 
				});

				
   })		

$(function(){
  $(".EC_portfolio").mixitup({
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


	
});//dom ready end

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