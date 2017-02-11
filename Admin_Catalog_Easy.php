<?php
/*
PHP admin script for Catalog Easy gpEasy Plugin
Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.8.2
*/
defined('is_running') or die('Not an entry point...');


class Admin_Catalog_Easy{

	var $item_per_page	= 6;
	var $catalog_layout	= 0;
	var $ImagesizeW 	= 200;
	var $ImagesizeH 	= 200;
	var $ECPColumns		= 5;
	var $ECPMinHeight	= 400;
	var $ECrow			= 4;
	var $AbbrevL		= 100;
	var $ShortInfo      = "sect";
	
	//list
	var $item_per_pageL		= 6;
	var $ImagesizeWL 		= 200;
	var $ImagesizeHL 		= 200;
	var $ImageCircleL 		= false;
	var $ShowImageL			= true;
	var $ShowSortingL		= false;	
	//2c
	var $item_per_page2c	= 6;
	var $ImagesizeW2c 		= 200;
	var $ImagesizeH2c 		= 200;
	var $ImageCircle2c 		= false;
	var $ShowImage2c		= true;
	var $ShowSorting2c		= false;
    //3c
	var $item_per_page3c	= 6;
	var $ImagesizeW3c 		= 200;
	var $ImagesizeH3c 		= 200;
	var $ImageCircle3c 		= false;
	var $ShowImage3c		= true;
	var $ShowSorting3c		= false;
	//carousel
	var $ImagesizeWcar 		= 200;
	var $ImagesizeHcar 		= 200;
	var $ImageCirclecar 	= false;
	var $ShowImagecar		= true;
	var $ShowTitlecar		= true;
	var $ECheight    		= null;
	var $datafilter			=array();
	
	var $imagelinked		= 0;
	var $Showtitle			= false;
	var $ItemW				= 30;
	var $ECthumb			= false;
	var $ECthumbH			= 200;
	var $ECthumbW			= 200;
	var $wap				= false;
	var $catpages			= "";
	var $nav_parent			= true;
	var $nav_style			=0;
	var $nav_buttons		=0;
	
	var $ImagesizeWpg		=200;
	var $ImagesizeHpg		=200;	
	var $ImagesizeWsp		=200;
	var $ImagesizeHsp		=200;
	
  
  function __construct()
  {
	  	$this->var_names= array (
				'item_per_page',  'catalog_layout',  'ImagesizeW' ,   'ImagesizeH' ,
				'ECPColumns',  'ECPMinHeight',  'ECrow',  'ECheight',  'ShortInfo' ,
				'AbbrevL',  
				'item_per_pageL' ,  'ImagesizeWL',  'ImagesizeHL' ,  'ShowImageL' ,  'ShowSortingL',  'ImageCircleL' ,
				'item_per_page3c' ,'ShowImage3c',  'ShowSorting3c' ,  'ImageCircle3c', 'ImagesizeW3c','ImagesizeH3c' ,
				'item_per_page2c','ShowSorting2c',  'ShowImage2c' ,  'ImageCircle2c','ImagesizeW2c','ImagesizeH2c' ,
				'ShowImagecar',  'ImageCirclecar',  'ShowTitlecar', 'ImagesizeWcar' ,'ImagesizeHcar' ,
				'Showtitle' ,'datafilter' ,'imagelinked','ItemW',
				'ECthumb','ECthumbH','ECthumbW', 'wap',
				'catpages','nav_parent','nav_style','nav_buttons',
				'ImagesizeWpg','ImagesizeHpg','ImagesizeWsp','ImagesizeHsp'				
			);
	  
 	$this->loadConfig();

    $cmd = common::GetCommand();

    switch($cmd){
      case 'saveConfig':
        $this->saveConfig();
		$this->showForm();
		break;
		case 'del_thumbs':
        $this->deleteThumbs();
		$this->showForm();
		break;
		case 'don':
        $this->don();
		break;
		default:
		$this->showForm();
		
    }
		//$this->showForm();
  }

  function showForm()
  {
    global $langmessage,$config,$addonRelativeCode,$page,$gp_index,$addonFolderName;
	
	if (version_compare(gpversion, "5.0b1", ">=")) {
	  $this->vers = "more5";
	} else {
	  $this->vers = "less5";
	} 
	
	foreach ($config['addons'] as $addon_key => $addon_info) {
		  if ($addon_info['name'] == 'Catalog Easy') {
			$addon_vers = $addon_info['version'];
				  
		  }
		}
	
	$page->head_js[] = $addonRelativeCode.'/js/admin_catalog.js';
	$page->css_admin[] = $addonRelativeCode.'/css/admin_catalog.css';
	$page->css_admin[] = $addonRelativeCode.'/css/ec.css';	
	
	
	echo '<div class="EC_admin_header"><img src="'.$addonRelativeCode.'/img/IconCatalog.png'.'" border="0" style="float:left;" />
	<h2>Easy Catalog</h2>
	 <h3>'.$addon_vers .'</h3>
	</div>';

	
	
	
	echo '<div style="width:100%; float:left;">';//
echo '<button name="EC_panel1" class="EC_doc gpbutton" >Layouts settings</button>';
//echo '<button name="EC_panel2" class="EC_doc gpbutton"  > Layouts settings</button>';
//echo '<button name="EC_panel3" class="EC_doc gpbutton"  > 2 Columns Layout</button>';
//echo '<button name="EC_panel4" class="EC_doc gpbutton"  >3 Columns Layout</button>';
//echo '<button name="EC_panel5" class="EC_doc gpbutton"  >Portfolio Gallery</button>';
//echo '<button name="EC_panel6" class="EC_doc gpbutton"  >Carousel  Layout</button>';

echo '<button name="EC_panel8" class="EC_doc gpbutton"  >Special Options</button>';
echo '<button name="EC_panel9" class="EC_doc gpbutton"  >Page Manager</button>';
echo '<button name="EC_panel10" class="EC_doc gpbutton"  >Help&About</button>';
//echo '<hr>';

    echo '<form action="'.common::GetUrl('Admin_Catalog_Easy').'" method="post">';
	echo '<br />';
   
//Default option panel		
	echo '<div id="EC_panel1" class="EC_panel EC_panel_default">'; 
	
	echo '<div class="EC_panel_100">'; 
	
	echo '<div style="display:none;">'; //hide defaults
	echo '<p>Items per page<br/>';
    echo '<input type="text" name="item_per_page" value="'.$this->item_per_page .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	

	echo '<h4>Image Options:</h4>';
	
		
	echo '<p>Width(px) ';
    echo '<input type="number" step="1" name="ImagesizeW" value="'.$this->ImagesizeW .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="number" step="1" name="ImagesizeH" value="'.$this->ImagesizeH .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '</div>';
			
	echo '<div style="width:30%;float:left;">';	
	echo '<h4>Layout Options:</h4>';
    echo '<p>Default catalog layout<br/>';
  	$select_data=array(0=>'List',1=>'3 columns',2=>'2 columns',3=>'Portfolio Gallery',4=>'Carousel',5=>'Sortable Portfolio');
	 if( $this->catalog_layout ){
		echo self::Select('catalog_layout',$select_data, $this->catalog_layout,'gpselect');	
		} else {
		echo self::Select('catalog_layout',$select_data, 0,'gpselect');
	}
    echo '</p>';
	echo '</div>';
	
	echo '<div style="width:40%;float:left;">';		
	echo '<h4>Short Info Options:</h4>';
	$rad_1="";$rad_2="";
	if($this->ShortInfo=="sect") {$rad_1 = 'checked="checked"';} else {$rad_2 = 'checked="checked"';}
	echo '<input type="radio" name="ShortInfo" value="sect" '.$rad_1.'>From section with short_info class<br>';
	echo '<input type="radio" name="ShortInfo" value="abrev" '.$rad_2.'>From content Abbreviation Length =';
	 
	 echo '<input type="number" step="1" name="AbbrevL" value="'.$this->AbbrevL .'" class="gpinput" style="width:150px" />';
	echo '</div>';	


	
	echo '<div style="width:20%;float:left;">';	
	echo '<br/>';
	echo '<p>Use  pagination without ajax?  ';
	if( $this->wap  ){
	echo '<input type="checkbox" name="wap" value="yes" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="wap" value="yes" />';
		}
	echo '</p>';
	
	echo '<p class="gpbutton">';
	if ($this->vers=="more5"){
	echo common::Link('Admin_Theme_Content/Text',$langmessage['editable_text'],'cmd=AddonTextForm&addon='.urlencode($addonFolderName),' title="'.urlencode($langmessage['editable_text']).'" name="gpabox" class="nodecor" ');
	} else {
	echo common::Link('Admin_Theme_Content',$langmessage['editable_text'],'cmd=addontext&addon='.urlencode($addonFolderName),' title="'.urlencode($langmessage['editable_text']).'" name="gpabox" class="nodecor" ');	
	}
	echo ' &nbsp; &nbsp; ';
	echo '</p>';
	
	echo '</div>';	
	
	
	echo '</div>';	//end panel_100 fullwidth
	
//List layout panel
	echo '<div id="EC_panel2" class="EC_panel1 row1">';
	
	$this->Panel_title('List Layout');

	echo '<p>Items per page<br/>';
    echo '<input type="number" step="1" name="item_per_pageL" value="'.$this->item_per_pageL .'" class="gpinput" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSortingL  ){
	echo '<input type="checkbox" name="ShowSortingL" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSortingL" value="true" />';
		}


	echo '<h4>Image Options:</h4>';
	
	echo '<p>Show image?  ';
	if( $this->ShowImageL  ){
	echo '<input type="checkbox" name="ShowImageL" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowImageL" value="true" />';
		}

	echo '<p>Circle image?  ';
	if( $this->ImageCircleL  ){
	echo '<input type="checkbox" name="ImageCircleL" value="circle" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ImageCircleL" value="circle" />';
		}
	
	echo '<p>Width(px) ';
    echo '<input type="number" step="1" name="ImagesizeWL" value="'.$this->ImagesizeWL .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="number" step="1" name="ImagesizeHL" value="'.$this->ImagesizeHL .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
			
	echo '</div>';
	
	
	
//3 columns layout panel
	echo '<div id="EC_panel4" class="EC_panel1 row1">';
	
	$this->Panel_title('3 Columns Layout');
	
	echo '<p>Items per page<br/>';
    echo '<input type="number" step="1" name="item_per_page3c" value="'.$this->item_per_page3c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSorting3c  ){
	echo '<input type="checkbox" name="ShowSorting3c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSorting3c" value="true" />';
		}


	echo '<h4>Image Options:</h4>';
	
	echo '<p>Show image?  ';
	if( $this->ShowImage3c  ){
	echo '<input type="checkbox" name="ShowImage3c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowImage3c" value="true" />';
		}

	echo '<p>Circle image?  ';
	if( $this->ImageCircle3c  ){
	echo '<input type="checkbox" name="ImageCircle3c" value="circle" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ImageCircle3c" value="circle" />';
		}
	
	
	echo '<p>Width(px) ';
    echo '<input type="number" step="1" name="ImagesizeW3c" value="'.$this->ImagesizeW3c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	
	echo '<p>Max-height image(px) ';
    echo '<input type="number" step="1" name="ImagesizeH3c" value="'.$this->ImagesizeH3c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
			
	echo '</div>';	

	
//2 columns layout panel
	echo '<div id="EC_panel3" class="EC_panel1 row1">';
	
	$this->Panel_title('2 Columns Layout');

	echo '<p>Items per page<br/>';
    echo '<input type="number" step="1" name="item_per_page2c" value="'.$this->item_per_page2c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSorting2c  ){
	echo '<input type="checkbox" name="ShowSorting2c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSorting2c" value="true" />';
		}


	echo '<h4>Image Options:</h4>';
	
	echo '<p>Show image?  ';
	if( $this->ShowImage2c  ){
	echo '<input type="checkbox" name="ShowImage2c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowImage2c" value="true" />';
		}

	echo '<p>Circle image?  ';
	if( $this->ImageCircle2c  ){
	echo '<input type="checkbox" name="ImageCircle2c" value="circle" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ImageCircle2c" value="circle" />';
		}
	
	echo '<p>Width(px) ';
    echo '<input type="number" min="1" name="ImagesizeW2c" value="'.$this->ImagesizeW2c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Max-height image(px)';
    echo '<input type="number" min="1" name="ImagesizeH2c" value="'.$this->ImagesizeH2c .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	echo '</div>';	 



//Portfolio Gallery panel
	echo '<div id="EC_panel5" class="EC_panel1 row2">';	 
	
	$this->Panel_title('Portfolio Gallery Layout');
	
	echo '<p>Number of columns<br/>';
    echo '<input type="number" step="1" name="ECPColumns" value="'.$this->ECPColumns .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Height of expandable info (px)<br/>';
    echo '<input type="number" min="1" name="ECPMinHeight" value="'.$this->ECPMinHeight .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	echo '<h4>Image Options:</h4>';
	
		
	echo '<p>Width(px) ';
    echo '<input type="number" min="1" name="ImagesizeWpg" value="'.$this->ImagesizeWpg .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="number" min="1" name="ImagesizeHpg" value="'.$this->ImagesizeHpg .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	echo '</div>';		 


//Carousel panel
	echo '<div id="EC_panel6" class="EC_panel1 row2">';	 
	
	$this->Panel_title('Carousel  Layout');
			
	echo '<p>Show title?  ';
	if( $this->ShowTitlecar  ){
	echo '<input type="checkbox" name="ShowTitlecar" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowTitlecar" value="true" />';
		}
	
	echo '<h4>Image Options:</h4>';
	
	echo '<p>Show image?  ';
	if( $this->ShowImagecar  ){
	echo '<input type="checkbox" name="ShowImagecar" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowImagecar" value="true" />';
		}	
	
	echo '<p>Circle image?  ';
	if( $this->ImageCirclecar  ){
	echo '<input type="checkbox" name="ImageCirclecar" value="circle" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ImageCirclecar" value="circle" />';
		}
	echo '</p>';
	
	
	echo '<p>Width(px) ';
    echo '<input type="number" min="1" name="ImagesizeWcar" value="'.$this->ImagesizeWcar .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	echo '<p>Max-height image(px)';
    echo '<input type="number" min="1" name="ImagesizeHcar" value="'.$this->ImagesizeHcar .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	
	echo '<p>Number of items in row<br/>';
	echo '<input type="number" step="1" name="ECrow" value="'.$this->ECrow .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p class="tooltip" data-tooltip="Use it when your items have diferent height(to avoid arrows bouncing)" >Height of carousel (px)<br/>';
    echo '<input type="number" step="1" name="ECheight" value="'.$this->ECheight .'" class="gpinput" style="width:150px" />';
    echo '</p>'; 
	
	echo '</div>';		

//Sortable Portfolio panel	
		echo '<div id="EC_panel7" class="EC_panel1 row2">';	 
		
		$this->Panel_title('Sortable Portfolio  Layout');
			
		echo '<p>Show title?  ';
		if( $this->Showtitle  ){
		echo '<input type="checkbox" name="Showtitle" value="true" checked="checked" />';
		}else{
		echo '<input type="checkbox" name="Showtitle" value="true" />';
		}
		
		echo '<p>Width of portfoliio item (%)<br/>';
		echo '<input type="text" name="ItemW" value="'.$this->ItemW.'" class="gpinput" style="width:150px" />';
		echo '</p>';
		
		echo '<h4>Image Options:</h4>';
				
		echo '<p>Width(px) ';
		echo '<input type="number" min="1" name="ImagesizeWsp" value="'.$this->ImagesizeWsp .'" class="gpinput" style="width:150px" />';
		echo '</p>';
		echo '<p>Height(px) ';
		echo '<input type="number" min="1" name="ImagesizeHsp" value="'.$this->ImagesizeHsp .'" class="gpinput" style="width:150px" />';
		echo '</p>';
		echo '<p>Image is linked to:<br/>';
		echo '<select name="imagelinked" class="gpselect">';
		if( $this->imagelinked == 1)
    {
      echo '  <option value="0">Child page</option>';
      echo '  <option value="1" selected="selected">Colorbox</option>';
	  
    } else{
	echo '  <option value="0" selected="selected">Child page</option>';
      echo '  <option value="1" >Colorbox</option>';
	}
	 echo '</select>';
    echo '</p>';
	
	
	
		echo '<div class="input_fields_wrap">';
		echo '<div class="add_field_button" style="float:left"><img src="'.$addonRelativeCode.'/img/add_list.png'.'" border="0" /></div>';
		echo '<p class="tooltip" data-tooltip="You need to add Attribute data-filter with value name of category( or names separeted by space) to one section on your Child page.">Add Category</p>';
		echo '<div style="width:100%; float:left;">';
		if(!$this->datafilter){
		echo '<div><input class="gpinput" type="text" name="datafilter[]"></div>';
		}else{
		$pieces = explode(",", $this->datafilter);
		 for($i = 0; $i < count($pieces); $i++) {
		echo '<div><input class="gpinput" type="text" value="'.$pieces[$i].'"name="datafilter[]"/><a href="#" class="remove_field"><img src="'.$addonRelativeCode.'/img/delete.png'.'" border="0" /></a></div>';
		}
		  }
		echo '</div>';
	
		echo '</div>';	

echo '</div>';//end sortable portfolio panel

echo '</div>';//end first default panel

//special option panel
echo '<div id="EC_panel8" class="EC_panel ">';
	
	echo '<div class="EC_panel1 row1">';
	$this->Panel_title('Thumbnails ');
	echo '<p>Use EasyCatalog generated thumbnails for images?  ';
	if( $this->ECthumb  ){
	echo '<input type="checkbox" name="ECthumb" value="yes" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ECthumb" value="yes" />';
		}
	  echo '</p>';
	
	echo '<p>Thumbnail size will be taken from layout image settings</p>';
	echo '<br/>';
	echo '<div style="display:none">';
	echo '<p>Width(px) ';
    echo '<input type="text" name="ECthumbW" value="'.$this->ECthumbW .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ECthumbH" value="'.$this->ECthumbH .'" class="gpinput" style="width:150px" />';
    echo '</p>';
	echo '</div>';	
	
	echo '<input type="button" onClick="location.href=\'' . common::GetUrl('Admin_Catalog_Easy') . '?cmd=del_thumbs\'" name="cmd" ';
    echo 'value="Delete generated thumbnails" class="admin_box_close gpcancel" />';
	echo '</div>';
	
	
	echo '<div class="EC_panel1 row1">';
	$this->Panel_title('Navigation');
	echo '<p>Show Parent page link?  ';
		if( $this->nav_parent ){
		echo '<input type="checkbox" name="nav_parent" value="true" checked="checked" />';
		}else{
		echo '<input type="checkbox" name="nav_parent" value="true" />';
		}
	echo '</p>';
	$select_data_style=array(0=>'Links',1=>'Arrows',2=>'Arrows2',3=>'Arrows3');
	echo '<p>Navigation buttons:';
	if( $this->nav_style ){
	echo self::Select('nav_style',$select_data_style, $this->nav_style,'gpselect');	
	} else {
	echo self::Select('nav_style',$select_data_style, 0,'gpselect');
	}
	echo'</p>';
	$select_data_style2=array(0=>'Buttons in line',1=>'Buttons on both sides');
	echo '<p>Navigation style:';
	if( $this->nav_buttons ){
	echo self::Select('nav_buttons',$select_data_style2, $this->nav_buttons,'gpselect');	
	} else {
	echo self::Select('nav_buttons',$select_data_style2, 0,'gpselect');
	}
	echo'</p>';
	
	echo '</div>';
	
	
	
	
	echo '<div class="EC_panel1 row1">';
	$this->Panel_title('');
	echo '</div>';

	
echo '</div>';

//page manager panel
echo '<div id="EC_panel9" class="EC_panel EC_panel_100">';
		
				if(!array_key_exists ( "menus", $config) ){ $config['menus'] = "";}
		
		$select_data=array(0=>'List',1=>'3 columns',2=>'2 columns',3=>'Portfolio Gallery',4=>'Carousel',5=>'Sortable Portfolio');
		$select_data2=array(0=>'Direct ChildPages',1=>'ChildPages from  another page',2=>'From page in another menu');
		$select_data3=array(0=>'All, items per page=',1=>'First number =',2=>'Last number =', 3=>'Random number =');	
		
		$this->Panel_title('Page manager');
		
		echo '<div class="cat_pages">';
		echo '<div class="add_cat_page" style="float:left"><img src="'.$addonRelativeCode.'/img/add_list.png'.'" border="0" /></div>';
		echo '<p>&nbsp;&nbsp;&nbsp;Add Page to set options</p>';
		echo  '<br/>';
		echo '<div class="page_table" >';
		echo  '<p>Page label</p>';
		echo  '<p>Layout </p>';
		echo  '<p>Use nav?</p>';
		echo  '<p>How to take?</p>';
		echo  '<p>Source</p>';
		echo '</div>';
		echo  '<br/>';
		echo  '</hr>';
	//	echo '<div style="width:100%; float:left;">';
	
		if(!$this->catpages){
		echo '<div class="input_box"><input class="cp gpinput" type="text" name="catpages[0][label]">';
		echo self::Select('catpages[0][layout]',$select_data, 0,'cat_lay gpselect');
		echo '<input class="navi" type="checkbox" name="catpages[0][navi]" value="yes"/>';
		echo self::Select('catpages[0][beh]',$select_data3, 0,'cat_lay gpselect beh');
		echo '<input class="gpinput crop" type="number" step="1" min="1" name="catpages[0][crop]"  />';
		echo self::Select('catpages[0][source]',$select_data2, 0,'source cat_lay gpselect');
		echo self::Select('catpages[0][cat_menu]',$config['menus'], 0,'menus cat_lay gpselect');
		echo '<input class="cp gpinput" type="text" name="catpages[0][sourcepages]"  />';
		
		echo '</div>';
		echo '<input type="hidden" name="max_catpage" id="max_catpage" value="0" class="gpinput" style="width:150px" />';
		}else{
		
		 foreach($this->catpages as $key=>$catpage) {
	
		echo '<div class="input_box">';
		echo '<input class="cp gpinput" type="text" value="'.$catpage['label'].'"name="catpages['.$key.'][label]"/>';
		$b = 'catpages['.$key.'][layout]';
		$c = 'catpages['.$key.'][source]';
		$d = 'catpages['.$key.'][cat_menu]';
		$e = 'catpages['.$key.'][beh]';
		echo self::Select($b,$select_data, $catpage['layout'],'cat_lay gpselect');
		
		if($catpage['navi']){
		echo '<input class="navi" type="checkbox" name="catpages['.$key.'][navi]" value="yes" checked="checked"/>';
		} else {
		echo '<input class="navi" type="checkbox" name="catpages['.$key.'][navi]" value="yes"/>';	
		}
		
		echo self::Select($e,$select_data3, $catpage['beh'],'cat_lay gpselect beh');
		
		echo '<input class="gpinput crop" type="number" step="1" min="1" value="'.$catpage['crop'].'"  name="catpages['.$key.'][crop]"  />';
		
		echo self::Select($c,$select_data2, $catpage['source'],'source cat_lay gpselect');	
		
		echo self::Select($d,$config['menus'], $catpage['cat_menu'],'menus cat_lay gpselect');
		
		echo '<input class="cp gpinput" type="text" value="'.$catpage['sourcepages'].'" name="catpages['.$key.'][sourcepages]"  />';
		
		echo '<a href="#" class="remove_cat_page"><img src="'.$addonRelativeCode.'/img/delete.png'.'"  /></a>';
		echo '</div>';
		
		
		
		
		}
		echo '<input type="hidden" name="max_catpage" id="max_catpage" value="'.max(array_keys($this->catpages)).'" class="gpinput" style="width:150px" />';
		
		  }
	//	echo '</div>';
	
		echo '</div>';	

		
echo '</div>'; //end page manager

//help&about panel
echo '<div id="EC_panel10" class="EC_panel">';
		
		echo '<div class="EC_panel1 row1">';
		$this->Panel_title('About');
		
		echo '<h4>Easy Catalog</h4>';
		echo '<h5>version '.$addon_vers .'</h5>';
		echo '<p><i>plugin for Typesetter CMS</i></p>';
		echo '<p><i>Made by Sitelab</i></p>';
		echo '<p><a href="http://my-sitelab.com/" target="_blank"><img alt="Sitelab" src="'.$addonRelativeCode.'/img/st_logo.jpg'.'"  /></a> </p>';
		echo '</div>';
		
		echo '<div class="EC_panel1 row1">';
		
		$this->Panel_title('Usefull links');
		echo '<ul>';
		echo '<li><a href="http://ts-addons.my-sitelab.com/Catalog_Easy" target="_blank">Plugin page </a>(Demo,documentation)</li>'; 
		echo '<li><a href="http://gpeasy.com/Forum?show=f1287" target="_blank">Support Forum </a>(Qwestions, bugs, issues, suggestions for improvements are welcome.)</li>'; 
		echo '<li><a href="javascript:;" >Tutorials</a>(Coming..)</li>';
		echo '<li><a href="http://www.gpeasy.com/User/2617/Plugins" target="_blank">Another my plugins</a></li>'; 
		echo '</ul>';
		
		echo '</div>';
		
		echo '<div class="EC_panel1 row1">';
		$this->Panel_title(' ');
		
		
		 //  :(
		echo'<p>If you like plugin, if it works for you, I don&#39;t mind if you want to buy me a coffee <img alt="smiley" height="23" src="/include/thirdparty/ckeditor_34/plugins/smiley/images/regular_smile.png" title="smiley" width="23" /></p>';
		echo '<p style="text-align:center;">';
		echo common::Link('Admin_Catalog_Easy','<i class="fa fa-coffee icon-coffee"></i>' ,'cmd=don','class="gpbutton don" name="gpabox" ');
		echo '</p>';
		echo '</div>';



echo '</div>';	//end about

	
    echo '<input type="hidden" name="cmd" value="saveConfig" />';

    echo '<input type="submit" value="'.$langmessage['save_changes'].'" class="gpsubmit"/>';
    echo '</p>';
    echo '</form>';
	
	echo '</div>';


 }

  //  :(
 function don(){
		echo '<div style="float:left; margin-right:15px;" >';
		echo '<i class="fa fa-usd icon-dollar"></i>';
		echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><input name="cmd" type="hidden" value="_s-xclick" /> <input name="encrypted" type="hidden" value="-----BEGIN PKCS7-----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-----END PKCS7-----
		" /> <input alt="PayPal - The safer, easier way to pay online!" border="0" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" type="image" /> <img alt="" border="0" height="1" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" /></form>'; 
		echo '</div>';
		//
		echo '<div >';
		echo '<i class="fa fa-eur icon-euro"></i>';
		echo '<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
		">
		<input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
		<img alt="" border="0" src="https://www.paypalobjects.com/ru_RU/i/scr/pixel.gif" width="1" height="1">
		</form>';
		echo '</div>';
 }
 
	function deleteThumbs(){
		$num = 0;
		$files = glob('data/_uploaded/image/thumbnails/easy_catalog/*'); 
			foreach($files as $file){ 
				if(is_file($file))
						unlink($file); 
						$num++;
					}
		message( $num." - thumbnails deleted.");
					
	} 
 
 
 
  function saveConfig()
  {
    global                   $addonPathData;
    global                   $langmessage;

    $configFile            		= $addonPathData.'/config.php';
    $config                		= array();
    
	
	//options
	$opts = array('item_per_page','catalog_layout','ImagesizeW','ImagesizeH',
				'ECPColumns', 'ECPMinHeight',
				'ECrow','ECheight',
				'ShortInfo', 'AbbrevL',
				'item_per_pageL','ImagesizeWL','ImagesizeHL',
				'item_per_page3c','ImagesizeW3c','ImagesizeH3c',
				'item_per_page2c','ImagesizeW2c','ImagesizeH2c',
				'ImagesizeWcar','ImagesizeHcar',
				'imagelinked','ItemW',
				'ECthumbH','ECthumbW',
				'nav_style','nav_buttons',
				'ImagesizeWpg','ImagesizeHpg','ImagesizeWsp','ImagesizeHsp'	
				);
				
	 foreach ($opts as $opt) {
		 $config[$opt]	= $_POST[$opt];
		 }
	
	
	//checkboxes
	$checkboxes = array('ShowImageL','ShowSortingL','ImageCircleL',
					  'ShowImage3c','ShowSorting3c','ImageCircle3c',
					  'ShowSorting2c','ShowImage2c','ImageCircle2c',
					  'ShowImagecar','ImageCirclecar','ShowTitlecar','Showtitle',
					  'ECthumb','wap','nav_parent');
	
	foreach ($checkboxes as $check){
			if (isset($_POST[$check])){
			$config[$check] = $_POST[$check];
			} else {
				$config[$check] = '';
			}
		
	}
	
	//
	if($_POST){
	$_POST["datafilter"] = array_diff($_POST["datafilter"], array(''));
	$config['datafilter'] = implode(",", $_POST["datafilter"]);
	
		}
	
	//pages setings
	if($_POST){
		
	$temp_catpages = $_POST["catpages"];
	
	foreach($temp_catpages as $key=>$item){
		
		if (!array_key_exists ( "navi", $item)){
			$temp_catpages[$key]['navi']="";				
		}
		if (!array_key_exists ( "cat_menu", $item)){
			$temp_catpages[$key]['cat_menu']="";				
		}
		if ($item['label'] ==""){
			unset($temp_catpages[$key]);
		}
		
		
	}
	$config['catpages'] =  array_values($temp_catpages);
	
		}

	
	foreach ($this->var_names as $temp)
	{
	$this->$temp        = $config[$temp];
	}
	

	  
	
    if( !gpFiles::SaveArray($configFile,'config',$config) )
    {
      message($langmessage['OOPS']);
      return false;
    }

    message($langmessage['SAVED']);
    return true;
  }

  
  
  function loadConfig()
  {
    global                   $addonPathData;

    $configFile            = $addonPathData.'/config.php';
    
	if(  file_exists( $configFile ) )	{
		include_once $configFile;
			}

    if (isset($config)) {
     
	foreach ($this->var_names as $temp)
	{
		if (array_key_exists ( $temp, $config)){
			
		$this->$temp        = $config[$temp];
		}
	
	}

	  
    }
  }

  
  		function Select($name,$options,$current,$class){
		$a =  '<select id="'.$name.'" name="'.$name.'" class="'.$class.'" >';
		 if (is_array ( $options)){
				foreach($options as $key=>$value) {
				
					$selected = '';
					if( $current == $key){
						$selected = ' selected="selected"';
					}
					$a .='<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
				
				}
				
		 } 
			$a .='</select>';
		return $a;
	}
  
  
	function Panel_title($name) {
	echo '<div class="panel_title">'	;
	echo '<h4 style="display: inline;font-weight:500;">'.$name.'</h4>';
	echo '</div>';
	return;
		
	}
  
  
  
}

?>



