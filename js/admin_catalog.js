/*

Author: a2exfr
http://my-sitelab.com/
Version 1.8

*/
$(document).ready(function() {

//panels
$('.EC_doc').click(function () { 
    var en = this.name;
	if ($( '#' + en ).is(":visible")) {  }
    else {
    $( '#' + en ).toggle();
	//$( this).css( "color", "red");
	$( this).css( "cssText", "color: red !important;" );
	
	$('.EC_doc').not(this).css( "color", "black" );
    $(".EC_panel").not('#' + en ).hide();
	
    }
 
}); 
 
	 // inputs for sortable

    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input class="gpinput" type="text" name="datafilter[]"/><a href="#" class="remove_field"><img src="' + catbase + '/img/delete.png" border="0" /></a></div>'); //add input box
        }
		$(".row2").EHt();
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent("div").remove(); x--;$(".row2").EHt();
    })
 
 
 
 

 // page manager

var max_catpage = $('#max_catpage').val();
	
 $(".add_cat_page").click(function(e){ 
        e.preventDefault();
           
			max_catpage++;
		  
		  	var ms="";
			ms += '<select class="menus cat_lay gpselect hidei" name="catpages['+max_catpage+'][cat_menu]" id="catpages['+max_catpage+'][cat_menu]">';
				$.each(gpE_menus, function(i, item) {
											 
											ms += '<option value="'+i+'">'+item+'</option>'
																		 
										});
			ms +='</select>';


			var line =""; 

			 line += '<div class="input_box">';
			 line += '<input class="cp gpinput" type="text" name="catpages['+max_catpage+'][label]"/>';
				
				line +='<select class="cat_lay gpselect" name="catpages['+max_catpage+'][layout]" id="catpages['+max_catpage+'][layout]">';
				line +='<option selected="selected" value="0">List</option>';
				line +='<option value="1">3 columns</option>';
				line +='<option value="2">2 columns</option>';
				line +='<option value="3">Portfolio Gallery</option>';
				line +='<option value="4">Carousel</option>';
				line +='<option value="5">Sortable Portfolio</option>';
				line +='</select>';
			 
				line +='<input class="navi" type="checkbox" name="catpages['+max_catpage+'][navi]" value="yes"/>';
				
				line +='<select class="cat_lay gpselect beh" name="catpages['+max_catpage+'][beh]" id="catpages['+max_catpage+'][beh]">';
				line +='<option selected="selected" value="0">All, items per page=</option>';
				line +='<option value="1">First number =</option>';
				line +='<option value="2">Last number =</option>';
				line +='<option value="3">Random number =</option>';
				line +='</select>';

												
				line +='<input class="gpinput crop" type="number" step="1" min="1" name="catpages['+max_catpage+'][crop]"  />';
				
				line +='<select class="source cat_lay gpselect" name="catpages['+max_catpage+'][source]" id="catpages['+max_catpage+'][source]">';
				line +='<option selected="selected" value="0">Direct ChildPages</option>';
				line +='<option value="1">ChildPages from  another page</option>';
				line +='<option value="2">From page in another menu</option></select>';
			 
				line +=ms;
				
			 line += '<input class="cp gpinput hidei" type="text" name="catpages['+max_catpage+'][sourcepages]"  />';
			 
			 line +='<a href="#" class="remove_cat_page"><img src="' + catbase + '/img/delete.png" border="0" /></a>';
			 line +='</div>';


			 
            $(".cat_pages").append(line); 
			$(".cp").autocomplete({ source : gpE_availablelabels });
    });
   
    $(".cat_pages").on("click",".remove_cat_page", function(e){ 
        e.preventDefault(); $(this).parent("div").remove(); max_catpage--;
    })
 
 

$(".cp").autocomplete({ source : gpE_availablelabels });



 
     $(".source").change(function() {
			 if($(this).val() == 1) {
			 $(this).nextAll('input').eq(0).removeClass('hidei');
			  $(this).next('select').addClass('hidei');
			 } 
			 if($(this).val() == 2) {
			 $(this).next('select').removeClass('hidei');
			 $(this).nextAll('input').eq(0).removeClass('hidei');
			 }
			 if($(this).val() == 0) {
			 $(this).next('select').addClass('hidei');
			 $(this).nextAll('input').eq(0).addClass('hidei'); 	
			 }
	});

	
			
				$('.source').each( function() {
											 
											if($(this).val() == 1) {
			 $(this).nextAll('input').eq(0).removeClass('hidei');
			  $(this).next('select').addClass('hidei');
			 } 
			 if($(this).val() == 2) {
			 $(this).next('select').removeClass('hidei');
			 $(this).nextAll('input').eq(0).removeClass('hidei');
			 }
			 if($(this).val() == 0) {
			 $(this).next('select').addClass('hidei');
			 $(this).nextAll('input').eq(0).addClass('hidei'); 	
			 }
																		 
										});
			

$(".row1").EHt();
$(".row2").EHt();


if($('#readmore_link').val() == 0){
	$('#readmore_text').hide();
}
$('#readmore_link').change(function(){
	if($(this).val() == 1 ){
		$('#readmore_text').show();
	} else {
		$('#readmore_text').hide();
	}
})


});



 $(document).on("change",".source",function(e){
  

 if($(this).val() == 1) {
   $(this).next('select').addClass('hidei');
 $(this).nextAll('input').eq(0).removeClass('hidei');
 
 } 
 if($(this).val() == 2) {
 $(this).next('select').removeClass('hidei');
 $(this).nextAll('input').eq(0).removeClass('hidei');
 }
 if($(this).val() == 0) {
 $(this).next('select').addClass('hidei');
 $(this).nextAll('input').eq(0).addClass('hidei'); 
	 
 }
 
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
