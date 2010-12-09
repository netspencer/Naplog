<?php

class Follow_Model extends Model {

	function Follow_Model() {
		parent::Model();
		$this->user->set();
	}
	
	function does_follow($follow_id, $user_id = null) {
		if (empty($user_id)) $user_id = $this->user->data->user_id;
		$data['user_id'] = $user_id;
		$data['follow_id'] = $follow_id;
		
		$query = $this->db->get_where("follows", $data);
		$num_rows = $query->num_rows();
		
		if ($num_rows>0) {
			return true;
		} else {
			return false;
		}
	}
	
	function follow($follow_id, $user_id = null) {
		if (empty($user_id)) $user_id = $this->user->data->user_id;
		$data['user_id'] = $user_id;
		$data['follow_id'] = $follow_id;
		
		if (!$this->does_follow($follow_id, $user_id)) $this->db->insert("follows", $data);
	}
	
	function unfollow($follow_id, $user_id = null) {
		if (empty($user_id)) $user_id = $this->user->data->user_id;
		$data['user_id'] = $user_id;
		$data['follow_id'] = $follow_id;
		
		$this->db->delete("follows", $data);
	}
	
	function toggle($follow_id, $user_id = null) {
		if ($this->does_follow($follow_id, $user_id)) {
			$this->unfollow($follow_id, $user_id);
			return "unfollow";
		} else {
			$this->follow($follow_id, $user_id);
			return "follow";
		}
	}
	
}

?>