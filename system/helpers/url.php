<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Dingo Framework URL Helper
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/url-helper
 */

class url
{
	// Base URL
	// ---------------------------------------------------------------------------
	static function base($ShowIndex = FALSE)
	{
		if($ShowIndex AND !MOD_REWRITE)
		{
			// Include "index.php"
			return(BASE_URL.'index.php/');
		}
		else
		{
			// Don't include "index.php"
			return(BASE_URL);
		}
	}
	
	
	// Page URL
	// ---------------------------------------------------------------------------
	static function page($path = FALSE)
	{
		if(MOD_REWRITE)
		{
			return(url::base().$path);
		}
		else
		{
			return(url::base(TRUE).$path);
		}
	}
	
	
	// Plugin Page URL
	// ---------------------------------------------------------------------------
	static function plugin_page($path = FALSE)
	{
		if($path)
		{
			return(url::base(TRUE).CURRENT_PLUGIN."/$path");
		}
		else
		{
			return(url::base(TRUE).CURRENT_PLUGIN);
		}
	}
	
	
	// Redirect
	// ---------------------------------------------------------------------------
	static function redirect($url = '')
	{
		header('Location: '.url::base(TRUE).$url);
		exit;
	}
	#Method to go to previous page
static function goback()
{
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit;
}



}