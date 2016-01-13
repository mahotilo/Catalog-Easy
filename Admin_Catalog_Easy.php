<?php
/*
PHP admin script for Catalog Easy gpEasy Plugin
Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.7
*/
defined('is_running') or die('Not an entry point...');


class Admin_Catalog_Easy{

	var $item_per_page	= 6;
	var $catalog_layout	= 0;
	var $ImagesizeW 	= 200;
	var $ImagesizeH 	= 200;
	var $LinesPages 	= "Label1,Label2,Label3";
	var $column3Pages 	= "Label1,Label2,Label3";
	var $column2Pages 	= "Label1,Label2,Label3";
	var $PGPages 		= "Label1,Label2,Label3";
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
	var $CarPages			= "Label1,Label2,Label3";
	var $ECheight    		= null;
	var $datafilter			=array();
	
	var $imagelinked		= 0;
	var $Showtitle			= false;
	var $ItemW				= 30;
	var $anotherpage		= null;
	var $netpage			= null;
	var $ECthumb			= false;
	var $ECthumbH			= 200;
	var $ECthumbW			= 200;
	
  
  function Admin_Catalog_Easy()
  {
 	$this->loadConfig();

    $cmd = common::GetCommand();

    switch($cmd){
      case 'saveConfig':
        $this->saveConfig();
		break;
		case 'del_thumbs':
        $this->deleteThumbs();
		break;
		
    }
		$this->showForm();
  }

  function showForm()
  {
    global $langmessage,$addonRelativeCode,$page,$gp_index;
	
	   
     $pageIndexJS = 'var gpE_availablelabels = [';
      $i = 0;
      foreach ($gp_index as $key => $value) {
        $i++;
        $pageIndexJS .= '"' . common::GetLabelIndex($value) . '"' . ($i == count($gp_index) ? '' : ', ');
      }
      $pageIndexJS .= '];';
      $page->head_script .= "\n" . $pageIndexJS . "\n";
        
	
	
	$page->head_js[] = $addonRelativeCode.'/js/admin_catalog.js';
	$page->css_admin[] = $addonRelativeCode.'/css/admin_catalog.css';
	$page->head .='<script>$(document).ready(function() {
	
	 //inp

    var max_fields      = 20; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(\'<div><input type="text" name="datafilter[]"/><a href="#" class="remove_field"><img src="'.$addonRelativeCode.'/img/delete.png'.'" border="0" /></a></div>\'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent("div").remove(); x--;
    })
	
	});</script>';
  
	echo '<div class="EC_admin_header"><img src="'.$addonRelativeCode.'/img/IconCatalog.png'.'" border="0" style="float:left;" />
	<h2>Easy Catalog</h2>
	 <h3>1.7.1</h3>
	</div>';
    
	echo '<div style="width:100%; float:left;">';//
echo '<button name="EC_panel1" class="EC_doc" >Defult options</button>';
echo '<button name="EC_panel2" class="EC_doc"  > List Layout</button>';
echo '<button name="EC_panel3" class="EC_doc"  > 2 Columns Layout</button>';
echo '<button name="EC_panel4" class="EC_doc"  >3 Columns Layout</button>';
echo '<button name="EC_panel5" class="EC_doc"  >Portfolio Gallery</button>';
echo '<button name="EC_panel6" class="EC_doc"  >Carousel  Layout</button>';
echo '<button name="EC_panel7" class="EC_doc"  >Sortable Portfolio</button>';
echo '<button name="EC_panel8" class="EC_doc"  >Special Options</button>';
//echo '<hr>';

    echo '<form action="'.common::GetUrl('Admin_Catalog_Easy').'" method="post">';
	echo '<br>';
   
//Default option panel		
	echo '<div id="EC_panel1" class="EC_panel EC_panel_default">'; 
	echo '<p>Items per page</br>';
    echo '<input type="text" name="item_per_page" value="'.$this->item_per_page .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	

	echo '<h5>Image Options:</h5>';
	
		
	echo '<p>Width(px) ';
    echo '<input type="text" name="ImagesizeW" value="'.$this->ImagesizeW .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ImagesizeH" value="'.$this->ImagesizeH .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
			
		
	echo '<h5>Layout Options:</h5>';
    echo '<p>Default catalog layout</br>';
    echo '<select name="catalog_layout">';
    if( $this->catalog_layout == 1)
    {
      echo '  <option value="0">List</option>';
      echo '  <option value="1" selected="selected">3 columns</option>';
	  echo '  <option value="2">2 columns</option>';
	  echo '  <option value="3">Portfolio Gallery</option>';
	  echo '  <option value="4">Carousel</option>';
	  echo '  <option value="5">Sortable Portfolio</option>';
    }
    elseif( $this->catalog_layout == 2)
    {
      echo '  <option value="0">List</option>';
      echo '  <option value="1">3 columns</option>';
	  echo '  <option value="2" selected="selected">2 columns</option>';
	  echo '  <option value="3">Portfolio Gallery</option>';
	  echo '  <option value="4">Carousel</option>';
	  echo '  <option value="5">Sortable Portfolio</option>';
    } elseif( $this->catalog_layout == 3) {
	  echo '  <option value="0">List</option>';
      echo '  <option value="1">3 columns</option>';
	  echo '  <option value="2">2 columns</option>';
	  echo '  <option value="3" selected="selected">Portfolio Gallery</option>';
	  echo '  <option value="4">Carousel</option>';
	  echo '  <option value="5">Sortable Portfolio</option>';
	} elseif( $this->catalog_layout == 4) {
	  echo '  <option value="0">List</option>';
      echo '  <option value="1">3 columns</option>';
	  echo '  <option value="2">2 columns</option>';
	  echo '  <option value="3">Portfolio Gallery</option>';
	  echo '  <option value="4" selected="selected">Carousel</option>';
	  echo '  <option value="5">Sortable Portfolio</option>';
	} elseif( $this->catalog_layout == 5) {
	  echo '  <option value="0">List</option>';
      echo '  <option value="1">3 columns</option>';
	  echo '  <option value="2">2 columns</option>';
	  echo '  <option value="3">Portfolio Gallery</option>';
	  echo '  <option value="4">Carousel</option>';
	  echo '  <option value="5" selected="selected">Sortable Portfolio</option>';
		
	} else{
	  echo '  <option value="0" selected="selected">List</option>';
      echo '  <option value="1">3 columns</option>';
	  echo '  <option value="2">2 columns</option>';
	  echo '  <option value="3">Portfolio Gallery</option>';
	  echo '  <option value="4">Carousel</option>';
	  echo '  <option value="5">Sortable Portfolio</option>';
	}
    echo '</select>';
    echo '</p>';
	
	echo '<h5>Short Info Options:</h5>';
	$rad_1="";$rad_2="";
	if($this->ShortInfo=="sect") {$rad_1 = 'checked="checked"';} else {$rad_2 = 'checked="checked"';}
	echo '<input type="radio" name="ShortInfo" value="sect" '.$rad_1.'>From section short_info class<br>';
	echo '<input type="radio" name="ShortInfo" value="abrev" '.$rad_2.'>From content Abbreviation Length =';
	 
	 echo '<input type="text" name="AbbrevL" value="'.$this->AbbrevL .'" class="gpinput" style="width:200px" />';
	echo '</div>';	


	
//List layout panel
	echo '<div id="EC_panel2" class="EC_panel">';
	echo '<h5>List Layout Options:</h5>';
	echo '<p>Items per page</br>';
    echo '<input type="text" name="item_per_pageL" value="'.$this->item_per_pageL .'" class="gpinput" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSortingL  ){
	echo '<input type="checkbox" name="ShowSortingL" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSortingL" value="true" />';
		}


	echo '<h5>Image Options:</h5>';
	
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
    echo '<input type="text" name="ImagesizeWL" value="'.$this->ImagesizeWL .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ImagesizeHL" value="'.$this->ImagesizeHL .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
			
		
		
	echo '<p class="tooltip" data-tooltip="Type pages names(labels) separeted by coma, to have this layout( if it not set by default)">Pages with Lines layout:</br> ';
	echo '<textarea rows="5" cols="45" name="LinesPages" >'.$this->LinesPages.' </textarea>';
	echo '</p>';
		
	echo '</div>';
	
	
	
//3 columns layout panel
	echo '<div id="EC_panel4" class="EC_panel">';
	echo '<h5>3 columns Layout Options:</h5>';
	echo '<p>Items per page</br>';
    echo '<input type="text" name="item_per_page3c" value="'.$this->item_per_page3c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSorting3c  ){
	echo '<input type="checkbox" name="ShowSorting3c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSorting3c" value="true" />';
		}


	echo '<h5>Image Options:</h5>';
	
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
	
	echo '<div style="display:none;">';
	echo '<p>Width(px) ';
    echo '<input type="text" name="ImagesizeW3c" value="'.$this->ImagesizeW3c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '</div>';
	
	echo '<p>Max-height image(px) ';
    echo '<input type="text" name="ImagesizeH3c" value="'.$this->ImagesizeH3c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
		
	
	
	echo '<p class="tooltip" data-tooltip="Type pages names(labels) separeted by coma, to have this layout( if it not set by default)">Pages with 3 columns layout:</br> ';
	echo '<textarea rows="5" cols="45" name="column3Pages">'.$this->column3Pages.' </textarea>';
	echo '</p>';
	echo '</div>';	

	
//2 columns layout panel
	echo '<div id="EC_panel3" class="EC_panel">';
	echo '<h5>2 columns Layout Options:</h5>';
	echo '<p>Items per page</br>';
    echo '<input type="text" name="item_per_page2c" value="'.$this->item_per_page2c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
	
	echo '<p>Show sorting buttons?  ';
	if( $this->ShowSorting2c  ){
	echo '<input type="checkbox" name="ShowSorting2c" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowSorting2c" value="true" />';
		}


	echo '<h5>Image Options:</h5>';
	
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
    echo '<input type="text" name="ImagesizeW2c" value="'.$this->ImagesizeW2c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ImagesizeH2c" value="'.$this->ImagesizeH2c .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
			
	
		
	echo '<p class="tooltip" data-tooltip="Type pages names(labels) separeted by coma, to have this layout( if it not set by default)">Pages with 2 columns layout:</br> ';
	echo '<textarea rows="5" cols="45" name="column2Pages">'.$this->column2Pages.'</textarea>';
	echo '</p>';
	echo '</div>';	 



//Portfolio Gallery panel
	echo '<div id="EC_panel5" class="EC_panel">';	 
	echo '<h5>Portfolio Gallery  Layout Options:</h5>';
	echo '<p>Number of columns<br>';
    echo '<input type="text" name="ECPColumns" value="'.$this->ECPColumns .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height of expandable info (px)<br>';
    echo '<input type="text" name="ECPMinHeight" value="'.$this->ECPMinHeight .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p class="tooltip" data-tooltip="Type pages names(labels) separeted by coma, to have this layout( if it not set by default)">Pages with Portfolio Gallery layout:</br> ';
	echo '<textarea rows="5" cols="45" name="PGPages">'.$this->PGPages.'</textarea>';
	echo '</p>';
	echo '</div>';		 


//Carousel panel
	echo '<div id="EC_panel6" class="EC_panel">';	 
	echo '<h5>Carousel  Layout Options:</h5>';
	
	echo '<p>Show title?  ';
	if( $this->ShowTitlecar  ){
	echo '<input type="checkbox" name="ShowTitlecar" value="true" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ShowTitlecar" value="true" />';
		}
	
	echo '<h5>Image Options:</h5>';
	
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
    echo '<input type="text" name="ImagesizeWcar" value="'.$this->ImagesizeWcar .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ImagesizeHcar" value="'.$this->ImagesizeHcar .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
	echo '<p>Number of items in row<br>';
	echo '<input type="text" name="ECrow" value="'.$this->ECrow .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p class="tooltip" data-tooltip="Use it when your items have diferent height(to avoid arrows bouncing)" >Height of carousel (px)<br>';
    echo '<input type="text" name="ECheight" value="'.$this->ECheight .'" class="gpinput" style="width:200px" />';
    echo '</p>'; 
	
	echo '<p class="tooltip" data-tooltip="Type pages names(labels) separeted by coma, to have this layout( if it not set by default)">Pages with Carousel layout:</br> ';
	echo '<textarea rows="5" cols="45" name="CarPages">'.$this->CarPages.'</textarea>';
	echo '</p>';
	
	echo '</div>';		

//Sortable Portfolio panel	
		echo '<div id="EC_panel7" class="EC_panel">';	 
		echo '<h5>Sortable Portfolio  Layout Options:</h5>';
	
		echo '<p>Show title?  ';
		if( $this->Showtitle  ){
		echo '<input type="checkbox" name="Showtitle" value="true" checked="checked" />';
		}else{
		echo '<input type="checkbox" name="Showtitle" value="true" />';
		}
		
		echo '<p>Width of portfoliio item (%)<br>';
		echo '<input type="text" name="ItemW" value="'.$this->ItemW.'" class="gpinput" style="width:200px" />';
		echo '</p>';
		
		echo '<h5>Image Options:</h5>';
		echo '<p>Image is linked to:</br>';
		echo '<select name="imagelinked">';
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
		echo '<div><input type="text" name="datafilter[]"></div>';
		}else{
		$pieces = explode(",", $this->datafilter);
		 for($i = 0; $i < count($pieces); $i++) {
		echo '<div><input type="text" value="'.$pieces[$i].'"name="datafilter[]"/><a href="#" class="remove_field"><img src="'.$addonRelativeCode.'/img/delete.png'.'" border="0" /></a></div>';
		}
		  }
		echo '</div>';
	
		echo '</div>';	

echo '</div>';

//special option panel
echo '<div id="EC_panel8" class="EC_panel">';
echo '<p>Use this, if you want to placed gadget on page, that do not have direct child pages</p>';
echo '<p>Type page name(label), to enable this option on it ';
    echo '<input type="text" id="anotherpage" name="anotherpage" value="'.$this->anotherpage .'" class="gpinput" style="width:200px" />';
    echo '</p>';
echo '<p>Here type page name(label) that have direct child pages. Direct childs from this page will be used as catalog items. ';
    echo '<input type="text" id="netpage" name="netpage" value="'.$this->netpage .'" class="gpinput" style="width:200px" />';
    echo '</p>';	
	
	echo '<hr>';
	echo '<p>Use EasyCatalog generated thumbnails for images?  ';
	if( $this->ECthumb  ){
	echo '<input type="checkbox" name="ECthumb" value="yes" checked="checked" />';
		}else{
	echo '<input type="checkbox" name="ECthumb" value="yes" />';
		}
	  echo '</p>';
	
	echo 'Thumbnail size:';
	echo '<p>Width(px) ';
    echo '<input type="text" name="ECthumbW" value="'.$this->ECthumbW .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	echo '<p>Height(px) ';
    echo '<input type="text" name="ECthumbH" value="'.$this->ECthumbH .'" class="gpinput" style="width:200px" />';
    echo '</p>';
	
	
	echo '<input type="button" onClick="location.href=\'' . common::GetUrl('Admin_Catalog_Easy') . '?cmd=del_thumbs\'" name="cmd" ';
    echo 'value="Delete generated thumbnails" class="admin_box_close gpcancel" />';
	
	
	
	
echo '</div>';

	
echo '<hr>';
	
    echo '<input type="hidden" name="cmd" value="saveConfig" />';

    echo '<input type="submit" value="'.$langmessage['save_changes'].'" class="gpsubmit"/>';
    echo '</p>';
    echo '</form>';
	
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
    
	$config['item_per_page']  	= $_POST['item_per_page'];
    $config['catalog_layout'] 	= $_POST['catalog_layout'];
	$config['ImagesizeW'] 		= $_POST['ImagesizeW'];
	$config['ImagesizeH'] 		= $_POST['ImagesizeH'];
	$config['LinesPages']		= $_POST['LinesPages'];
    $config['column3Pages']		= $_POST['column3Pages'];
	$config['column2Pages']		= $_POST['column2Pages'];
	$config['PGPages']			= $_POST['PGPages'];
	$config['ECPColumns']		= $_POST['ECPColumns'];
	$config['ECPMinHeight']		= $_POST['ECPMinHeight'];
	$config['ECrow']			= $_POST['ECrow'];	
	$config['ECheight']			= $_POST['ECheight'];
	$config['ShortInfo']		= $_POST['ShortInfo'];
	$config['AbbrevL']			= $_POST['AbbrevL'];
	
	//list
	$config['item_per_pageL']	= $_POST['item_per_pageL'];
	$config['ImagesizeWL'] 		= $_POST['ImagesizeWL'];
	$config['ImagesizeHL'] 		= $_POST['ImagesizeHL'];
	$config['ShowImageL']		= $_POST['ShowImageL'];
	
	
	$config['ShowSortingL']		= $_POST['ShowSortingL'];
	$config['ImageCircleL']		= $_POST['ImageCircleL'];
	
	//3c
	$config['item_per_page3c']	= $_POST['item_per_page3c'];
	$config['ImagesizeW3c'] 	= $_POST['ImagesizeW3c'];
	$config['ImagesizeH3c'] 	= $_POST['ImagesizeH3c'];
	$config['ShowImage3c']		= $_POST['ShowImage3c'];
	$config['ShowSorting3c']	= $_POST['ShowSorting3c'];
	$config['ImageCircle3c']	= $_POST['ImageCircle3c'];
	
	//2c
	$config['item_per_page2c']	= $_POST['item_per_page2c'];
	$config['ImagesizeW2c'] 	= $_POST['ImagesizeW2c'];
	$config['ImagesizeH2c'] 	= $_POST['ImagesizeH2c'];
	$config['ShowImage2c']		= $_POST['ShowImage2c'];
	$config['ShowSorting2c']	= $_POST['ShowSorting2c'];
	$config['ImageCircle2c']	= $_POST['ImageCircle2c'];
	
	 //carousel
	$config['ImagesizeWcar'] 	= $_POST['ImagesizeWcar'];
	$config['ImagesizeHcar'] 	= $_POST['ImagesizeHcar'];
	$config['ShowImagecar']		= $_POST['ShowImagecar'];
	$config['ImageCirclecar']	= $_POST['ImageCirclecar'];
	$config['CarPages']			= $_POST['CarPages'];
	$config['ShowTitlecar']		= $_POST['ShowTitlecar'];

	
	if($_POST){
	$_POST["datafilter"] = array_diff($_POST["datafilter"], array(''));
	$config['datafilter'] = implode(",", $_POST["datafilter"]);
	
		}
	$config['imagelinked']		= $_POST['imagelinked'];
	$config['Showtitle']		= $_POST['Showtitle'];
	$config['ItemW']			= $_POST['ItemW'];
	
	//special
	$config['anotherpage']		= $_POST['anotherpage'];
	$config['netpage']			= $_POST['netpage'];
	$config['ECthumb']			= $_POST['ECthumb'];
	$config['ECthumbH']			= $_POST['ECthumbH'];
	$config['ECthumbW']			= $_POST['ECthumbW'];
	
	
	$this->item_per_page        = $config['item_per_page'];
    $this->catalog_layout 		= $config['catalog_layout'];
	$this->ImagesizeW 			= $config['ImagesizeW'];
	$this->ImagesizeH 			= $config['ImagesizeH'];
	$this->LinesPages			= $config['LinesPages'];
	$this->column3Pages			= $config['column3Pages'];
	$this->column2Pages			= $config['column2Pages'];
	$this->PGPages				= $config['PGPages'];
	$this->ECPColumns			= $config['ECPColumns'];
	$this->ECPMinHeight			= $config['ECPMinHeight'];
	$this->ECrow				= $config['ECrow'];	
	$this->ECheight 			= $config['ECheight'];	
	$this->ShortInfo 			= $config['ShortInfo'];	
	$this->AbbrevL 				= $config['AbbrevL'];	
	
	//list specify		
	$this->item_per_pageL		= $config['item_per_pageL'];
	$this->ImagesizeWL 			= $config['ImagesizeWL'];
	$this->ImagesizeHL 			= $config['ImagesizeHL'];
	$this->ImageCircleL 		= $config['ImageCircleL'];
	$this->ShowImageL			= $config['ShowImageL'];
	$this->ShowSortingL			= $config['ShowSortingL'];	
	
	 //3c specify
	 $this->item_per_page3c		= $config['item_per_page3c'];
	 $this->ImagesizeW3c 	 	= $config['ImagesizeW3c'];
	 $this->ImagesizeH3c 		= $config['ImagesizeH3c'];
	 $this->ImageCircle3c 		= $config['ImageCircle3c'];
	 $this->ShowImage3c	 		= $config['ShowImage3c'];
	 $this->ShowSorting3c		= $config['ShowSorting3c'];
	
	//2c specify
	 $this->item_per_page2c 	= $config['item_per_page2c'];
	 $this->ImagesizeW2c 		= $config['ImagesizeW2c'];
	 $this->ImagesizeH2c 		= $config['ImagesizeH2c'];
	 $this->ImageCircle2c 		= $config['ImageCircle2c'];
	 $this->ShowImage2c		 	= $config['ShowImage2c'];
	 $this->ShowSorting2c		= $config['ShowSorting2c'];
	 
	  //carousel
	  $this->ImagesizeWcar	 	= $config['ImagesizeWcar'];
	  $this->ImagesizeHcar 	 	= $config['ImagesizeHcar'];
	  $this->ImageCirclecar  	= $config['ImageCirclecar'];
	  $this->ShowImagecar	 	= $config['ShowImagecar'];
	  $this->CarPages			= $config['CarPages'];
	  $this->ShowTitlecar	 	= $config['ShowTitlecar'];
	  
	  $this->datafilter	 		= $config['datafilter'];
	  $this->imagelinked		= $config['imagelinked'];
	  $this->Showtitle 			= $config['Showtitle'];
	  $this->ItemW				= $config['ItemW'];
	  
	  //special
	  $this->anotherpage		= $config['anotherpage'];
	  $this->netpage			= $config['netpage'];
	  $this->ECthumb			= $config['ECthumb'];
	  $this->ECthumbH			= $config['ECthumbH'];
	  $this->ECthumbW			= $config['ECthumbW'];
	
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
      $this->item_per_page  = $config['item_per_page'];
      $this->catalog_layout = $config['catalog_layout'];
	  $this->ImagesizeW 	= $config['ImagesizeW'];
	  $this->ImagesizeH 	= $config['ImagesizeH'];
	  $this->LinesPages		= $config['LinesPages'];
	  $this->column3Pages	= $config['column3Pages'];
	  $this->column2Pages	= $config['column2Pages'];
	  $this->PGPages		= $config['PGPages'];
	  $this->ECPColumns		= $config['ECPColumns'];
      $this->ECPMinHeight	= $config['ECPMinHeight'];
	  $this->ECrow			= $config['ECrow'];
	  $this->ECheight 		= $config['ECheight'];
	  $this->ShortInfo 		= $config['ShortInfo'];	
	  $this->AbbrevL 		= $config['AbbrevL'];	
	  
	  //list specify
	  $this->item_per_pageL	= $config['item_per_pageL'];
	  $this->ImagesizeWL 	= $config['ImagesizeWL'];
	  $this->ImagesizeHL 	= $config['ImagesizeHL'];
	  $this->ImageCircleL 	= $config['ImageCircleL'];
	  $this->ShowImageL		= $config['ShowImageL'];
	  $this->ShowSortingL	= $config['ShowSortingL'];
	  
	  //3c specify
	  $this->item_per_page3c = $config['item_per_page3c'];
	  $this->ImagesizeW3c 	 = $config['ImagesizeW3c'];
	  $this->ImagesizeH3c 	 = $config['ImagesizeH3c'];
	  $this->ImageCircle3c 	 = $config['ImageCircle3c'];
	  $this->ShowImage3c	 = $config['ShowImage3c'];
	  $this->ShowSorting3c	 = $config['ShowSorting3c'];
	  
	   //2c specify
	  $this->item_per_page2c = $config['item_per_page2c'];
	  $this->ImagesizeW2c 	 = $config['ImagesizeW2c'];
	  $this->ImagesizeH2c 	 = $config['ImagesizeH2c'];
	  $this->ImageCircle2c 	 = $config['ImageCircle2c'];
	  $this->ShowImage2c	 = $config['ShowImage2c'];
	  $this->ShowSorting2c	 = $config['ShowSorting2c'];
	  
	  //carousel
	  $this->ImagesizeWcar 	 = $config['ImagesizeWcar'];
	  $this->ImagesizeHcar 	 = $config['ImagesizeHcar'];
	  $this->ImageCirclecar  = $config['ImageCirclecar'];
	  $this->ShowImagecar	 = $config['ShowImagecar'];
	  $this->CarPages		 = $config['CarPages'];
	  $this->ShowTitlecar	 = $config['ShowTitlecar'];
	  
	  
	  $this->datafilter		 = $config['datafilter'];
	  $this->imagelinked	 = $config['imagelinked'];
	  $this->Showtitle 		 = $config['Showtitle'];
	  $this->ItemW			 = $config['ItemW'];
	  
	  //spec
	  $this->anotherpage		= $config['anotherpage'];
	  $this->netpage			= $config['netpage'];
	  $this->ECthumb			= $config['ECthumb'];
	  $this->ECthumbH			= $config['ECthumbH'];
	  $this->ECthumbW			= $config['ECthumbW'];
	  
    }
  }
}

?>



