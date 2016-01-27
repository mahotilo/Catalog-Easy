<?php



defined('is_running') or die('Not an entry point...');


class Catalog_nav extends Catalog_Easy{

	function __construct(){
	
	global $page;
	
	Catalog_Easy::getConfig();
 
  
	$indexofparent=$this->check_parent();
  
	if($indexofparent and $this->CheckifNav($indexofparent)) {
	  
		$samelevel = $this->getChildpagesfromIndex($indexofparent);
		
		$this->getNextPrev($samelevel);
		  
		$this->Show($indexofparent);
	
	} elseif($this->CheckifNavAnother()){
	 
		$samelevel = $this->getChildpagesfromIndexandMenu($this->another_parent,$this->another_menu);
		
		$this->getNextPrev($samelevel);
		
		$this->Show($this->page_cat);

	}
 

	}

	
	
	
 function Show($indexofparent){	
	  $pl=common::GetLabelIndex($indexofparent);
	  $pt=common::IndexToTitle($indexofparent);
		
		
		echo '<p class="blog_nav_links">';

			echo '<a href="'.common::GetUrl($pt).'">'.$pl.'</a>';
			echo '&nbsp;';
			
			if($this->PrevUrl){
			echo '<a class="blog_newer" href="'.$this->PrevUrl.'">Следующая</a>';	
			echo '&nbsp;';	
			}
			if($this->NextUrl){
			echo '<a class="blog_older" href="'.$this->NextUrl.'">Предыдущая</a>';		
			}
				
		echo '</p>';
 
 
 

	}

	
	
function check_parent(){
	global $gp_menu, $page;
	$title = common::Parents($page->gp_index,$gp_menu);
	if (array_key_exists(0, $title)){
	return $title[0];}
	else {return false;}
	
}


function check_parent_another($menu){
	global  $page;
	$title = common::Parents($page->gp_index,$menu);
	if (array_key_exists(0, $title)){
	return $title[0];}
	else {return false;}
	
}



 function CheckifNav($indexofparent){
		
		global $gp_titles;
		
		$page_label=common::GetLabelIndex($indexofparent);
				
		if(isset($this->catpages) and $this->catpages<>""){
		
			foreach ($this->catpages as $catpage ){
				
				
				if (mb_strtolower($page_label) == mb_strtolower($catpage['label'])) {
	 
				
					if($catpage['navi'] and $catpage['source']== 0) 
						return true;
				}
				
				if (mb_strtolower($page_label) == mb_strtolower($catpage['sourcepages'])) {
	 
				
					if($catpage['navi'] and $catpage['source']== 1) 
						return true;
				
				}
				if (mb_strtolower($page_label) == mb_strtolower($catpage['sourcepages'])) {
	 
				
					if($catpage['navi'] and $catpage['source']== 2) {
					$this->another_parent = $indexofparent;	
					
					$index      = Catalog_Easy::array_find_deep($gp_titles, $catpage['label']);
					$page_index = $index[0];
					$this->page_cat = $page_index;
					return true;
					}
				
				}
			
			
			
			}
		}
	 
	 
	 
	 
	 return false;
	 
 } 
 


 function CheckifNavAnother(){
	 global $config,$page;
	 
	 if(!array_key_exists ( "menus", $config) ){
		 return false;
	 }
	 
	 foreach($config['menus'] as $key => $value){
		
		$menu = gpOutput::GetMenuArray($key);
		
		//check page in another menu
		if (isset($menu[$page->gp_index])) {
				
			$parent=$this->check_parent_another($menu);
			
			if($parent){
			   
			   if($this->CheckifNav($parent)){
				   $this->another_menu=$menu;
			   }
			   
				return $this->CheckifNav($parent);
			}
		
		}
		 
	
	}


	 return false;
	 
 }
 






function getChildpagesfromIndex($indexofparent){
	
	global $page, $gp_index, $gp_menu;
	
	
	
	$page_index=$indexofparent;
		
	if( !isset($gp_menu[$page_index]) ){
			return;
		}
		$titles = common::Descendants($page_index,$gp_menu);
		$level = $gp_menu[$page_index]['level'];
		
			
		foreach( $titles as $index ){

			$child_level = $gp_menu[$index]['level'];
			if( $child_level != $level+1 ){
				continue;
			}
		
		//	if ($page->gp_index<>$index) { //exlude current page from show
			
			$title[] = array_search($index, $gp_index);
				
		//		}
			if( !$title ){
				continue;
			}
			
			
		}
		
		if( !isset($title) ){
			return;
		}

		
	return $title;
	
	
	}


	
function getChildpagesfromIndexandMenu($indexofparent,$menu){
	
	global $page, $gp_index, $gp_menu;
		
	$page_index=$indexofparent;
		
	if( !isset($menu[$page_index]) ){
			return;
		}
		$titles = common::Descendants($page_index,$menu);
		$level = $menu[$page_index]['level'];
		
			
		foreach( $titles as $index ){

			$child_level = $menu[$index]['level'];
			if( $child_level != $level+1 ){
				continue;
			}
					
			$title[] = array_search($index, $gp_index);
			
			if( !$title ){
				continue;
			}
			
			
		}
		
		if( !isset($title) ){
			return;
		}

		
	return $title;
	
	
	}
	
	
 function getNextPrev($titles){
	
	global $page;
	
	$current = array_search ( $page->title , $titles  );
	
	if (array_key_exists ( $current-1, $titles ) ) {
		
		$this->PrevUrl= common::GetUrl($titles[$current-1]);

	} else {
		
		$this->PrevUrl="";
		
	}
	
	if (array_key_exists ( $current+1, $titles ) ) {
	
	$this->NextUrl= common::GetUrl($titles[$current+1]);
			
	} else {
		
		$this->NextUrl="";
		
	}
	
	
 }

 
 
 
 
 

	
}
