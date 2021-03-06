<?php

class Dream_Model extends Model {
	
	function Dream_Model() {
		parent::Model();
		$this->user->set();
		$this->user_id = $this->user->data->user_id;
		$this->created_at = now();
	}
	
	var $content = "";
	var $sleep_hours = "";
	var $user_id;
	var $created_at;
	var $results;
	var $from_user = null;
	var $follow_only = false;
	var $popular = false;
	var $per_page = 20;
	var $page = 1;
		
	function insert_dream() {
		$data['content'] = $this->content;
		$data['sleep_hours'] = $this->sleep_hours;
		$data['created_at'] = $this->created_at;
		$data['user_id'] = $this->user_id;
		
		if ($this->content !='') {
			$this->db->insert("dreams", $data);
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
	
	function pagination() {
		$offset = ($this->page-1)*$this->per_page;
		$this->db->limit($this->per_page, $offset);
	}
	
	function get_dream($id) {
		$dream = $this->db->get_where("dreams", array("dream_id"=>$id));
		return $dream->row();
	}
	
	function get_dreams($id = null) {
		$user_id = $this->user->data->user_id;
		$this->db->select("dreams.*, users.fullname, users.username, users.twitter, (SELECT COUNT(comments.comment_id) FROM comments WHERE comments.dream_id=dreams.dream_id) AS num_comments, (SELECT COUNT(likes.user_id) FROM likes WHERE likes.dream_id=dreams.dream_id) AS num_likes", FALSE);
		$this->db->from("dreams");
		$this->db->distinct();
		$this->db->join("users", "users.user_id = dreams.user_id", "left");
		if ($id) $this->db->where("dream_id", $id);
		if ($this->follow_only) $this->db->join("(SELECT follow_id FROM follows WHERE follows.user_id='$user_id') AS something", "dreams.user_id=follow_id");
		if ($this->from_user) $this->db->where('username', $this->from_user);
		if ($this->popular) {
			$this->db->order_by("num_likes", "desc");
			$this->db->join("likes", "likes.dream_id=dreams.dream_id");
		}
		$this->pagination();
		$this->db->order_by("created_at", "desc");
		$query = $this->db->get();
		
		$this->results = $query->result();
		$this->process_dreams();
		return $this->results;
	}
	
	function process_dreams() {
		foreach($this->results as &$dream) {
			$dream->content = find_links($dream->content);
			$dream->content = find_at_user($dream->content);
			$dream->smart_timestamp = smart_timestamp($dream->created_at);
			$dream->iso_timestamp = date("c", $dream->created_at);
			$dream->full_timestamp = date("l, F j, Y \a\\t g:ia", $dream->created_at);
			$dream->date_for = date("l", $dream->created_at);

			$dream->user_liked = $this->Comment_Model->user_liked($this->user->data->user_id, $dream->dream_id);
			//$dream->likes = $this->Comment_Model->get_likes($dream->dream_id);
		}
	}
	
	
}

?>