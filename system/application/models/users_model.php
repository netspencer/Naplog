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
	
	function list_twitter_following($twitter_user) {
		$following = $this->twitter->call("statuses/friends", array("screen_name"=>$twitter_user, "cursor"=>"-1"));
		$follow_array = array();
		do {
			$next = $following->next_cursor_str;
			foreach($following->users as $follower) {
				$follow_array[] = $follower->screen_name;
			}
			$following = $this->twitter->call("statuses/friends", array("screen_name"=>$twitter_user, "cursor"=>$next));
		} while ($next > 0);
		$following = $follow_array;
		
		return $following;
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
		
	function get_user($user) {
		$user = $this->user->get_user($user);
		
		if ($this->user->data->user_id == $user->user_id) {
			$user->is_self = true;
		} else {
			$user->is_self = false;
		}
		
		return $user;
	}
	
}

?>