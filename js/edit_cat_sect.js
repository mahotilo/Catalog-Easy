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

                var catalog_layout = $('#gp_my_options').find('#catalog_layout select').val();
                var source = $('#gp_my_options').find('#source select').val();
                var cat_menu = $('#gp_my_options').find('#cat_menu select').val();
                var sourcepages = $('#gp_my_options').find('#sourcepages input').val();
                var beh = $('#gp_my_options').find('#beh select').val();


                var crop = $('#gp_my_options').find('#crop input').val();
                var width = $('#gp_my_options').find('#width input').val();
                var height = $('#gp_my_options').find('#height input').val();
                var EC_thumb = $('#gp_my_options').find('#EC_thumb select').val();
                var showimage = $('#gp_my_options').find('#showimage select').val();
                var shortinfo = $('#gp_my_options').find('#shortinfo select').val();
                var abr = $('#gp_my_options').find('#abr input').val();
                
				var ECrow = $('#gp_my_options').find('#ECrow input').val();
                var ECheight = $('#gp_my_options').find('#ECheight input').val();
                var ShowTitlecar = $('#gp_my_options').find('#ShowTitlecar select').val();
				
				var ECPColumns = $('#gp_my_options').find('#ECPColumns input').val();
                var ECPMinHeight = $('#gp_my_options').find('#ECPMinHeight input').val();
				
                return '&catalog_layout=' + catalog_layout + '&source=' + source + '&sourcepages=' + sourcepages + '&beh=' + beh +
                    '&crop=' + crop + '&width=' + width + '&height=' + height + '&EC_thumb=' + EC_thumb + '&showimage=' + showimage +
                    '&cat_menu=' + cat_menu + '&shortinfo=' + shortinfo + '&abr=' + abr + '&ECheight=' + ECheight + '&ECrow=' + ECrow +
					'&ShowTitlecar=' + ShowTitlecar +
					'&ECPColumns=' + ECPColumns + '&ECPMinHeight=' + ECPMinHeight;
            },
            intervalSpeed: function() {},



            updatesect: function() {}
        } // gpeditor --end


    gp_editor.updatesect = function() {

        var href = jPrep(window.location.href) + '&cmd=refresh_section' + '&my_value=' + gp_editor.gp_saveData() + '&EC_id=' + section_object.EC_id;
        $.getJSON(href, ajaxResponse);
        //console.log(gp_editor.gp_saveData());
    }



    $gp.response.refresh_replayFn = function(arg) {
        //alert('my callback fn says: "' + arg.CONTENT + '"');
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
            $(".EC_portfolio").mixitup({
                targetSelector: ".item",
                transitionSpeed: 450
            });
        });

        $(".EC_img").colorbox();
    }


    var option_area = $('<div id="gp_my_options"/>').prependTo('#ckeditor_controls');

    var ms = "";
    ms += '<select class="cat_menu gpselect" name="cat_menu">';
    $.each(gpE_menus, function(i, item) {

        ms += '<option value="' + i + '">' + item + '</option>'

    });
    ms += '</select>';


    var option_messages = $(
            '<div id="option_message">' +
            ' <div id="catalog_layout"><p>Catalog layout<select class="catalog_layout gpselect" name="catalog_layout">' +
            '<option value="0">List</option>' +
            '<option value="1">3 columns</option>' +
            '<option value="2">2 columns</option>' +
            '<option value="3">Portfolio Gallery</option>' +
            '<option value="4">Carousel</option>' +
            '<option value="5">Sortable Portfolio</option>' +
            '</select></p></div>' +
            '<div id="lay_opt4" class="lay_opt hidei">' +
            '<div id="ShowTitlecar"><p>Show title?<select class="gpselect" name="ShowTitlecar">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="ECrow"><p>Number of items in row<input type="text" name="ECrow" class="gpinput"  /></p></div>' +
            '<div id="ECheight"><p>Height of carousel (px)<input type="text" name="ECheight" class="gpinput"  /></p></div>' +
            '</div>' + 
			'<div id="lay_opt3" class="lay_opt hidei">' +
            '<div id="ECPColumns"><p>Number of columns<input type="text" name="ECPColumns" class="gpinput"  /></p></div>' +
            '<div id="ECPMinHeight"><p>Height of expandable info(px)<input type="text" name="ECPMinHeight" class="gpinput"  /></p></div>' +
            '</div>' +
			' <div id="source"><p>Source<select class="source gpselect" name="source" style="width: 175px;">' +
            '<option value="0">Direct ChildPages</option>' +
            '<option value="1">ChildPages from another page</option>' +
            '<option value="2">From page in another menu</option>' +
            '</select></p></div>' +
            '<div id="cat_menu" class="hidei"><p> Another menu' + ms + '</p></div>' +
            '<div id="sourcepages"><p>Source page<input type="text" name="sourcepages" class="gpinput"  /></p></div>' +
            '<div id="beh"><p>How to take<select class="beh gpselect" name="beh">' +
            '<option value="0">All, items per page=</option>' +
            '<option value="1">First number =</option>' +
            '<option value="2">Last number =</option>' +
            '<option value="3">Random number =</option>' +
            '</select></p></div>' +
            '<div id="crop"><p>Number to take <input type="text" name="crop" class="gpinput"  /></p></div>' +
            '<div id="showimage"><p>Show image?<select class="gpselect" name="showimage">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="width"><p>Image width(px)<input type="text" name="width" class="gpinput"  /></p></div>' +
            '<div id="height"><p>Image height(px)<input type="text" name="height" class="gpinput"  /></p></div>' +
            '<div id="EC_thumb"><p>Use EasyCatalog generated thumbnails?<select class="EC_thumb gpselect" name="EC_thumb">' +
            '<option value="no">No</option>' +
            '<option value="yes">Yes</option>' +
            '</select></p></div>' +
            '<div id="shortinfo"><p>Short info:<select class="gpselect" name="shortinfo" style="width: 175px;">' +
            '<option value="0">From section with short_info class</option>' +
            '<option value="1">From content</option>' +
            '</select></p></div>' +
            '<div id="abr" class="hidei"><p>Abbreviation Length=<input type="text" name="sourcepages" class="gpinput"  /></p></div>' +
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
    $('#gp_my_options').find('#ECPColumns input').val(section_object.ECPColumns);
    $('#gp_my_options').find('#ECPMinHeight input').val(section_object.ECPMinHeight);


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
	
	

	//trigger selects change
    $('#gp_my_options').find('select').change(function() {

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