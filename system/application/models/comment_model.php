<?php

class Comment_Model extends Model {
	
	function Comment_Model() {
		parent::Model();
		$this->user->set();
	//	$this->load->library("Notify");
	}
	
	var $content = "";
	var $dream_id = "";
	var $comments = null;
	
	function test() {
	 	return "test";
	}
	
	function like() {
		$data['user_id'] = $this->user->data->user_id;
		$this->notify->from_user($this->user->data->user_id);
		$data['dream_id'] = $this->dream_id;
		$this->notify->response_to_dream($this->dream_id, true);
		$this->db->where("user_id", $this->user->data->user_id);
		$this->db->where("dream_id", $this->dream_id);
		$this->notify->build_subject("liked", true);
		
		$return['user'] = $this->user->data->username;
		$return['dream'] = $this->dream_id;
		if (!$this->db->count_all_results("likes")) {
			$this->db->insert("likes", $data);
			$return['action'] = "liked";
			$this->notify->send();
		} else {
			$return['action'] = "nothing";
			$return['error'] = "already liked";
		}
		
		return $return;
	}
	
	function insert_comment() {
		$data['user_id'] = $this->user->data->user_id;
		$this->notify->from_user($this->user->data->user_id);
		$data['dream_id'] = $this->dream_id;
		$this->notify->response_to_dream($this->dream_id, true);
		$data['created_at'] = now();
		$data['content'] = $this->content;
		$this->notify->content = $this->content;
		$this->notify->build_subject("commented");
		
		$this->db->insert("comments", $data);
		$this->notify->send();
	}
	
	function get_comments($dream_id) {
		$comments = $this->db->get_where("comments", array("dream_id"=>$dream_id));
		$this->comments = $comments->result();
		
		return $this->comments;
	}
	
	function get_likes($dream_id, $limit=14) {
		$this->db->limit($limit);
		$this->db->select("likes.user_id, users.twitter, users.username");
		$this->db->join("users", "users.user_id = likes.user_id", "left");
		$likes = $this->db->get_where("likes", array("dream_id"=>$dream_id));
		$likes->list = $likes->result();
		$likes->num = $likes->num_rows();
				
		return $likes;
	}
		
}


?>