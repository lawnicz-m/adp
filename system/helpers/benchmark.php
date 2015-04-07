<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Benchmark Helper For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/benchmark-helper
 */

class bench
{
	static $markers = array();
	
	
	// Mark
	// ---------------------------------------------------------------------------
	static function mark($name)
	{
		self::$markers[$name] = microtime();
	}
	
	
	// Time
	// ---------------------------------------------------------------------------
	static function time($mark1,$mark2)
	{
		return self::$markers[$mark2] - self::$markers[$mark1];
	}
	
	
	// Clear
	// ---------------------------------------------------------------------------
	static function clear()
	{
		self::$markers = array();
	}
}