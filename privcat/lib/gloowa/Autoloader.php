<?php

class Autoloader {

	private static $_basePaths = array ();

	public static function registerBasePath($path) {
		if(is_dir($path)) {
			self::$_basePaths [] = $path;
		}
	}

	public static function autoload($className) {

		foreach (Autoloader::$_basePaths as $dir) {
			if(Autoloader::loadFrom($dir, $className)) {
				return;
			}
		}

	}

	private static function loadFrom($dir, $className) {
		$classFilePath = $dir.'/'.$className.'.php';
		$classFilePath2 = $dir.'/'.$className.'.class.php';
		
		if(file_exists($classFilePath)) {
			require_once $classFilePath;
			return true;
		} elseif(file_exists($classFilePath2)) {
			require_once $classFilePath2;
			return true;
		} else {
			$subDirs = glob($dir . '/*' , GLOB_ONLYDIR);
			
			foreach ($subDirs as $subDir) {
				if($subDir === $dir) {
					continue;
				}
				if(Autoloader::loadFrom($subDir, $className)) {
					return true;
				}
			}

		}
		
		return false;
	}

}

