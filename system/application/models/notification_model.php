<?php

class Notification_Model extends Model {
	
	function Notificaton_Model() {
		parent::Model();
	}
	
	var $user_id = null;
	var $subscription_id = null;
	var $type = null;
	var $data = null;
	var $notification = null;
	
	function get($user_id = null) {
		if (!$user_id) $user_id = $this->user->data->user_id;
		
		$this->db->where("user_id", $user_id);
		$query = $this->db->get("notifications");
		$notifications = $query->result();
		
		
		foreach($notifications as $notification) {
			$results[] = $this->_build_notification($notification);
		}
		
		return $results;
	}
	
	function notify_comment($comment_id) {
		$this->type = "commented";
		$this->data['comment_id'] = $comment_id;
		
		$this->db->select("comments.dream_id, comments.user_id, dreams.user_id AS user_id2");
		$this->db->where("comment_id", $comment_id);
		$this->db->join("dreams", "dreams.dream_id = comments.dream_id");
		$query = $this->db->get("comments");
		$comment = $query->row();
		
		$this->db->select("comments.user_id");
		$this->db->distinct();
		$this->db->where("dream_id", $comment->dream_id);
		$this->db->where("user_id !=", $comment->user_id);
		$query = $this->db->get("comments");
		$comments = $query->result();
		
		foreach($comments as $item) {
			$user_ids[] = $item->user_id;
		}
		
		if ($comment->user_id2 != $comment->user_id) $user_ids[] = $comment->user_id2;
	
		$users_ids = array_unique($user_ids);
		foreach ($user_ids as $user_id) {
			$this->user_id = $user_id;
			$this->_create();
		}
	}
		
	function _create() {
		$data['user_id'] = $this->user_id;
		$data['type'] = $this->type;
		$data['data'] = json_encode($this->data);
		$data['timestamp'] = now();
		
		$this->db->insert("notifications", $data);
	}
	
	function _get_notification($id) {
		$this->db->where("notification_id", $id);
		$query = $this->db->get("notifications");
		return $this->_build_notification($query->row());
	}
	
	private function _build_notification($notification) {
		$this->notification = $notification;
		$this->notification->data = json_decode($this->notification->data);
		
		switch($this->notification->type) {
			case "commented":
				return $this->_build_notification__commented();
				break;
			case "followed":
				return $this->_build_notification__followed();
				break;
			default:
				return print_r($this->notification, true);
				break;
		}
	}
		
	private function _build_notification__commented() {
		$comment_id = $this->notification->data->comment_id;
		
		$this->db->select("comments.*, u1.fullname, u1.username, dreams.user_id, u2.fullname AS fullname2, u2.username AS username2, u2.user_id as user_id2");
		$this->db->where("comment_id", $comment_id);
		$this->db->join("users u1", "u1.user_id = comments.user_id");
		$this->db->join("dreams", "dreams.dream_id = comments.dream_id");
		$this->db->join("users u2", "u2.user_id = dreams.user_id");
		$query = $this->db->get("comments");
		$comment = $query->row();
		
		//if ($comment->user_id = $this->notification->user_id) $comment->fullname = "You";
		
		if ($comment->user_id2 == $this->notification->user_id) {
			$notification->text = "$comment->fullname commented on a your dream";
		} elseif ($this->notification->data->at_mention) {
			$notification->text = "$comment->fullname mention you in a comment";
		} else {
			$notification->text = "$comment->fullname also commented on $comment->fullname2's dream";
		}
		$notification->link = base_url()."dream/$comment->dream_id#comment_$comment->comment_id";
				
		return $notification;
	}
	
	private function _build_notification__followed() {
		$user_id = $this->notification->data->user_id;
		
		$this->db->select("users.fullname, users.username");
		$this->db->where("user_id", $user_id);
		$query = $this->db->get("users");
		$user = $query->row();
		
		$notification->text = "$user->fullname is now following you";
		$notification->link = base_url()."user/$user->username";
		
		return $notification;
	}
	
}

?>