<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Dingo Framework Bootstrap Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 */

class bootstrap
{
	// Get the requested URL, parse it, then clean it up
	// ---------------------------------------------------------------------------
	static function get_request_url()
	{	
		// Get the filename of the currently executing script relative to docroot
		$url = (empty($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '/';
		
		// Get the current script name (eg. /index.php)
		$script_name = (isset($_SERVER['SCRIPT_NAME'])) ? $_SERVER['SCRIPT_NAME'] : $url;
		
		// Parse URL, check for PATH_INFO and ORIG_PATH_INFO server params respectively
		$url = (0 !== stripos($url, $script_name)) ? $url : substr($url, strlen($script_name));
		$url = (empty($_SERVER['PATH_INFO'])) ? $url : $_SERVER['PATH_INFO'];
		$url = (empty($_SERVER['ORIG_PATH_INFO'])) ? $url : $_SERVER['ORIG_PATH_INFO'];
		
		//Tidy up the URL by removing trailing slashes
		$url = (!empty($url)) ? rtrim($url, '/') : '/';
		
		return $url;
	}
	
	
	// Autoload
	// ---------------------------------------------------------------------------
	static function autoload()
	{
		global $dingo;
		global $_controller;
		
		// Autoload Libraries
		foreach(config::get('autoload_libraries') as $class)
		{
			$dingo->load->library($class);
		}
		
		if(!empty($_controller->autoload_libraries) AND is_array($_controller->autoload_libraries))
		{
			foreach($_controller->autoload_libraries as $class)
			{
				$_controller->dingo->load->library($class);
			}
		}
		
		// Autoload Helpers
		foreach(config::get('autoload_helpers') as $helper)
		{
			$dingo->load->helper($helper);
		}
		
		if(!empty($_controller->autoload_helpers) AND is_array($_controller->autoload_helpers))
		{
			foreach($_controller->autoload_helpers as $helper)
			{
				$_controller->dingo->load->helper($helper);
			}
		}
	}
	
	
	// Run
	// ---------------------------------------------------------------------------
	static function run()
	{
		global $application;
		global $system;
		global $config;
		global $allowed_chars;
		global $dingo;
		global $_controller;
		global $route;
		global $plugin;
		global $structure;

		define('DINGO_VERSION','0.6.0');
		define('APPLICATION',$application);
		define('SYSTEM',$system);
		ob_start();
		
		
		// Load Core Files
		require_once("$system/core/DingoCore.php");
		require_once("$system/core/DingoConfig.php");
		require_once("$system/core/DingoRoute.php");
		require_once("$system/core/DingoLoad.php");
		require_once("$system/core/DingoInput.php");
		require_once("$system/core/DingoError.php");
		require_once("$application/$config/".CONFIGURATION."/config.php");
		
		set_error_handler('dingo_error');
		set_exception_handler('dingo_exception');
		
		$plugin = array();
		$structure = array();
		
		
		// Load Core Classes
		$dingo = new DingoCore();
		$dingo->load = new DingoLoad();
		$dingo->load->dingo = $dingo;
		$dingo->input = new DingoInput();
		$dingo->input->dingo = $dingo;
		$dingo->message = new DingoMessage();
		$dingo->message->dingo = $dingo;
		
		
		config::set('system',$system);
		config::set('application',$application);
		config::set('config',$config);
		
		
		// Load Application Configurations
		require_once("$application/$config/".CONFIGURATION."/routes.php");
		require_once("$application/$config/".CONFIGURATION."/plugins.php");
		require_once("$application/$config/".CONFIGURATION."/structures.php");
		
		
		// Get route
		$uri = route::get(bootstrap::get_request_url());
		
		
		// Set current page
		define('CURRENT_PAGE',$uri['string']);
		
		
		// Load plugin
		$uri = route::plugin($uri);
		
		
		// Validate
		if(!route::valid($uri))
		{
			$dingo->load->error('general','Invalid URL','The requested URL contains invalid characters.');
		}
		
		
		// Structures
		route::structure($uri);
		
		
		// Load Controller
		//----------------------------------------------------------------------------------------------
		
		// If controller does not exist, give 404 error
		if(!file_exists("$application/".config::get('folder_controllers')."/{$uri['controller']}.php"))
		{
			$dingo->load->error('404');
		}
		
		// Otherwise, load controller
		require_once("$application/".config::get('folder_controllers')."/{$uri['controller']}.php");
		$_controller = new controller;
		$_controller->dingo = $dingo;
		
		
		// Autoload Components
		bootstrap::autoload();
		
		
		// Shorten Function "Path"
		foreach($_controller->dingo->load->libraries as $lib)
		{
			if(isset($_controller->dingo->$lib))
			{
				$_controller->$lib = $_controller->dingo->$lib;
			}
		}
		
		
		// Check to see if function exists
		if(!is_callable(array($_controller,$uri['function'])))
		{
			// Try replacing underscores with dashes
			$minus_function_name = str_replace('-', '_', $uri['function']);
			
			if(!is_callable(array($_controller,$minus_function_name)))
			{
				$_controller->dingo->load->error('404');
			}
			else
			{
				$uri['function'] = $minus_function_name;
			}
		}
		
		
		// Structure Onload
		if(method_exists($_controller,'structure_onload'))
		{
			$_controller->structure_onload();
		}
		
		// Controller Onload
		if(method_exists($_controller,'onload'))
		{
			$_controller->onload();
		}
		
		
		// Run Function
		call_user_func_array(array($_controller,$uri['function']),$uri['arguments']);
		
		
		// Controller Unload
		if(method_exists($_controller,'unload'))
		{
			$_controller->unload();
		}
		
		// Structure Unload
		if(method_exists($_controller,'structure_unload'))
		{
			$_controller->structure_unload();
		}
		
		
		// Display echoed content
		ob_end_flush();
	}
}

