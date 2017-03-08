/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8*/
function gp_init_inline_edit(area_id, section_object) {

    loaded();
    gp_editing.editor_tools();
    var edit_div = gp_editing.get_edit_area(area_id);
    var cache_value = '';

    gp_editor = {
            save_path: gp_editing.get_path(area_id),

            destroy: function() {},

            checkDirty: function() {

                var curr_val = gp_editor.gp_saveData();
                if (curr_val != cache_value) {

                    return true;
                }
                return false;

            },


            resetDirty: function() {
                cache_value = gp_editor.gp_saveData();
            },

            gp_saveData: function() {

				
				var datafilter = new Array();
								
				$.each($("input[name='datafilter[]']:checked"), function() {
				  datafilter.push($(this).val());
				  
				});
												
				var options_my = $('#gp_my_options').find('input,select').serialize();
			 	
				return '&'+options_my+'&datafilter=' + datafilter	;

            },
            intervalSpeed: function() {},
			updateElement : function() {},


            updatesect: function() {}
        } // gpeditor --end


gp_editor.updatesect = function() {
	var href = jPrep(window.location.href) + '&cmd=refresh_section' + '&my_value=' + gp_editor.gp_saveData() + '&EC_id=' + section_object.EC_id;
	$.getJSON(href, ajaxResponse);
 }



$gp.response.refresh_replayFn = function(arg) {
        var div_data = arg.CONTENT;
        edit_div.html(div_data);

        //use js on loaded content
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

        $(function() {
            $("#EC_portfolio").mixitup({
                targetSelector: ".item",
                transitionSpeed: 450
            });
        });

        $(".EC_img").colorbox();
    
	
		 if (gpE_added_js !=""){	
			$.each(gpE_added_js, function(index, value) {
				$.getScript(value, function(){
						
				});
			 
			});
	
		}
	
}//refresh_replayFn


    var option_area = $('<div id="gp_my_options"/>').prependTo('#ckeditor_controls');

    var ms = "";
    ms += '<select class="cat_menu gpselect" name="cat_menu">';
    $.each(gpE_menus, function(i, item) {

        ms += '<option value="' + i + '">' + item + '</option>'

    });
    ms += '</select>';
	
	var dataf=""; 
	$.each(gpE_datafilter, function(i, item) {

        dataf += ' <input type="checkbox" name="datafilter[]" value=' + item + '>' + item + '<br />'; 

    });
	
	var addlay=""; 
	$.each(gpE_added_layouts, function(i, item) {

        addlay +='<option value="' + i + '">' + item + '</option>';

    });

	if(section_object.templates){
		$.each(section_object.templates, function(i, item) {

			addlay +='<option value="' + item + '">' + item + '</option>';

		});
	}
		
    var option_messages = $(
            '<div id="option_message">' +
           
			'<div class="a_box">'+
		   ' <div id="catalog_layout" class="catalog_select"><p><i class="fa fa-list"></i> Catalog layout<select class="catalog_layout gpselect" name="catalog_layout">' +
		   '<option value="0">List</option>' +
            '<option value="1">3 columns</option>' +
            '<option value="2">2 columns</option>' +
            '<option value="3">Portfolio Gallery</option>' +
            '<option value="4">Carousel</option>' +
            '<option value="5">Sortable Portfolio</option>' +
			addlay +
            '</select></p></div>' +
            '<div id="lay_opt4" class="lay_opt hidei">' +
            '<div id="ShowTitlecar"><p>Show title?<select class="gpselect" name="ShowTitlecar">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="ECrow"><p>Number of items in row<input type="text" name="ECrow" class="a_inp"  /></p></div>' +
            '<div id="ECheight"><p>Height of carousel (px)<input type="text" name="ECheight" class="a_inp"  /></p></div>' +
            '</div>' + 
			'<div id="lay_opt3" class="lay_opt hidei">' +
            '<div id="ECPColumns"><p>Number of columns<input type="text" name="ECPColumns" class="a_inp"  /></p></div>' +
            '<div id="ECPMinHeight"><p>Height of expandable info(px)<input type="text" name="ECPMinHeight" class="a_inp"  /></p></div>' +
            '</div>' +
			'<div id="lay_opt5" class="lay_opt hidei">' +
             dataf +
			'<div id="Showtitle"><p>Show title?<select class="gpselect" name="Showtitle">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
			'</select></p></div>' +
			'<div id="ItemW"><p>Width of portfoliio item (%)<input type="text" name="ItemW" class="a_inp"  /></p></div>' +
			'<div id="imagelinked"><p>Image is linked to:<select class="gpselect" name="imagelinked">' +
            '<option value="0">Page</option>' +
            '<option value="1">Colorbox</option>' +
            '</select></p></div>' +
			
			'</div>' +
						
			gpE_add_opts+
						
			'</div>'+
							
			
			'<div class="a_box">'+
			' <div id="source"><p><i class="fa fa-link"></i> Source<select class="source gpselect" name="source" style="width: 175px;">' +
            '<option value="0">Direct ChildPages</option>' +
            '<option value="1">ChildPages from another page</option>' +
            '<option value="2">From page in another menu</option>' +
            '</select></p></div>' +
            '<div id="cat_menu" class="hidei"><p> Another menu' + ms + '</p></div>' +
            '<div id="sourcepages"><p>Source page<input type="text" name="sourcepages" class="a_inp"  /></p></div>' +
            '</div>'+
			
			
			'<div class="a_box">'+
			'<div id="beh"><p><i class="fa fa-random"></i> How to take<select class="beh gpselect" name="beh">' +
            '<option value="0">All, items per page=</option>' +
            '<option value="1">First number =</option>' +
            '<option value="2">Last number =</option>' +
            '<option value="3">Random number =</option>' +
            '</select></p></div>' +
            '<div id="crop"><p>Number to take <input type="text" name="crop" class="a_inp"  /></p></div>' +
			'</div>'+

			
			'<div class="a_box">'+
			'<a id="image_opts" class="gpbutton" style="width:100%;" href="javascript:void(0)"><i class="fa fa-picture-o"></i> Image Options</a>'+
			'<div class="image_opts_container">'+
			'<div id="showimage"><p>Show image?<select class="gpselect" name="showimage">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="width"><p>Image width(px)<input type="text" name="width" class="a_inp"  /></p></div>' +
            '<div id="height"><p>Image height(px)<input type="text" name="height" class="a_inp"  /></p></div>' +
            '<div id="EC_thumb"><p>Use EasyCatalog generated thumbnails?<select class="EC_thumb gpselect" name="EC_thumb">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="img_text"><p>Take image only from text sections?<select class="img_text gpselect" name="img_text">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
			'</div>'+
			
		   '</div>'+
			
			'<div class="a_box">'+
			'<div id="shortinfo"><p><i class="fa fa-align-left"></i> Short info:<select class="gpselect" name="shortinfo" style="width: 175px;">' +
            '<option value="0">From section with short_info class</option>' +
            '<option value="1">From content</option>' +
            '<option value="2">No short info</option>' +
            '</select></p></div>' +
            '<div id="abr" class="hidei"><p>Abbreviation Length=<input type="text" name="abr" class="a_inp"  /></p></div>' +
            '</div>'+
			
		   '</div>'
        ).appendTo(option_area)
        .find('#catalog_layout select')
        .val(section_object.catalog_layout);

    $('#gp_my_options').find('#sourcepages input').autocomplete({
        source: gpE_availablelabels,
        open: function() {
            $(this).autocomplete('widget').zIndex(120000);

        },
          appendTo: '#gp_admin_html',
		  select: function(event, ui) {
            gp_editor.updatesect();
        }
    });


    $('#gp_my_options').find('#source select').val(section_object.source);
    $('#gp_my_options').find('#cat_menu select').val(section_object.cat_menu);
    $('#gp_my_options').find('#sourcepages input').val(section_object.sourcepages);
    $('#gp_my_options').find('#beh select').val(section_object.beh);
    $('#gp_my_options').find('#crop input').val(section_object.crop);
    $('#gp_my_options').find('#width input').val(section_object.width);
    $('#gp_my_options').find('#height input').val(section_object.height);
    $('#gp_my_options').find('#EC_thumb select').val(section_object.EC_thumb);
    $('#gp_my_options').find('#showimage select').val(section_object.showimage);
    $('#gp_my_options').find('#shortinfo select').val(section_object.shortinfo);
    $('#gp_my_options').find('#abr input').val(section_object.abr);
    $('#gp_my_options').find('#ECrow input').val(section_object.ECrow);
    $('#gp_my_options').find('#ECheight input').val(section_object.ECheight);
    $('#gp_my_options').find('#ShowTitlecar select').val(section_object.ShowTitlecar);
    $('#gp_my_options').find('#ShowTitle select').val(section_object.ShowTitle);
    $('#gp_my_options').find('#imagelinked select').val(section_object.imagelinked);
    $('#gp_my_options').find('#ECPColumns input').val(section_object.ECPColumns);
    $('#gp_my_options').find('#ECPMinHeight input').val(section_object.ECPMinHeight);
    $('#gp_my_options').find('#ItemW input').val(section_object.ItemW);
    $('#gp_my_options').find('#img_text select').val(section_object.img_text);
			
	//set vals for added opts
	$.each(section_object, function(i, item) {
		 if (i!="attributes"){
				if(item !== null && typeof item === 'object'){
					var add_name= i;
						$.each(item, function(key, val) {
							var n ='[name="'+add_name+'['+key+']"]';
							$('#gp_my_options').find(n).val(val);
						})
					
								
				}
				
		 }
	 });
	 
	
	if(typeof section_object.datafilter !== "undefined")
	{
		var temp=section_object.datafilter.split(',');
		$.each(temp, function(i, item) {
			
			$.each($("input[name='datafilter[]']"), function() {
					  if($(this).val() == item){
						  $(this).prop('checked', true);
					  }
					  
					});
				
	   });
	} 

    if (section_object.source == 2) {
        $('#cat_menu').removeClass('hidei');
    }
    if (section_object.shortinfo == 1) {
        $('#abr').removeClass('hidei');
    }

    $('#gp_my_options').find('#source select').change(function() {
        if ($(this).val() == 2) {
            $('#cat_menu').removeClass('hidei');
        } else {
            $('#cat_menu').addClass('hidei');
        }

    });
    $('#gp_my_options').find('#shortinfo select').change(function() {
        if ($(this).val() == 1) {
            $('#abr').removeClass('hidei');
        } else {
            $('#abr').addClass('hidei');
        }

    });



	//layout options show/hide
	$("#lay_opt"+section_object.catalog_layout).removeClass('hidei');
	
	$('#gp_my_options').find('#catalog_layout select').change(function() {
		var ids = $(this).val();
		$('.lay_opt').addClass('hidei');
		$("#lay_opt"+ids).removeClass('hidei');
	  });
	$('#gp_my_options').find('#image_opts').on('click', function() { 
			$('#gp_my_options').find('.image_opts_container').toggle('slow');
	});
	
	

	//trigger selects change
    $('#gp_my_options').find('select').change(function() {
        gp_editor.updatesect();
    });
	
	//checkbox change
	$('#gp_my_options').find('input[type="checkbox"]').on('change', function() { 
			 gp_editor.updatesect();
	});

	//trigger inputs change
    $('#gp_my_options').find('input').not('#sourcepages').each(function() {
        var elem = $(this);

        // Save current value of element
        elem.data('oldVal', elem.val());

        // Look for changes in the value
        elem.bind("propertychange change click keyup input paste", function(event) {
            // If value has changed...
            if (elem.data('oldVal') != elem.val()) {
                // Updated stored value
                elem.data('oldVal', elem.val());

                // Do action
                gp_editor.updatesect();
            }
        });
    });


}
