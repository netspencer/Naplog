<?php

class Comment_Model extends Model {
	
	function Comment_Model() {
		parent::Model();
		$this->user->set();
		$this->load->library("Notify");
	}
	
	var $content = "";
	var $dream_id = "";
	var $order = "asc";
	
	function test() {
	 	return "test";
	}
	
	function like($action = "like") {
		$data['user_id'] = $this->user->data->user_id;
		$data['dream_id'] = $this->dream_id;
		
		$return['user'] = $this->user->data->username;
		$return['dream'] = $this->dream_id;
		if (!$this->user_liked()) {
			$this->db->insert("likes", $data);
			$like_id = $this->db->insert_id();
			$this->Notification_Model->notify_like($like_id);
			$return['action'] = "liked";
			
		} else {
			$query = $this->db->get_where("likes", $data);
			$like = $query->row();
			$like_id = $like->like_id;
			$return['like_id'] = $like_id;
			$this->db->delete("likes", $data);
			$this->Notification_Model->notify_like($like_id, "unliked");
			$return['action'] = "unliked";
		}
		
		return $return;
	}
	
	function user_liked($user_id = null, $dream_id = null) {
		if ($dream_id) {
			$this->db->where("user_id", $user_id);
		} else {
			$this->db->where("user_id", $this->user->data->user_id);
		}
		if ($dream_id) {
			$this->db->where("dream_id", $dream_id);
		} else {
			$this->db->where("dream_id", $this->dream_id);
		}
		
		if ($this->db->count_all_results("likes")) {
			return true;
		} else {
			return false;
		}
	}
	
	function insert_comment() {
		$data['user_id'] = $this->user->data->user_id;
		$data['dream_id'] = $this->dream_id;
		$data['created_at'] = now();
		$data['content'] = $this->content;
		
		$this->db->insert("comments", $data);
		$comment_id = $this->db->insert_id();
		$result = $this->get_comments(null, $comment_id);
		
		$this->Notification_Model->notify_comment($comment_id);
		
		return $result;
	}
	
	function get_comments($dream_id = null, $comment_id = null) {
		if ($dream_id) $this->db->where("dream_id", $dream_id);
		if ($comment_id) $this->db->where("comment_id", $comment_id);
		$this->db->order_by("created_at", $this->order);
		$this->db->join("users", "users.user_id = comments.user_id");
		$query = $this->db->get("comments");
		$this->comments = $query->result();
		$this->process_comments();
		return $this->comments;
	}
	
	function process_comments() {
		foreach($this->comments as &$comment) {
			$comment->content = find_links($comment->content);
			$comment->content = find_at_user($comment->content);
			$comment->smart_timestamp = smart_timestamp($comment->created_at);
			$comment->iso_timestamp = date("c", $comment->created_at);
			$comment->full_timestamp = date("l, F j, Y \a\\t g:ia", $comment->created_at);
		}
	}
	
	function get_likes($dream_id, $limit=14) {
		if ($limit) $this->db->limit($limit);
		$this->db->order_by("like_id", "asc");
		$this->db->select("likes.user_id, users.twitter, users.username");
		$this->db->join("users", "users.user_id = likes.user_id", "left");
		$likes = $this->db->get_where("likes", array("dream_id"=>$dream_id));
		$likes->list = $likes->result();
		$likes->num = $likes->num_rows();
				
		return $likes;
	}
		
}


?>