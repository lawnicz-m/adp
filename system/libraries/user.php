<?php if(!defined('DINGO')){die('External Access to File Denied');}

/**
 * User Authentication Library For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 * @docs            http://www.dingoframework.com/docs/user-library
 */

class user
{
	private $dingo;
	private $table;
	private $types = array();
	
	private $_id;
	private $_email;
	private $_username;
	private $_password;
	private $_type;
	private $_data;
	
	private $_valid = FALSE;
	
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($dingo)
	{
		$this->dingo = $dingo;
		
		// Load config file
		$this->dingo->load->config('user');
		$this->types = config::get('user_types');
		
		// Set database table
		$this->table = $this->dingo->db->table(config::get('user_table'));
		
		// Get session data
		$this->_email = $this->dingo->session->get('user_email');
		$this->_password = $this->dingo->session->get('user_password');
		
		// Get information about current user
		if($this->_email AND $this->_password)
		{
			$user = $this->table->select('*')
								->where('email','=',$this->_email)
								->clause('AND')
								->where('password','=',$this->_password)
								->limit(1)
								->execute();
			
			// If valid login credentials
			if(!empty($user[0]))
			{
				$user = $user[0];
				$this->_id = $user['id'];
				$this->_email = $user['email'];
				$this->_username = $user['username'];
				$this->_password = $user['password'];
				$this->_type = $user['type'];
				$this->_data = json_decode($user['data'],true);
				
				// If not banned, mark as valid
				if($this->_type != 'banned')
				{
					$this->_valid = TRUE;
				}
			}
		}
	}
	
	
	// Valid
	// ---------------------------------------------------------------------------
	public function valid()
	{
		return $this->_valid;
	}
	
	
	// Is Type
	// ---------------------------------------------------------------------------
	public function is_type($t)
	{
		if($this->_valid OR $t == 'banned')
		{
			// If type of user is equal to or greater than specified return TRUE
			return($this->types[$this->_type] >= $this->types[$t]);
		}
		else
		{
			// If not a valid user return FALSE
			return FALSE;
		}
	}
	
	
	// Banned
	// ---------------------------------------------------------------------------
	public function banned()
	{
		// Return TRUE is banned, FALSE otherwise
		return($this->types[$this->_type] === $this->types['banned']);
	}
	
	
	// Check
	// ---------------------------------------------------------------------------
	public function check($i,$password)
	{
		$valid = FALSE;
		
		// Get information about current user
		if($i AND $password)
		{
			// Find by ID
			if(preg_match('/^([0-9]+)$/',$i))
			{
				$user = $this->table->select('*')
									->where('id','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by Username
			elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
			{
				$user = $this->table->select('*')
									->where('username','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by E-mail
			else
			{
				$user = $this->table->select('*')
									->where('email','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// If valid login credentials
			if(!empty($user[0]))
			{
				// If not banned, mark as valid
				if($user[0]['type'] != 'banned')
				{
					$valid = TRUE;
				}
			}
		}
		
		return $valid;
	}
	
	
	// Get
	// ---------------------------------------------------------------------------
	public function get($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$user = $this->table->select('*')
								->where('id','=',$i)
								->limit(1)
								->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			$user = $this->table->select('*')
								->where('username','=',$i)
								->limit(1)
								->execute();
		}
		
		// Find by E-mail
		else
		{
			$user = $this->table->select('*')
								->where('email','=',$i)
								->limit(1)
								->execute();
		}
		
		// If user is found
		if(!empty($user[0]))
		{
			$user[0]['data'] = json_decode($user[0]['data'],true);
			return $user[0];
		}
		
		// Otherwise return FALSE
		else
		{
			return FALSE;
		}
	}
	
	
	// Log In
	// ---------------------------------------------------------------------------
	public function login($i,$password)
	{
		$this->_valid = FALSE;
		
		// Try to log in
		if($i AND $password)
		{
			$password = $this->hash($password);
		
			// Find by ID
			if(preg_match('/^([0-9]+)$/',$i))
			{
				$user = $this->table->select('*')
									->where('id','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by Username
			elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
			{
				$user = $this->table->select('*')
									->where('username','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// Find by E-mail
			else
			{
				$user = $this->table->select('*')
									->where('email','=',$i)
									->clause('AND')
									->where('password','=',$password)
									->limit(1)
									->execute();
			}
			
			// If valid login credentials
			if(!empty($user[0]))
			{
				$user = $user[0];
				$this->_id = $user['id'];
				$this->_email = $user['email'];
				$this->_username = $user['username'];
				$this->_password = $user['password'];
				$this->_type = $user['type'];
				$this->_data = $user['data'];
				
				// If not banned, mark as valid
				if($this->_type != 'banned')
				{
					$this->_valid = TRUE;
					$this->dingo->session->set('user_email',$this->_email);
					$this->dingo->session->set('user_password',$this->_password);
				}
			}
			
			return $this->_valid;
		}
	}
	
	
	// Log Out
	// ---------------------------------------------------------------------------
	public function logout()
	{
		$this->dingo->session->delete('user_email');
		$this->dingo->session->delete('user_password');
		
		$this->_valid = FALSE;
		
		return $this;
	}
	
	
	// Create
	// ---------------------------------------------------------------------------
	public function create($user)
	{
		// Make sure data key is set to prevent JSON errors
		if(!isset($user['data']))
		{
			$user['data'] = array();
		}
		
		$user['data'] = json_encode($user['data']);
		$user['password'] = $this->hash($user['password']);
		
		return $this->table->insert($user);
	}
	
	
	// Update
	// ---------------------------------------------------------------------------
	public function update($i=FALSE)
	{
		// Defaults to current user ID
		if(!$i)
		{
			$i = $this->_id;
		}
		
		return new user_update($i,$this->table);
	}
	
	
	// Delete
	// ---------------------------------------------------------------------------
	public function delete($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$this->table->delete('id','=',$i);
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			$this->table->delete('username','=',$i);
		}
		
		// Find by E-mail
		else
		{
			$this->table->delete('email','=',$i);
		}
		
		return $this;
	}
	
	
	// Ban
	// ---------------------------------------------------------------------------
	public function ban($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$this->table->update(array('type'=>'banned'))
			            ->where('id','=',$i)
			            ->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/is',$i))
		{
			$this->table->update(array('type'=>'banned'))
			            ->where('username','=',$i)
			            ->execute();
		}
		
		// Find by E-mail
		else
		{
			$this->table->update(array('type'=>'banned'))
			            ->where('email','=',$i)
			            ->execute();
		}
		
		return $this;
	}
	
	
	// Unique
	// ---------------------------------------------------------------------------
	public function unique($i)
	{
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$user = $this->table->select('*')
			                    ->where('id','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/i',$i))
		{
			$user = $this->table->select('*')
			                    ->where('username','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by E-mail
		else
		{
			$user = $this->table->select('*')
			                    ->where('email','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		return (!isset($user[0]));
	}
	
	
	// ID
	// ---------------------------------------------------------------------------
	public function id()
	{
		return $this->_id;
	}
	
	
	// E-mail
	// ---------------------------------------------------------------------------
	public function email()
	{
		return $this->_email;
	}
	
	
	// Username
	// ---------------------------------------------------------------------------
	public function username()
	{
		return $this->_username;
	}
	
	
	// Type
	// ---------------------------------------------------------------------------
	public function type()
	{
		return $this->_type;
	}
	
	
	// Password
	// ---------------------------------------------------------------------------
	public function password()
	{
		return $this->_password;
	}
	
	
	// Data
	// ---------------------------------------------------------------------------
	public function data($key)
	{
		return $this->_data[$key];
	}
	
	
	// Hash
	// ---------------------------------------------------------------------------
	public function hash($i)
	{
		return sha1($i);
	}
}


/**
 * User Authentication Library User Update Class For Dingo Framework
 *
 * @author          Evan Byrne
 * @copyright       2008 - 2010
 * @project page    http://www.dingoframework.com
 */
class user_update
{
	private $table;
	private $exists = TRUE;
	
	public $id;
	public $email;
	public $username;
	public $password;
	public $type;
	public $data;
	
	
	// Construct
	// ---------------------------------------------------------------------------
	public function __construct($i,$table)
	{
		$this->table = $table;
		
		// Find by ID
		if(preg_match('/^([0-9]+)$/',$i))
		{
			$user = $this->table->select('*')
			                    ->where('id','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by Username
		elseif(preg_match('/^([\-_ a-z0-9]+)$/i',$i))
		{
			$user = $this->table->select('*')
			                    ->where('username','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		// Find by E-mail
		else
		{
			$user = $this->table->select('*')
			                    ->where('email','=',$i)
			                    ->limit(1)
			                    ->execute();
		}
		
		if(isset($user[0]))
		{
			$this->id = $user[0]['id'];
			$this->email = $user[0]['email'];
			$this->username = $user[0]['username'];
			$this->password = $user[0]['password'];
			$this->type = $user[0]['type'];
			$this->data = json_decode($user[0]['data'],true);
		}
		else
		{
			$this->exists = FALSE;
		}
	}
	
	
	// ID
	// ---------------------------------------------------------------------------
	public function id($id)
	{
		$this->id = $id;
		return $this;
	}
	
	
	// E-mail
	// ---------------------------------------------------------------------------
	public function email($email)
	{
		$this->email = $email;
		return $this;
	}
	
	
	// Username
	// ---------------------------------------------------------------------------
	public function username($username)
	{
		$this->username = $username;
		return $this;
	}
	
	
	// Password
	// ---------------------------------------------------------------------------
	public function password($password)
	{
		$this->password = $this->hash($password);
		return $this;
	}
	
	
	// Type
	// ---------------------------------------------------------------------------
	public function type($type)
	{
		$this->type = $type;
		return $this;
	}
	
	
	// Data
	// ---------------------------------------------------------------------------
	public function data($key,$value)
	{
		$this->data[$key] = $value;
		return $this;
	}
	
	
	// Save
	// ---------------------------------------------------------------------------
	public function save()
	{
		$this->table->update(array(
						'id'=>$this->id,
						'email'=>$this->email,
						'username'=>$this->username,
						'password'=>$this->password,
						'type'=>$this->type,
						'data'=>json_encode($this->data)
					))
		            ->where('id','=',$this->id)
		            ->execute();
		
		return $this;
	}
	
	
	// Hash
	// ---------------------------------------------------------------------------
	public function hash($i)
	{
		return sha1($i);
	}
}

register::library('user',new user($dingo));