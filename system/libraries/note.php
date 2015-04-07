<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * Note Library For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/note-library
 */

class note
{
	private $input;
	
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($input)
	{
		$this->input = $input;
	}
	
	
	// Set
	// ---------------------------------------------------------------------------
	public function set($type,$id,$message)
	{
		$c = config::get('notes');
		$c['name'] = "note-$type-$id";
		$c['value'] = $message;
		cookie::set($c);
		
		return $this;
	}
	
	
	// Regular
	// ---------------------------------------------------------------------------
	public function regular($id,$message)
	{
		return $this->set('regular',$id,$message);
	}
	
	
	// Error
	// ---------------------------------------------------------------------------
	public function error($id,$message)
	{
		return $this->set('error',$id,$message);
	}
	
	
	// Warning
	// ---------------------------------------------------------------------------
	public function warning($id,$message)
	{
		return $this->set('warning',$id,$message);
	}
	
	
	// Success
	// ---------------------------------------------------------------------------
	public function success($id,$message)
	{
		return $this->set('success',$id,$message);
	}
	
	
	// Get
	// ---------------------------------------------------------------------------
	public function get($id,$type=FALSE)
	{
		// Type specified
		if($type)
		{
			if($note = $this->input->cookie("note-$type-$id"))
			{
				$this->delete($id);
				return array('id'=>$id,'type'=>$type,'content'=>$note);
			}
			else
			{
				return FALSE;
			}
		}
		
		// Type not specified
		else
		{
			// Regular
			if($note = $this->input->cookie("note-regular-$id"))
			{
				$this->delete($id);
				return array('id'=>$id,'type'=>'regular','content'=>$note);
			}
			
			// Error
			elseif($note = $this->input->cookie("note-error-$id"))
			{
				$this->delete($id);
				return array('id'=>$id,'type'=>'error','content'=>$note);
			}
			
			// Warning
			elseif($note = $this->input->cookie("note-warning-$id"))
			{
				$this->delete($id);
				return array('id'=>$id,'type'=>'warning','content'=>$note);
			}
			
			// Sucess
			elseif($note = $this->input->cookie("note-success-$id"))
			{
				$this->delete($id);
				return array('id'=>$id,'type'=>'success','content'=>$note);
			}
			
			else
			{
				return FALSE;
			}
		}
	}
	
	
	// All
	// ---------------------------------------------------------------------------
	public function all($regex=FALSE)
	{
		$res = array();
		
		foreach($_COOKIE as $name=>$content)
		{
			if(preg_match('/^note\-(regular|error|warning|success)/',$name))
			{
				$id = preg_replace('/^note\-(regular|error|warning|success)\-/','',$name);
				
				if(!$regex OR preg_match($regex,$id))
				{
					$type = preg_replace('/^note\-(regular|error|warning|success)\-([\-_ a-zA-Z0-9\!\,\~\&\.\:\+\@]+)/','$1',$name);
					$res[] = array('id'=>$id,'type'=>$type,'content'=>$content);
					$this->delete($id);
				}
			}
		}
		
		if(!empty($res))
		{
			return $res;
		}
		else
		{
			return FALSE;
		}
	}
	
	
	// Delete
	// ---------------------------------------------------------------------------
	public function delete($id)
	{
		$c = config::get('notes');
		
		$c['name'] = "note-regular-$id";
		cookie::delete($c);
		
		$c['name'] = "note-error-$id";
		cookie::delete($c);
		
		$c['name'] = "note-warning-$id";
		cookie::delete($c);
		
		$c['name'] = "note-success-$id";
		cookie::delete($c);
		
		return $this;
	}
}

register::library('note',new note($dingo->input));