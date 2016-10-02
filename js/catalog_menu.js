/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8.2*/




					
 $(document).on("click","button.EC_browse_files",function(e){
	e.preventDefault();
	EC_menu.getImagefromFinder(0);	
 });
 
 $(document).on("click","#del_img_EC",function(e){
var container = $("#img_container");

 container.find("img").first().attr("src", catbase +"/img/default_thumb.jpg");
  $("#EC_custom_img").val('');
 
 });


 

var EC_menu = {
  getImageFromFinder  : function() {},
  setImage            : function() {}

}


EC_menu.getImagefromFinder = function(imgIdx) {
  window.CKEDITOR = {
    tools : { 
      callFunction : function(funcNum,fileUrl) { 
        if (fileUrl != "") {
          EC_menu.setImage(imgIdx,fileUrl);
        }
        return true;
      }
    }
  };
  var new_gpFinder = window.open(gpFinder_url, 'gpFinder', 'menubar=no, width=960, height=520');
  if (window.focus) { new_gpFinder.focus(); }
}

EC_menu.setImage = function(imgIdx, fileUrl) {
  var filetype = fileUrl.substr(fileUrl.lastIndexOf('.') + 1).toLowerCase();
  if (!filetype.match(/jpg|jpeg|png|gif|svg|svgz|mng|apng|webp|bmp|ico/)) {
    window.setTimeout(
      function() {
        alert("Please choose an image file! " 
          + "\nValid file formats are: *.jpg/jpeg, *.png/mng/apng, "
          + "*.gif, *.svg/svgz, *.webp, *.bmp, *.ico");
      }, 300
    );
    return;
  }
  var container = $("#img_container");
  if (container.find("img").first().length>0) {
    container.find("img").first().attr("src", fileUrl);
  } else {
    container.append('<img src="' + fileUrl + '" />');
  }
  $("#EC_custom_img").val(fileUrl);
 

  }




