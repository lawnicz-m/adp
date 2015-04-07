<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Dingo Framework Router Class
 *
 * @Author          Evan Byrne
 * @Copyright       2008 - 2010
 * @Project Page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/routes
 */

class route
{
	// Validate
	// ---------------------------------------------------------------------------
	static function valid($route)
	{
		global $allowed_chars;
		
		if(
			$route['function'] == 'onload' OR
			$route['function'] == 'unload' OR
			$route['function'] == 'structure_onload' OR
			$route['function'] == 'structure_unload'
		){
			return FALSE;
		}
		
		foreach($route['segments'] as $segment)
		{
			if(!preg_match($allowed_chars,$segment))
			{
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	
	// Plugin
	// ---------------------------------------------------------------------------
	static function plugin($route)
	{
		global $plugin;
		global $application;
		global $dingo;
		
		if(is_array($plugin))
		{
			$tmp = array_keys($plugin);
			$x = 0;
		
			foreach($tmp as $plug)
			{
				if(preg_match("/^($plug\/)/",$route['string']))
				{
					$route['string'] = preg_replace("/^($plug\/)/",'',$route['string']);
					$route = route::get($route['string']);
					
					$application = "$application/".config::get('folder_plugins')."/{$plugin[$plug]}";
					$dingo->plugin = $plugin[$plug];
					$dingo->plugin_dir = config::get('folder_plugins')."/$plugin[$plug]";
					
					define('CURRENT_PLUGIN',$plug);
				}
				
				$x += 1;
			}
		}
		
		return $route;
	}
	
	
	// Structure
	// ---------------------------------------------------------------------------
	static function structure($route)
	{
		global $structure;
		global $dingo;
		
		if(isset($structure[$route['controller']]))
		{
			$dingo->load->structure($structure[$route['controller']]);
		}
	}
	
	
	// Get
	// ---------------------------------------------------------------------------
	static function get($url)
	{
		global $route;
		
		$url = preg_replace('/^(\/)/','',$url);
		$new_url = $url;
		
		// Static routes
		if(!empty($route[$url]))
		{
			$new_url = $route[$url];
		}
		
		// Regex routes
		$route_keys = array_keys($route);
		
		foreach($route_keys as $okey)
		{
			$key = ('/^'.str_replace('/','\\/',$okey).'$/');
			
			if(preg_match($key,$url))
			{
				if(!is_array($route[$okey]))
				{
					$new_url = preg_replace($key,$route[$okey],$url);
				}
				else
				{
					/* Run regex replace on keys */
					$new_url = $route[$okey];
					
					// Controller
					if(isset($new_url['controller']))
					{
						$new_url['controller'] = preg_replace($key,$new_url['controller'],$url);
					}
					
					// Function
					if(isset($new_url['function']))
					{
						$new_url['function'] = preg_replace($key,$new_url['function'],$url);
					}
					
					// Arguments
					if(isset($new_url['arguments']))
					{
						$x = 0;
						while(isset($new_url['arguments'][$x]))
						{
							$new_url['arguments'][$x] = preg_replace($key,$new_url['arguments'][$x],$url);
							$x += 1;
						}
					}
				}
			}
			
		}
		
		// If URL is empty use default route
		if(empty($new_url) OR $new_url == '/')
		{
			$new_url = $route['default_route'];
		}
		
		// Turn into array
		if(!is_array($new_url))
		{
			// Remove the /index.php/ at the beginning
			//$new_url = preg_replace('/^(\/)/','',$url);
			
			$tmp_url = explode('/',$new_url);
			$new_url = array('controller'=>$tmp_url[0],'function'=>'index','arguments'=>array(),'string'=>$new_url,'segments'=>$tmp_url);
			
			// Function
			if(!empty($tmp_url[1]))
			{
				$new_url['function'] = $tmp_url[1];
			}
			
			// Arguments
			$x = 2;
			while(isset($tmp_url[$x]))
			{
				$new_url['arguments'][] = $tmp_url[$x];
				$x += 1;
			}
		}
		
		// If already array
		else
		{
			// Add missing keys
			if(!isset($new_url['function']))
			{
				$new_url['function'] = 'index';
			}
			
			if(!isset($new_url['arguments']))
			{
				$new_url['arguments'] = array();
			}
			
			
			// Build string key for URL array
			// Controller
			$s = $new_url['controller'];
			
			// Function
			if(isset($new_url['function']))
			{
				$s .= "/{$new_url['function']}";
			}
			
			// Arguments
			foreach($new_url['arguments'] as $arg)
			{
				$s .= "/$arg";
			}
			
			$new_url['string'] = $s;
			
			
			// Add segments key
			$new_url['segments'] = explode('/',$new_url['string']);
		}
		
		return $new_url;
	}
}