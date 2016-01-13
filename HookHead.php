<?php
/*Author: a2exfr
http://my-sitelab.com/
Date: 2015-11-07
Version 1.7 */

defined('is_running') or die('Not an entry point...');

global $addonRelativeCode, $page;
global $ECPColumns,$ECPMinHeight;	
	$page->css_user[] = $addonRelativeCode . '/css/bootstrap.css'; //only grid)
	$page->css_user[] = $addonRelativeCode . '/css/catalog.css';
	$page->css_user[] = $addonRelativeCode . '/css/carousel.css';
  
	
	$page->head_js[] =  $addonRelativeCode . '/js/jquery.wm-gridfolio-1.0.min.js';
	$page->head_js[] =  $addonRelativeCode . '/js/carousel.js';
	$page->head_js[] =  $addonRelativeCode . '/js/jquery.mixitup.min.js';
	
	$page->head_script .= "\nvar ECPColumns = '" . $ECPColumns . "';\n";
	$page->head_script .= "\nvar ECPMinHeight = '" . $ECPMinHeight . "';\n";
	
	$page->head_js[] =  $addonRelativeCode . '/js/catalog.js';
	
	
	common::LoadComponents('colorbox');
	
