/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8*/

$(document).ready(function() {
	
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
	
$('.filetype-Catalog_easy_section').each(function (i, value) {
 	 $(value).imagesLoaded( function() {
				$(value).find(".container .column").EHt();
				$(value).find(".container .column").EHt();
				$(value).find(".container .column2").EHt();
		});
});

$('.filetype-include').each(function (i, value) {
 	 $(value).imagesLoaded( function() {
				$(value).find(".container .column").EHt();
				$(value).find(".container .column").EHt();
				$(value).find(".container .column2").EHt();
		});
});


$(".column h3").EHt();	


$(".my-grid").each(function(){
	 var pg = $(this).attr("data-column");	
	 var tes = Number($(this).attr("data-mheight"));	
	$(this).WMGridfolio({	
				thumbnail : {	columns : pg,		},
				details : {	minHeight : tes,		},
				config : {     keepOpen      : false,          },
							 
				});

				
   })	
		
var hash = window.location.hash;
var noHash=hash.replace("#","");
	if(hash){
		mix_init_cat(noHash);
	} else {
		mix_init();   
	}
	
      
$(".EC_img").colorbox();


	
});

$(window).on('hashchange',function(){ 
		var hash = window.location.hash;
		var noHash=hash.replace("#","");
		if(hash){
			$('[data-filter="'+noHash+'"]').trigger('click');
		  }
	});


function mix_init(){
	$(function(){
			  $("#EC_portfolio").mixitup({
				targetSelector: ".item",
				transitionSpeed: 450
			  });
			});	 
}
//start with category
function mix_init_cat(noHash){
 if ($('.'+noHash).length <=0 )	   {mix_init();return;} 
		$(function(){
			  $("#EC_portfolio").mixitup({
				targetSelector: ".item",
				transitionSpeed: 450,
				showOnLoad: ''+noHash+'',
			  });
			});
}
