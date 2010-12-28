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
		$this->db->order_by("timestamp", "desc");
		$query = $this->db->get("notifications");
		$notifications = $query->result();
		
		
		foreach($notifications as $notification) {
			$results[] = $this->_build_notification($notification);
		}
		
		return $results;
	}
	
	function mark($notification_id, $as = "read") {
		switch($as) {
			case "read":
				$data['read'] = 1;
				break;
			case "unread":
				$data['read'] = 0;
				break;
		}
		
		$this->db->where("notification_id", $notification_id);
		$this->db->update("notifications", $data);
	}
	
	function notify_comment($comment_id, $options = null) {
		$this->type = "commented";
		$this->data['comment_id'] = $comment_id;
		
		$dreamer = isset($options['dreamer']) ? $options['dreamer'] : true;
		$sibling_comments = isset($options['sibling_comments']) ? $options['sibling_comments'] : false;
		$at_mention = isset($options['at_mention']) ? $options['at_mention'] : true;
		
		$user_ids = null;
		
		if ($dreamer) {
			$this->db->select("comments.dream_id, comments.user_id, comments.content, dreams.user_id AS user_id2");
			$this->db->where("comment_id", $comment_id);
			$this->db->join("dreams", "dreams.dream_id = comments.dream_id");
			$this->db->where("comments.user_id != dreams.user_id");
			$this->db->where_not_in("comments.user_id", $user_ids);
			$query = $this->db->get("comments");
			$comment = $query->row();

			$this->user_id = $comment->user_id2;
			$this->_create();
			$user_ids[] = $this->user_id;
		}
		
		if ($at_mention) {
			$users = list_at_user($comment->content);
			
			$this->data['at_mention'] = true;
			foreach($users as $user) {
				$user = $this->Users_Model->get_user($user);
				if ($user && $user->user_id != $comment->user_id && !in_array($user->user_id, $user_ids)) {
					$this->user_id = $user->user_id;
					$this->_create();
					$user_ids[] = $this->user_id;
				}
			}
			$this->data['content'] = null;
		}
		
		if ($sibling_comments) {
			$this->db->select("comments.user_id");
			$this->db->distinct();
			$this->db->where("dream_id", $comment->dream_id);
			$this->db->where("user_id !=", $comment->user_id);
			$this->db->where("user_id !=", $comment->user_id2);
			$this->db->where_not_in("comments.user_id", $user_ids);
			$query = $this->db->get("comments");
			$comments = $query->result();

			foreach($comments as $item) {
				$this->user_id = $item->user_id;
				$this->_create();
				$user_ids[] = $this->user_id;
			}
		}
	}
		
	function _create() {
		$data['user_id'] = $this->user_id;
		$data['type'] = $this->type;
		$data['data'] = json_encode($this->data);
		$data['timestamp'] = now();
		
		$this->db->insert("notifications", $data);
		return $this->db->insert_id();
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
				$notification = $this->_build_notification__commented();
				break;
			case "followed":
				$notification = $this->_build_notification__followed();
				break;
			default:
				$notification = $this->notification;
				break;
		}
		$notification->link = "notification/load/".$this->notification->notification_id;
		$notification->obj = $this->notification;
		return $notification;
	}
		
	private function _build_notification__commented() {
		$comment_id = $this->notification->data->comment_id;
		
		$this->db->select("comments.*, u1.fullname, u1.username, u1.twitter, dreams.user_id, u2.fullname AS fullname2, u2.username AS username2, u2.user_id as user_id2");
		$this->db->where("comment_id", $comment_id);
		$this->db->join("users u1", "u1.user_id = comments.user_id");
		$this->db->join("dreams", "dreams.dream_id = comments.dream_id");
		$this->db->join("users u2", "u2.user_id = dreams.user_id");
		$query = $this->db->get("comments");
		$comment = $query->row();
		
		//if ($comment->user_id = $this->notification->user_id) $comment->fullname = "You";
		
		if ($comment->user_id2 == $this->notification->user_id) {
			$notification->text = "$comment->fullname commented on your dream";
		} elseif ($this->notification->data->at_mention) {
			$notification->text = "$comment->fullname mentioned you in a comment";
		} else {
			$notification->text = "$comment->fullname also commented on $comment->fullname2's dream";
		}
		$notification->user->twitter = $comment->twitter;
		$notification->direct_link = "dream/$comment->dream_id#comment_$comment->comment_id";
				
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