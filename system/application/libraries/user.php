<?php

class User {
	
	private $CI;
	public $logged_in = false;
	public $data = null;
	
	function User() {
		$this->CI =& get_instance();
	//	$this->_expand_session();
	}
	
	function login($user, $pass) {
		$this->logout();
		if ($this->_auth_user($user, $pass)) {
			$this->CI->session->set_userdata("user", $user);
			return true;
		} else {
			return false;
		}
	}
	
	function logout() {
		$this->CI->session->sess_destroy();
	}
	
	function set() {
		$this->_expand_session();
	}
	
	function require_login() {
		if(!$this->logged_in) redirect("auth/login");
	}
	
	private function _expand_session() {
		$user = $this->CI->session->userdata("user");
		if ($user) {
			$this->_auth_user($user);
		}
	}
	
	function get_user($user) {
		if (is_int($user)) {
			$data['user_id'] = $user;
		} else {
			$data['username'] = $user;
		}
		$user = $this->CI->db->get_where("users", $data);
		return $user->row();
	}
	
	function add_twitter_tokens($user, $tokens) {
		if (is_int($user)) {
			$data['user_id'] = $user;
		} else {
			$data['username'] = $user;
		}
		$this->CI->db->where($data);
		$data = array();
		$data['twitter_tokens'] = json_encode($tokens);
		$this->CI->db->update("users", $data);
	}
	
	function modify_user($user = null, $modify) {
		if (!$user) $user = (int) $this->data->user_id;
		if (is_int($user)) {
			$data['user_id'] = $user;
		} else {
			$data['username'] = $user;
		}
		
		$this->CI->db->where($data);
		$this->CI->db->update("users", $modify);
	}
	
	function change_password($user = null, $pass) {
		if (!$user) $user = (int) $this->data->user_id;
		$pass = md5($pass);
		
		if (is_int($user)) {
			$data['user_id'] = $user;
		} else {
			$data['username'] = $user;
		}
		$this->CI->db->where($data);
		$data = array();
		$data['password'] = $pass;
		$this->CI->db->update("users", $data);
		
		return $pass;
	}
		
	private function _auth_user($user, $pass = null) {
		if ($pass) {
			$pass = md5($pass);
			$user = $this->CI->db->get_where("users", array('username'=>$user, 'password'=>$pass));
		} else {
			$user = $this->CI->db->get_where("users", array('username'=>$user));
		}
		
		if ($user->num_rows() > 0) {
			$this->logged_in = true;
			$this->data = $user->row();
			return true;
		} else {
			$this->logged_in = false;
			return false;
		}
	}
	
}

?>