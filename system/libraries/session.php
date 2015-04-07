<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Session Class For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */

class session{

	private $dingo;
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($dingo){
		$this->dingo = $dingo;
	}

	// Get Session
	// ---------------------------------------------------------------------------
	public function get($session){
        return isset($_SESSION[$session]) ? $_SESSION[$session] : false;
	}
	
	
	// Set Session
	// ---------------------------------------------------------------------------
	public function set($name,$value){
		$_SESSION[$name] = $value;
	}
	
	
	// Destroy Session
	// ---------------------------------------------------------------------------
	public function destroy(){
        session_destroy();
	}


	// Delete Session
	// ---------------------------------------------------------------------------
	public function delete($name){
		if(isset($_SESSION[$name])) unset($_SESSION[$name]);
	}

}

register::library('session',new session($dingo));