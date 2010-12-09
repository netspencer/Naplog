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
	
	function get_user($id) {
		$user = $this->CI->db->get_where("users", array("user_id"=>$id));
		return $user->row();
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