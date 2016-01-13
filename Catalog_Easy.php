<?php
/*
PHP script for Catalog Easy gpEasy Plugin
Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.7
*/
defined('is_running') or die('Not an entry point...');
includeFile('tool/SectionContent.php');
session_start();


class Catalog_Easy
{
    
    public $catalog_layout;
    public $ShowImage;
    public $ImagesizeW;
    public $ImagesizeH;
    public $ImageCircle;
    public $LinesPages;
    public $column3Pages;
    public $column2Pages;
    public $PGPages;
    public $CarPages;
    public $ECrow;
    public $ECheight;
    public $item_per_page;
    public $item_per_pageL;
    public $item_per_page2c;
    public $item_per_page3c;
    public $datafilter;
    public $imagelinked;
    public $Showtitle;
    public $ItemW;
    public $ECthumb;
    
    public function __construct()
    {
        
        
        global $addonRelativeCode, $addonPathData, $ECPColumns, $ECPMinHeight;
        $configFile = $addonPathData . '/config.php';
        if (!file_exists($configFile)) {
            $this->getDefaultConfig();
        }
        
        if (file_exists($configFile)) {
            include $configFile;
        }
        
        if (!isset($config)) {
            $this->getDefaultConfig();
            
        } else {
            
            //$this->item_per_page		= $config['item_per_page'];
            $this->catalog_layout = $config['catalog_layout'];
            //$this->ShowImage			= $config['ShowImage'];
            //$this->ShowSorting		= $config['ShowSorting'];
            $this->ImagesizeW     = $config['ImagesizeW'];
            $this->ImagesizeH     = $config['ImagesizeH'];
            //$this->ImageCircle		= $config['ImageCircle'];
            $this->LinesPages     = $config['LinesPages'];
            $this->column3Pages   = $config['column3Pages'];
            $this->column2Pages   = $config['column2Pages'];
            $this->PGPages        = $config['PGPages'];
            $ECPColumns           = $config['ECPColumns'];
            $ECPMinHeight         = $config['ECPMinHeight'];
            $this->ECrow          = $config['ECrow'];
            $this->ECheight       = $config['ECheight'];
			$this->ShortInfo 	  = $config['ShortInfo'];	
			$this->AbbrevL 		  = $config['AbbrevL'];
            
            //list 		
            $this->item_per_pageL = $config['item_per_pageL'];
            $this->ImagesizeWL    = $config['ImagesizeWL'];
            $this->ImagesizeHL    = $config['ImagesizeHL'];
            $this->ImageCircleL   = $config['ImageCircleL'];
            $this->ShowImageL     = $config['ShowImageL'];
            $this->ShowSortingL   = $config['ShowSortingL'];
            
            //3c 
            $this->item_per_page3c = $config['item_per_page3c'];
            $this->ImagesizeW3c    = $config['ImagesizeW3c'];
            $this->ImagesizeH3c    = $config['ImagesizeH3c'];
            $this->ImageCircle3c   = $config['ImageCircle3c'];
            $this->ShowImage3c     = $config['ShowImage3c'];
            $this->ShowSorting3c   = $config['ShowSorting3c'];
            
            //2c 
            $this->item_per_page2c = $config['item_per_page2c'];
            $this->ImagesizeW2c    = $config['ImagesizeW2c'];
            $this->ImagesizeH2c    = $config['ImagesizeH2c'];
            $this->ImageCircle2c   = $config['ImageCircle2c'];
            $this->ShowImage2c     = $config['ShowImage2c'];
            $this->ShowSorting2c   = $config['ShowSorting2c'];
            
            //carousel
            $this->ImagesizeWcar  = $config['ImagesizeWcar'];
            $this->ImagesizeHcar  = $config['ImagesizeHcar'];
            $this->ImageCirclecar = $config['ImageCirclecar'];
            $this->ShowImagecar   = $config['ShowImagecar'];
            $this->CarPages       = $config['CarPages'];
            $this->ShowTitlecar	  = $config['ShowTitlecar'];
			
            
            $this->datafilter  = $config['datafilter'];
            $this->imagelinked = $config['imagelinked'];
            $this->Showtitle   = $config['Showtitle'];
            $this->ItemW       = $config['ItemW'];
            
            //spec
            $this->anotherpage = $config['anotherpage'];
            $this->netpage     = $config['netpage'];
            $this->ECthumb     = $config['ECthumb'];
			$this->ECthumbH	   = $config['ECthumbH'];
			$this->ECthumbW	   = $config['ECthumbW'];
            
        }
        
        
        global $page;
			
        if (mb_strtolower($page->label) == mb_strtolower($this->anotherpage)) {
            
            if (isset($this->netpage)) {
                
                $title = $this->getChildpagefromLabel($this->netpage);
                
            } else {
                
                $title = $this->getChildpages();
                
            }
            
        } else {
            $title = $this->getChildpages();
        }
        
        
        if (isset($_REQUEST["pag"])) {
            
            $page_number = filter_var($_REQUEST["pag"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
            
            if (!is_numeric($page_number)) {
                die('Invalid page number!');
            }
            
        } else {
            $page_number = 1;
        }
        
        $pages_count = count($title);
        
        $this->Check_layout();
        $this->Check_options();
        
        
        if (isset($_REQUEST["sort"])) {
            
            $_SESSION["sort"] = $_REQUEST['sort'];
            
        }
        
        if ($this->getUrl() <> $_SERVER['HTTP_REFERER']) {
            unset($_SESSION["sort"]);
        }
        
        if (isset($_SESSION["sort"])) {
            
            $sort = $_SESSION["sort"];
            if ($sort == "asc") {
                sort($title);
            }
            if ($sort == "desc") {
                rsort($title);
            }
            
        }
        
        if ($this->catalog_layout == 3 or $this->catalog_layout == 4 or $this->catalog_layout == 5) {
            $this->item_per_page = 99999;
        }
        if ($this->catalog_layout == 3 or $this->catalog_layout == 5) {
            $this->ShowImage = "true";
        }
        
        $total_pages = ceil($pages_count / $this->item_per_page);
        
        $page_position = (($page_number - 1) * $this->item_per_page);
        
        if (isset($title)) {
            $whatweshow = array_slice($title, $page_position, $this->item_per_page);
            
        
            $items = $this->getContent($whatweshow);
            
            
            echo '<div class="loading-div"><img src="' . $addonRelativeCode . '/ajax-loader.gif" ></div>';
            echo '<div id="results">';
            
            
            if ($this->ShowSorting and $this->catalog_layout <> 3 and $this->catalog_layout <> 4) {
                echo '<div id="EC_sort"><ul class="sort"><li class="first" data-sort="asc"><img src="' . $addonRelativeCode . '/img/sort_down.png' . '" border="0" /></li><li class="last" data-sort="desc"><img src="' . $addonRelativeCode . '/img/sort_up.png' . '" border="0" /></li></ul></div>';
                echo '<div class="point"></div>';
                
                
            }
            
            
            $this->ShowCatalog($items);
            
            echo '<div id="clicker" align="center">';
            echo $this->paginate_function($this->item_per_page, $page_number, $pages_count, $total_pages);
            echo '</div>';
            echo '</div>';
        }
        
    }
    
    
    function getChildpagefromLabel($labelset)
    {
        
        global $page, $gp_index, $gp_menu, $dirPrefix, $gp_titles;
        
        
        $index      = $this->array_find_deep($gp_titles, $labelset);
        $page_index = $index[0];
        
        if (!isset($gp_menu[$index[0]])) {
            return;
        }
        $titles = common::Descendants($page_index, $gp_menu);
        $level  = $gp_menu[$page_index]['level'];
        
        
        
        foreach ($titles as $index) {
            
            $child_level = $gp_menu[$index]['level'];
            if ($child_level != $level + 1) {
                continue;
            }
            
            $title[] = array_search($index, $gp_index);
            
            if (!$title) {
                continue;
            }
            
        }
        
        if (!isset($title)) {
            return;
        }
        
        
        return $title;
        
        
    }
    
    function array_find_deep($array, $search, $keys = array())
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $sub = $this->array_find_deep($value, $search, array_merge($keys, array(
                    $key
                )));
                if (count($sub)) {
                    return $sub;
                }
            } elseif ($value === $search) {
                return array_merge($keys, array(
                    $key
                ));
            }
        }
        
        return array();
    }
    
    
    function getChildpages()
    {
        global $page, $gp_index, $gp_menu, $dirPrefix;
        
        if (!isset($gp_menu[$page->gp_index])) {
            return;
        }
        
        $titles = common::Descendants($page->gp_index, $gp_menu);
        $level  = $gp_menu[$page->gp_index]['level'];
        
        
        
        foreach ($titles as $index) {
            
            $child_level = $gp_menu[$index]['level'];
            if ($child_level != $level + 1) {
                continue;
            }
            
            $title[] = array_search($index, $gp_index);
            
            if (!$title) {
                continue;
            }
            
        }
        
        if (!isset($title)) {
            return;
        }
        
        
        return $title;
        
    }
    
    
    
    function getContent($titles)
    {
        global $addonRelativeCode;
        foreach ($titles as $title) {
            $label                     = common::GetLabel($title);
            $items[$label]['link']     = common::Link($title, $label);
            $items[$label]['label']    = $label;
			$items[$label]['url']	   = common::GetUrl($title);
            $readmore                  = '<img src="' . $addonRelativeCode . '/more.png' . '" border="0" />';
            $items[$label]['readmore'] = common::Link($title, $readmore);
            list($items[$label]['image'], $items[$label]['short_info'], $items[$label]['datafilter']) = $this->getImageandInfo($title);
            
        }
        
        return $items;
        
    }
    
    
    
    function getImageandInfo($title)
    {
        global $dirPrefix;
        $file = gpFiles::PageFile($title);
        
        //check if page not special!
        if (!file_exists($file)) {
            return;
        }
        
        $file_sections = $file_stats = array();
        ob_start();
        include($file);
        ob_get_clean();
        
        if (!is_array($file_sections)) {
            return;
        }
        
        //avoid error- maximum function nesting level of '250' reached
        foreach ($file_sections as $key => $val) {
            if ($val['type'] == 'include')
                unset($file_sections[$key]);
        }
        
        
        if (!$file_sections) {
            return;
        }
        
        $file_sections = array_values($file_sections);
        
        //get short info and datafilter
        
        foreach ($file_sections as $sect) {
            
            
            if (isset($sect['attributes'])) {
                
                if (isset($sect['attributes']['class'])) {
                    
                    //if ($sect['attributes']['class'] == "short_info"){
                    if (strpos($sect['attributes']['class'], 'short_info') !== false) {
                        $short_info = $sect['content'];
                    }
                }
                
            }
            
            if (isset($sect['attributes']['data-filter'])) {
                
                $datafilter = $sect['attributes']['data-filter'];
                
            }
            
            
        }
        
        if (!isset($datafilter)) {
            $datafilter = "";
        }
        if (!isset($short_info)) {
            $short_info = "";
        }
        
        
        
        //get the image + check abrev
        $content = section_content::Render($file_sections, $title, $file_stats);
		   
		   if ($this->ShortInfo == "abrev") {
				
				$short_info = $this->GetAbrev($content,$title,$this->AbbrevL);
				
			}

	   $img_pos = strpos($content, '<img');
        if ($img_pos === false) {
             return array('',$short_info,$datafilter);
        }
        $src_pos = strpos($content, 'src=', $img_pos);
        if ($src_pos === false) {
            return array('',$short_info,$datafilter);
        }
        $src   = substr($content, $src_pos + 4);
        $quote = $src[0];
        if ($quote != '"' && $quote != "'") {
            return array('',$short_info,$datafilter);
        }
        $src_pos = strpos($src, $quote, 1);
        $src     = substr($src, 1, $src_pos - 1);
        
        //$thumb_path = common::ThumbnailPath($src);
        
        $img_pos2 = strpos($content, '>', $img_pos);
        $img      = substr($content, $img_pos, $img_pos2 - $img_pos + 1);
        
	    
		
		
		 


		 
        if ($this->ImageCircle) {
            $a = "img-circle";
        } else {
            $a = "";
        }
       
	  
	  if($this->catalog_layout == 1 ){
		  
		$style = 'max-height:' . $this->ImagesizeH . 'px!important;';  
		
	  } else{
		  
		$style = 'width:' . $this->ImagesizeW . 'px!important; height:' . $this->ImagesizeH . 'px!important;';  
	  }
	  
	  
	   
	 
	 
	 if ($this->ECthumb) {
			
			$style = "";
						
            $image_real = $this->GetRealImage($src);
            
          
			//get source of resized image
			if ($image_real=="resized_img"){
						   
				foreach ($file_sections as $sect) {
				
					if ($sect['type'] == 'image'){
					
					$image_real=$sect['orig_src'];
					
					break;
					
					}
					   
				}
			}

			
			$catalog_thumb = $this->MakeCatalogThumbhail($image_real);
         
			$src = $catalog_thumb;
       
	   
	   }
	   
	   
	  
	   
	   
	   
	   
	   if ($this->ShowImage) {
            if ($this->catalog_layout == 5 and $this->imagelinked == 1) {
               
			   $show  = '<img class="img-responsive thumbnail ' . $a . '" style="' . $style . '" src="' . $src . '"/>';
                
				if ($this->ECthumb) {$src = $image_real;}
				
				$label = common::GetLabel($title);
               //$show = common::Link($src,$show,'','name="gallery" rel="nofollow" title="'.$label.'"');
               // $show  = common::Link($src, $show, '', 'class="EC_img" title="' . $label . '"');
                $show = '<a name="gallery" rel="EC_pf" title="'.$label.'" href="'.$src.'">'.$show.'</a>';

				
            } else {
                $show = '<img class="img-responsive thumbnail ' . $a . '" style="' . $style . '" src="' . $src . '"/>';
                $show = common::Link($title, $show);
            }
            
        } else {
            $show = "";
        }
        
		
        
        
        
        return array($show,$short_info,$datafilter);
        
    }
    
	
    function GetAbrev($content, $title, $abrv = 100 ) {
		
		$label=common::GetLabel($title);
		
		$content = strip_tags($content);
		$var = 1;
		
		$content = str_replace($label,"",$content,$var) ;
		
		if( mb_strlen($content) < $abrv ){
			return $content;
		}
	
		$pos = mb_strpos($content,' ',$abrv-5);

		if( ($pos > 0) && ($abrv+20 > $pos) ){
			$abrv = $pos;
		}
		$content = mb_substr($content,0,$abrv);
	 
	
		return $content."...";
	}
    
	
    function GetRealImage($src)
    {
        
        $dir_part_main = '/data/_uploaded';
        $dir_part      = 'image.php';
        $pos           = strpos($src, $dir_part);
        
        if ((bool) $pos === true) {
            
            $srec_new = strstr($src, 'img=');
            
            $srec_new = substr($srec_new, 4);
            
           // $srec_new = str_replace('%2F', '/', $srec_new);
		   $srec_new = urldecode($srec_new); 
            
            $srec_new = $dir_part_main . $srec_new;
           		   
            return $srec_new;
        }
        
        $dir_part2 = 'thumbnails/image';
        
        $pos2 = strpos($src, $dir_part2);
        
        if ((bool) $pos2 === true) {
            
            $srec_new = substr($src, 0, strrpos($src, '.jpg'));
            
            $srec_new = str_replace("thumbnails/image/", "", $srec_new);
            
            return $srec_new;
            
        }
        
        $dir_part3 = "resized";
        
        $pos3 = strpos($src, $dir_part3);
        
        if ((bool) $pos3 === true) {
            
       				
          $srec_new = "resized_img";
			
            return $srec_new;
        }
        
        
        $srec_new = $src;
        
        
        
        return $srec_new;
        
    }
    
    
    
    function MakeCatalogThumbhail($file)
    {
        
        global $dataDir;
        
        $dir = 'data/_uploaded/image/thumbnails/easy_catalog';
        if (!file_exists($dir) && !is_dir($dir)) {
            mkdir($dir);
        }
        
        $test = $this->jpegImgCrop($dataDir . $file);
        
        return $test;
        
        
    }
    
    
    
    function jpegImgCrop($target_url)
    {
        
        global $dataDir;
        $img_name = str_replace($dataDir . "/data/_uploaded/image/", "", $target_url);
        $parts    = explode("/", $img_name);
        $img_name = array_pop($parts);
        $newname  = $img_name;
        foreach ($parts as $part) {
            $newname = $part . "_" . $newname;
        }
		
		$parts = explode('.',$newname);
		$type = array_pop($parts);
		$newname = $parts[0] . $this->ECthumbW . $this->ECthumbH . '.' . $type;
		//$newname = $newname . $this->ImagesizeW . $this->ImagesizeH;
		
        $thumb_scr = 'data/_uploaded/image/thumbnails/easy_catalog/' . $newname;
        
        if (file_exists($thumb_scr)) {
            return "/".$thumb_scr;
        }
        
        
        $image      = imagecreatefromjpeg($target_url);
        $filename   = $target_url;
        $width      = imagesx($image);
        $height     = imagesy($image);
    //    $image_type = imagetypes($image); //IMG_GIF | IMG_JPG | IMG_PNG | IMG_WBMP | IMG_XPM
        
        $thumb_width  = $this->ECthumbW;
        $thumb_height = $this->ECthumbH;
        
        
        $original_aspect = $width / $height;
        $thumb_aspect    = $thumb_width / $thumb_height;
        
        if ($original_aspect >= $thumb_aspect) {
            
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width  = $width / ($height / $thumb_height);
            
        } else {
            // If the thumbnail is wider than the image
            $new_width  = $thumb_width;
            $new_height = $height / ($width / $thumb_width);
        }
        
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        
        // Resize and crop
        imagecopyresampled($thumb, $image, 0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
            0 - ($new_height - $thumb_height) / 2, // Center the image vertically
            0, 0, $new_width, $new_height, $width, $height);
        // imagejpeg($thumb, $filename, 80);
        imagejpeg($thumb, 'data/_uploaded/image/thumbnails/easy_catalog/' . $newname, 80);
        
        $thumb_scr = '/data/_uploaded/image/thumbnails/easy_catalog/' . $newname;
        return $thumb_scr;
        
    }
    
    
    
    
    
    
    
    function ShowCatalog($items)
    {
        
        if ($this->catalog_layout == 1) {
            
            $this->ShowLayout3Column($items);
            
        } elseif ($this->catalog_layout == 2) {
            
            $this->ShowLayout2Column($items);
            
        } elseif ($this->catalog_layout == 3) {
            
            $this->ShowLayoutPortfolioGallery($items);
            
        } elseif ($this->catalog_layout == 4) {
            
            $this->ShowLayoutCarousel($items);
            
        } elseif ($this->catalog_layout == 5) {
            
            $this->ShowLayoutSortablePF($items);
            
        } else {
            
            echo '<div class="container" style="width:100%;">';
            
            foreach ($items as $item) {
                echo '<div class="row">';
                echo '<div class="col-md-12 list">';
                echo '<div class="img-list">' . $item['image'] . '</div>';
                echo '<div class="listshortinfo"><h3>' . $item['link'] . '</h3>' . $item['short_info'] . '</div>';
                echo '<div class="readmore_EC">' . $item['readmore'] . '</div>';
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            
            
            
        }
        return;
        
    }
    
    
    
    function ShowLayout3Column($items)
    {
        
        echo '<div class="container" style="width:100%;">';
        foreach ($items as $item) {
            echo '<div class="column">';
            echo '<h3>' . $item['link'] . '</h3>';
            echo $item['image'];
            echo '<div class="shortinfo">' . $item['short_info'] . '</div>';
            echo '<div class="readmore_EC">' . $item['readmore'] . '</div>';
            
            echo '</div>';
            
        }
        echo '</div>';
        
        
    }
    
    
    
    function ShowLayout2Column($items)
    {
        
        echo '<div class="container" style="width:100%;">';
        foreach ($items as $item) {
            echo '<div class="column2">';
            echo '<h3>' . $item['link'] . '</h3>';
            echo $item['image'];
            echo '<div class="shortinfo">' . $item['short_info'] . '</div>';
            echo '<div class="readmore_EC">' . $item['readmore'] . '</div>';
            
            echo '</div>';
            
        }
        
        echo '</div>';
        
        
    }
    
    
    
    function ShowLayoutPortfolioGallery($items)
    {
        
        echo '<div class="wmg-container my-grid" style="width:100%;">';
        foreach ($items as $item) {
            
            
            echo '<div class="wmg-item">';
            echo '<div class="wmg-thumbnail">';
            echo '<div class="wmg-thumbnail-content">';
            
            echo $item['image'];
            
            
            echo '</div>';
            echo '<div class="wmg-arrow"></div>';
            echo '</div>';
            echo '<div class="wmg-details">';
            echo '<span class="wmg-close"></span>';
            echo '<div class="wmg-details-content">';
            
            
            echo '<div class="container exemplo" style="width:100%;">';
            echo '<div class="row">';
            
            echo '<div class="col-md-12">';
            echo '<h3>' . $item['link'] . '</h3>';
            echo '<div class="shortinfoPF">' . $item['short_info'] . '</div>';
            
            echo '</div>';
            
            echo '</div>';
            echo '</div>';
            echo '<div class="readmorePF">' . $item['readmore'] . '</div>';
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            
            
            
        }
        
        echo '</div>';
        
        
    }
    
    
    function ShowLayoutCarousel($items)
    {
        global $addonRelativeCode;
        if ($this->ECrow <= 0 or $this->ECrow > 6) {
            $this->ECrow = 4;
            $numcol      = 3;
        }
        
        switch ($this->ECrow) {
            
            case 1:
                $numcol = 12;
                break;
            case 2:
                $numcol = 6;
                break;
            case 3:
                $numcol = 4;
                break;
            case 4:
                $numcol = 3;
                break;
            case 6:
                $numcol = 2;
                break;
            default:
                $numcol      = 3;
                $this->ECrow = 4;
        }
        
        
        echo '<div class="container" style="width:100%;">';
        echo '<div class="row">';
        echo '<div class="col-md-12">';
        echo '<div id="EC_Carousel" class="carousel slide" data-ride="carousel">';
        echo '<div class="carousel-inner" style="height:' . $this->ECheight . 'px">';
        
        $flag = "active";
        
        
        for ($i = 0; $i < count($items); $i++) {
            if ($i % $this->ECrow == 0) {
                echo '<div class="item ' . $flag . '">';
                echo '<div class="row">';
                
            }
            
            if ($flag == "active") {
                $item = current($items);
                $flag = "";
            } else {
                $item = next($items);
            }
            echo '<div class="col-md-' . $numcol . '">';
			
			if($this->ShowTitlecar){ 
				echo '<h3>' . $item['link'] . '</h3>';
				}
          
			echo $item['image'];
            echo '<div class="shortinfo">' . $item['short_info'] . '</div>';
            //echo '<div class="readmore_EC">'.$item['readmore'].'</div>'; 
            echo '</div>';
            
            if (($i + 1) % $this->ECrow == 0 || count($items) == $i + 1) {
                
                echo '</div>';
                echo '</div>';
            }
        }
        
        
        
        
        echo '</div>';
        
        echo '<a role="button" data-slide="prev" href="#EC_Carousel" class="left EC_carousel-control"><img src="' . $addonRelativeCode . '/img/left.png' . '" border="0" /></a>';
        echo '<a role="button" data-slide="next" href="#EC_Carousel" class="right EC_carousel-control"><img src="' . $addonRelativeCode . '/img/right.png' . '" border="0" /></a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    
    
    function ShowLayoutSortablePF($items)
    {
        
        echo '<ul id="filter-list" class="clearfix">';
        
        echo '<li class="filter" data-filter="all">All</li>';
        if (isset($this->datafilter)) {
            $pieces = explode(",", $this->datafilter);
            foreach ($pieces as $piece) {
                echo ' <li class="filter" data-filter="' . $piece . '">' . $piece . '</li>';
            }
        }
        
        echo '</ul>';
        
        echo '<div class="container" style="width:100%;">';
        echo '<ul id="EC_portfolio">';
        foreach ($items as $item) {
            
            echo '<div class="item ' . $item['datafilter'] . '" style="width: ' . $this->ItemW . '%;">';
            if ($this->Showtitle) {
                echo '<h3>' . $item['link'] . '</h3>';
            }
            echo $item['image'];
            echo '<div class="shortinfo" >' . $item['short_info'] . '</div>';
            //echo '<div class="readmore_EC">'.$item['readmore'].'</div>'; 
            
            echo '</div>';
            
        }
        echo '</ul>';
        echo '</div>';
        
        
    }
    
    
    
    
    
    
    function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
    {
        $pagination = '';
        if ($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages) {
            $pagination .= '<ul class="pagination_cat">';
            
            $right_links = $current_page + 10;
            $previous    = $current_page - 10;
            $next        = $current_page + 1;
            $back        = $current_page - 1;
            $first_link  = true;
            
            if ($current_page > 1) {
                //$previous_link = ($previous==0)?1:$back;
                $pagination .= '<li class="first"><a href="#" data-page="1" title="First">&laquo;</a></li>';
                $pagination .= '<li><a href="#" data-page="' . $back . '" title="Previous">&lt;</a></li>';
                for ($i = ($current_page - 1); $i < $current_page; $i++) {
                    if ($i > 0) {
                        $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page' . $i . '">' . $i . '</a></li>';
                    }
                }
                $first_link = false;
            }
            
            if ($first_link) {
                $pagination .= '<li class="first active">' . $current_page . '</li>';
            } elseif ($current_page == $total_pages) {
                $pagination .= '<li class="last active">' . $current_page . '</li>';
            } else {
                $pagination .= '<li class="active">' . $current_page . '</li>';
            }
            
            for ($i = $current_page + 1; $i < $right_links; $i++) {
                if ($i <= $total_pages) {
                    $pagination .= '<li><a href="#" data-page="' . $i . '" title="Page ' . $i . '">' . $i . '</a></li>';
                }
            }
            if ($current_page < $total_pages) {
                //$next_link = ($i > $total_pages)? $total_pages : $next;
                $pagination .= '<li><a href="#" data-page="' . $next . '" title="Next">&gt;</a></li>';
                $pagination .= '<li class="last"><a href="#" data-page="' . $total_pages . '" title="Last">&raquo;</a></li>';
            }
            
            $pagination .= '</ul>';
        }
        return $pagination;
    }
    
    
    
    function Check_layout()
    {
        global $page;
        $pagelabel = mb_strtolower($page->label);
        
        if ($this->LinesPages !== "") {
            $piecesLP = explode(",", $this->LinesPages);
        }
        if ($this->column3Pages !== "") {
            $piecesC3P = explode(",", $this->column3Pages);
        }
        if ($this->column2Pages !== "") {
            $piecesC2P = explode(",", $this->column2Pages);
        }
        if ($this->PGPages !== "") {
            $piecesPGP = explode(",", $this->PGPages);
        }
        if ($this->CarPages !== "") {
            $piecesCar = explode(",", $this->CarPages);
        }
        
        
        if (isset($piecesLP)) {
            foreach ($piecesLP as $piece) {
                $piece = trim($piece);
                $piece = mb_strtolower($piece);
                if ($pagelabel == $piece) {
                    $this->catalog_layout = 0;
                }
            }
        }
        
        
        if (isset($piecesC3P)) {
            foreach ($piecesC3P as $piece) {
                $piece = trim($piece);
                $piece = mb_strtolower($piece);
                if ($pagelabel == $piece) {
                    $this->catalog_layout = 1;
                }
            }
        }
        
        if (isset($piecesC2P)) {
            foreach ($piecesC2P as $piece) {
                $piece = trim($piece);
                $piece = mb_strtolower($piece);
                if ($pagelabel == $piece) {
                    $this->catalog_layout = 2;
                }
            }
        }
        
        if (isset($piecesPGP)) {
            foreach ($piecesPGP as $piece) {
                $piece = trim($piece);
                $piece = mb_strtolower($piece);
                if ($pagelabel == $piece) {
                    $this->catalog_layout = 3;
                }
            }
        }
        
        if (isset($piecesCar)) {
            foreach ($piecesCar as $piece) {
                $piece = trim($piece);
                $piece = mb_strtolower($piece);
                if ($pagelabel == $piece) {
                    $this->catalog_layout = 4;
                }
            }
        }
        
        
        return;
        
        
    }
    
    
    
    
    function Check_options()
    {
        
        
        if ($this->catalog_layout == 0) {
            
            if (isset($this->item_per_pageL) and $this->item_per_pageL <> "") {
                
                $this->item_per_page = $this->item_per_pageL;
                
            }
            if (isset($this->ImageCircleL)) {
                
                $this->ImageCircle = $this->ImageCircleL;
                
            }
            if (isset($this->ImagesizeWL) and $this->ImagesizeWL <> "") {
                
                $this->ImagesizeW = $this->ImagesizeWL;
                
            }
            if (isset($this->ImagesizeHL) and $this->ImagesizeHL <> "") {
                
                $this->ImagesizeH = $this->ImagesizeHL;
                
            }
            if (isset($this->ShowImageL)) {
                
                $this->ShowImage = $this->ShowImageL;
                
            }
            if (isset($this->ShowSortingL)) {
                
                $this->ShowSorting = $this->ShowSortingL;
                
            }
            
        }
        
        
        if ($this->catalog_layout == 1) {
            
            if (isset($this->item_per_page3c) and $this->item_per_page3c <> "") {
                
                $this->item_per_page = $this->item_per_page3c;
                
            }
            if (isset($this->ImageCircle3c)) {
                
                $this->ImageCircle = $this->ImageCircle3c;
                
            }
            if (isset($this->ImagesizeW3c) and $this->ImagesizeW3c <> "") {
                
                $this->ImagesizeW = $this->ImagesizeW3c;
                
            }
            if (isset($this->ImagesizeH3c) and $this->ImagesizeH3c <> "") {
                
                $this->ImagesizeH = $this->ImagesizeH3c;
                
            }
            if (isset($this->ShowImage3c)) {
                
                $this->ShowImage = $this->ShowImage3c;
                
            }
            if (isset($this->ShowSorting3c)) {
                
                $this->ShowSorting = $this->ShowSorting3c;
                
            }
            
        }
        
        
        if ($this->catalog_layout == 2) {
            
            if (isset($this->item_per_page2c) and $this->item_per_page2c <> "") {
                
                $this->item_per_page = $this->item_per_page2c;
                
            }
            if (isset($this->ImageCircle2c)) {
                
                $this->ImageCircle = $this->ImageCircle2c;
                
            }
            if (isset($this->ImagesizeW2c) and $this->ImagesizeW2c <> "") {
                
                $this->ImagesizeW = $this->ImagesizeW2c;
                
            }
            if (isset($this->ImagesizeH2c) and $this->ImagesizeH2c <> "") {
                
                $this->ImagesizeH = $this->ImagesizeH2c;
                
            }
            if (isset($this->ShowImage2c)) {
                
                $this->ShowImage = $this->ShowImage2c;
                
            }
            if (isset($this->ShowSorting2c)) {
                
                $this->ShowSorting = $this->ShowSorting2c;
                
            }
            
            
            
        }
        
        if ($this->catalog_layout == 4) {
            
            if (isset($this->ImageCirclecar)) {
                
                $this->ImageCircle = $this->ImageCirclecar;
                
            }
            if (isset($this->ImagesizeWcar) and $this->ImagesizeWcar <> "") {
                
                $this->ImagesizeW = $this->ImagesizeWcar;
                
            }
            if (isset($this->ImagesizeHcar) and $this->ImagesizeHcar <> "") {
                
                $this->ImagesizeH = $this->ImagesizeHcar;
                
            }
            if (isset($this->ShowImagecar)) {
                
                $this->ShowImage = $this->ShowImagecar;
                
            }
            
        }
        
        
        if ($this->ImagesizeH == "") {
            $this->ImagesizeH = 200;
        }
        if ($this->ImagesizeW == "") {
            $this->ImagesizeH = 200;
        }
        
        if (!isset($this->ShowSorting)) {
            $this->ShowSorting = false;
        }
        
        
        return;
        
    }
    
    
    
    
    function getDefaultConfig()
    {
        
        $this->item_per_page  = 6;
        $this->catalog_layout = 0;
        $this->ShowImage      = true;
        $this->ShowSorting    = false;
        $this->ImagesizeW     = 200;
        $this->ImagesizeH     = 200;
        $this->ImageCircle    = false;
        $this->LinesPages     = "";
        $this->column3Pages   = "";
        $this->PGPages        = "";
        $this->CarPages       = "";
        $ECPColumns           = 5;
        $ECPMinHeight         = 400;
        $ECrow                = 4;
        $ECheight             = 400;
		$this->ShortInfo 	  = "sect";	
		$this->AbbrevL 		  = 100;
		
        //list 		
        $this->item_per_pageL = 6;
        $this->ImagesizeWL    = 200;
        $this->ImagesizeHL    = 200;
        $this->ImageCircleL   = false;
        $this->ShowImageL     = true;
        $this->ShowSortingL   = false;
        
        //3c 
        $this->item_per_page3c = 6;
        ;
        $this->ImagesizeW3c  = 200;
        $this->ImagesizeH3c  = 200;
        $this->ImageCircle3c = false;
        $this->ShowImage3c   = true;
        $this->ShowSorting3c = false;
        
        //2c 
        $this->item_per_page2c = 6;
        $this->ImagesizeW2c    = 200;
        $this->ImagesizeH2c    = 200;
        $this->ImageCircle2c   = false;
        $this->ShowImage2c     = true;
        $this->ShowSorting2c   = false;
        
		$this->ShowTitlecar	 = true;
		
        $this->imagelinked = 0;
        $this->Showtitle   = false;
        $this->ItemW       = 30;
        $this->datafilter  = array();
        
        $this->anotherpage 	= null;
        $this->netpage     	= null;
        $this->ECthumb     	= false;
        $this->ECthumbH	   	= 200;
		$this->ECthumbW		= 200;
        return;
    }
    
    
    function getUrl()
    {
        $url = @($_SERVER["HTTPS"] != 'on') ? 'http://' . $_SERVER["SERVER_NAME"] : 'https://' . $_SERVER["SERVER_NAME"];
        $url .= ($_SERVER["SERVER_PORT"] != 80) ? ":" . $_SERVER["SERVER_PORT"] : "";
        $url .= $_SERVER["REQUEST_URI"];
        return $url;
        
    }
    
    
}
