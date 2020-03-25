<?php
/*
Catalog Easy Plugin
Author: a2exfr
http://my-sitelab.com/
Version 1.8*/

defined('is_running') or die('Not an entry point...');


/*Just get the current layout's Bootstrap main version quickly
  @return boolean|integer false(not Bootstrap) | true(Bootstrap but no version number) | 2 | 3 | 4 ... */
if(!function_exists("IsBootstrap")){
	function IsBootstrap(){
		global $page, $config, $gpLayouts;
		if( $page->pagetype === 'admin_display' ){ return false; }
		$layout_id = isset($page->TitleInfo['gpLayout']) ? $page->TitleInfo['gpLayout'] : $config['gpLayout'];
		$layout_arr = $gpLayouts[$layout_id];
		if( !isset($layout_arr['framework']['name']) ||	strtolower($layout_arr['framework']['name']) != 'bootstrap' ){ return false; }
		if( empty($layout_arr['framework']['version']) ){ return true; }
		$pieces   = explode('.', $layout_arr['framework']['version']);
		$main_ver = preg_replace('/[^0-9]/', '', $pieces[0]);
		return (int)$main_ver;
	}
}

global $addonRelativeCode, $page, $addonPathData,$gp_index;
	$page->css_user[] = $addonRelativeCode . '/css/catalog.css';
	$page->css_user[] = $addonRelativeCode . '/css/carousel.css';
	$page->css_user[] = $addonRelativeCode . '/css/owlcarousel.css';


	$page->head_js[] =  $addonRelativeCode . '/js/jquery.wm-gridfolio-1.0.min.js';
	
	$BSVer = IsBootstrap();
	if ($BSVer) {
		if ( $BSVer == 2 ) {
			$page->css_user[] = $addonRelativeCode . '/css/bootstrap.css'; //only grid)
			common::LoadComponents( 'bootstrap-carousel' );
		} elseif ( $BSVer == 3 ) {
			common::LoadComponents( 'bootstrap3-carousel' );
		} else {
			common::LoadComponents( 'bootstrap4-carousel' );
		}
	}
	
	$page->head_js[] =  $addonRelativeCode . '/js/carousel.js';
	$page->head_js[] =  $addonRelativeCode . '/js/owl.carousel.min.js';
	$page->head_js[] =  $addonRelativeCode . '/js/jquery.mixitup.min.js';
	$page->head_js[] =  $addonRelativeCode . '/js/imagesloaded.pkgd.min.js';
	$page->head_js[] =  $addonRelativeCode . '/js/eh.js';

	$page->head_script .= "\nvar catbase = '" . $addonRelativeCode . "';\n";
	$page->head_script .= 'gpE_added_js = [];';

	$configFile = $addonPathData . '/config.php';
	 if (file_exists($configFile)) {
            include $configFile;
        } else { $config['wap'] = false; }

	if(!array_key_exists ( 'wap', $config) ) { $config['wap'] = false; }
	if(!array_key_exists ( 'datafilter', $config) ) { $config['datafilter'] = ""; }

	if ($config['wap']) {
		$page->head_js[] =  $addonRelativeCode . '/js/catalog_wap.js';
				} else {
		$page->head_js[] =  $addonRelativeCode . '/js/catalog.js';
		}


	if( common::LoggedIn() ){

	$page->head .= "\n" . '<script type="text/javascript">gpFinder_url = "' . common::GetUrl('Admin_Browser') . '";</script>' . "\n";
	$page->head_js[] =   $addonRelativeCode . '/js/catalog_menu.js';


		$pageIndexJS = 'var gpE_availablelabels = [';
		  $i = 0;
		  foreach ($gp_index as $key => $value) {
			$i++;
			$pageIndexJS .= '"' . common::GetLabelIndex($value) . '"' . ($i == count($gp_index) ? '' : ', ');
		  }
		  $pageIndexJS .= '];';
		  $page->head_script .= "\n" . $pageIndexJS . "\n";

		if(array_key_exists ( "menus", $GLOBALS['config']) and $GLOBALS['config']['menus']<>"" ){

		$menus = 'var gpE_menus = {';
		$i = 0;
		foreach ($GLOBALS['config']['menus'] as $key => $value) {
			$i++;
			$menus  .= '"'.$key.'":"' . $value . '"' . ($i == count($GLOBALS['config']['menus']) ? '' : ', ');
		  }
		$menus .= '};';
		$page->head_script .= "\n" . $menus . "\n";

		} else {
		$menus = 'var gpE_menus = {';
		$menus .= '};';
		$page->head_script .= "\n" . $menus . "\n";
		}

		if(array_key_exists ( "datafilter", $config) and $config['datafilter']<>"" ){

		$datafilterJS = 'var gpE_datafilter = [';
		  $i = 0;
		  $pieces = explode(",", $config['datafilter']);

		  foreach ($pieces as $value) {
			$i++;
			$datafilterJS .= '"' . $value . '"' . ($i == count($pieces) ? '' : ', ');
		  }
		  $datafilterJS .= '];';
		  $page->head_script .= "\n" . $datafilterJS . "\n";

		} else {
		$datafilterJS = 'var gpE_datafilter = {';
		$datafilterJS .= '};';
		$page->head_script .= "\n" . $datafilterJS . "\n";

		}

		$layoutsJS = 'var gpE_added_layouts = {';
		$layoutsJS .= '};';
		$page->head_script .= "\n" . $layoutsJS . "\n";

		$page->head_script.= 'gpE_add_opts = "";';


	}


	common::LoadComponents('colorbox');