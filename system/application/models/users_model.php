<?php

class Users_Model extends Model {
	
	var $users = null;
	
	function Users_Model() {
		parent::Model();
		$this->user->set();
	}
	
	function list_users() {
		$user = $this->db->get("users");
		$this->users = $user->result();
		$this->set_self();
				
		return $this->users;
	}
	
	function set_self() {
		foreach($this->users as &$user) {
			if ($this->user->data->user_id == $user->user_id) {
				$user->is_self = true;
			} else {
				$user->is_self = false;
			}
		}
	}
	
	function find_does_follow() {
		foreach($this->users as &$user) {
			$user->does_follow = $this->Follow_Model->does_follow($user->user_id);
		}
		
		return $this->users;
	}
	
	function get_user($user) {
		if (is_int($user)) {
			$data['user_id'] = $user;
		} else {
			$data['username'] = $user;
		}
		$query = $this->db->get_where("users", $data);
		$user = $query->row();
		
		if ($this->user->data->user_id == $user->user_id) {
			$user->is_self = true;
		} else {
			$user->is_self = false;
		}
		
		return $user;
	}
	
}

?>