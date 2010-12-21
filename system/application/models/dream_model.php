<?php

class Dream_Model extends Model {
	
	function Dream_Model() {
		parent::Model();
		$this->user->set();
	}
	
	var $content = "";
	var $sleep_hours = "";
	var $results;
	var $from_user = null;
	var $follow_only = false;
	var $popular = false;
	var $per_page = 20;
	var $page = 1;
		
	function insert_dream() {
		$data['content'] = $this->content;
		$data['sleep_hours'] = $this->sleep_hours;
		$data['created_at'] = now();
		$data['user_id'] = $this->user->data->user_id;
		
		if ($this->content !='') {
			$this->db->insert("dreams", $data);
			return true;
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
	
	function get_dreams() {
		$user_id = $this->user->data->user_id;
		$this->db->select("dreams.*, users.fullname, users.username, users.twitter, (SELECT COUNT(comments.comment_id) FROM comments WHERE comments.dream_id=dreams.dream_id) AS num_comments, (SELECT COUNT(likes.user_id) FROM likes WHERE likes.dream_id=dreams.dream_id) AS num_likes", FALSE);
		$this->db->from("dreams");
		$this->db->distinct();
		$this->db->join("users", "users.user_id = dreams.user_id", "left");
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
			$dream->smart_timestamp = smart_timestamp($dream->created_at);
			$dream->full_timestamp = date("l, F j, Y \a\\t g:ia", $dream->created_at);
			$dream->date_for = date("l", $dream->created_at);
			$dream->links = $this->find_links(&$dream->content);
			
			$dream->likes = $this->Comment_Model->get_likes($dream->dream_id);
		}
	}
	
	function find_links($text) {
		$url_search = "@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@";
		$url_replace = "<a href=\"$1\">$1</a>";
		$text = preg_replace($url_search,$url_replace,$text);
		
		preg_match($url_search,$text,$links);
		
		return $links;
	}
	
}

?>