/*

Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.7

*/
$(document).ready(function() {

//panels
$('.EC_doc').click(function () { 
    var en = this.name;
	if ($( '#' + en ).is(":visible")) {  }
    else {
    $( '#' + en ).toggle();
	$( this).css( "color", "red" );
	$('.EC_doc').not(this).css( "color", "black" );
    $(".EC_panel").not('#' + en ).hide();
	
    }
 
$("#netpage").autocomplete({ source : gpE_availablelabels });
$("#anotherpage").autocomplete({ source : gpE_availablelabels });





  
    
});



});

