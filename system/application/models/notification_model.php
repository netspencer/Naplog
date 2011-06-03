<?php

class Notification_Model extends Model {
	
	function Notificaton_Model() {
		parent::Model();
	}
	
	var $user_id = null;
	var $type = null;
	var $item_id = null;
	var $data = null;
	var $notification = null;
	
	function subscribe_types() {
		$this->subscribe_types[] = "comment/dreamer";
		$this->subscribe_types[] = "comment/at_mention";
		$this->subscribe_types[] = "comment/sibling_comments";
		$this->subscribe_types[] = "like";
		$this->subscribe_types[] = "follow";
	}
	
	function get($user_id = null) {
		if (!$user_id) $user_id = $this->user->data->user_id;
		
		$day = 86400;
		$time_ago = now() - ($day*7);
		
		$this->db->where("read", 0);
		$this->db->where("user_id", $user_id);
		
		$this->db->or_where("timestamp >", $time_ago);
		$this->db->where("user_id", $user_id);
		
		$this->db->order_by("timestamp", "desc");
		$query = $this->db->get("notifications");
		$notifications = $query->result();
		
		foreach($notifications as $notification) {
			$results[] = $this->_build_notification($notification);
		}
		
		return $results;
	}
	
	function unread_count($user_id = null) {
		if (!$user_id) $user_id = $this->user->data->user_id;
				
		$this->db->where("user_id", $user_id);
		$this->db->where("read", 0);
		$query = $this->db->get("notifications");
		$count = $query->num_rows();
		
		return $count;
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
	
	function mark_all($user_id = null, $as = "read") {
	    if (!$user_id) $user_id = $this->user->data->user_id;
	    
	    switch($as) {
			case "read":
				$data['read'] = 1;
				break;
			case "unread":
				$data['read'] = 0;
				break;
		}
		
		$this->db->where("user_id", $user_id);
		$this->db->update("notifications", $data);
	}
	
	function notify_follow($user_id, $followed_id) {
		$this->type = "follow";
		$this->user_id = $user_id;
		$this->item_id = $followed_id;
		
		$this->_create();
	}
	
	function notify_like($like_id, $action = "liked") {
		$this->type = "like";
		
		switch ($action) {
			case "liked":
				$this->db->select("dreams.user_id, likes.like_id, likes.user_id AS user_id2");
				$this->db->where("likes.user_id != dreams.user_id");
				$this->db->where("like_id", $like_id);
				$this->db->join("dreams", "dreams.dream_id = likes.dream_id");
				$query = $this->db->get("likes");
				$like = $query->row();

				$this->user_id = $like->user_id;
				$this->item_id = $like->like_id;
				
				if ($like) $this->_create();
			break;
			case "unliked":
				$this->item_id = $like_id;
			
				$this->_delete();
			break;
		}
	}
	
	function notify_comment($comment_id, $options = null) {
		$this->type = "comment";
		$this->item_id = $comment_id;
		
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
		$data['item_id'] = $this->item_id;
		if ($this->data) $data['data'] = json_encode($this->data);
		$data['timestamp'] = now();
		
		if ($this->user_id && $this->type && $this->item_id && !$this->_exists()) $this->db->insert("notifications", $data);
		$notification_id = $this->db->insert_id();
		
		return $notification_id;
	}
	
	function _exists() {
		$data['user_id'] = $this->user_id;
		$data['type'] = $this->type;
		$data['item_id'] = $this->item_id;
		
		$query = $this->db->get_where("notifications", $data);
		
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function _delete() {
		if ($this->user_id) $data['user_id'] = $this->user_id;
		if ($this->type) $data['type'] = $this->type;
		if ($this->item_id) $data['item_id'] = $this->item_id;
		
		return $this->db->delete("notifications", $data);
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
			case "comment":
				$notification = $this->_build_notification__comment();
			break;
			case "follow":
				$notification = $this->_build_notification__follow();
			break;
			case "like":
				$notification = $this->_build_notification__like();
			break;
			default:
				$notification = $this->notification;
			break;
		}
		$notification->link = "notification/load/".$this->notification->notification_id;
		$notification->obj = $this->notification;

		$notification->iso_timestamp = date("c", $notification->obj->timestamp);
		$notification->full_timestamp = date("l, F j, Y \a\\t g:ia", $notification->obj->timestamp);
		
		return $notification;
	}
		
	private function _build_notification__comment() {
		$comment_id = $this->notification->item_id;
		
		$this->db->select("comments.*, u1.fullname, u1.username, u1.twitter, dreams.user_id, u2.fullname AS fullname2, u2.username AS username2, u2.user_id as user_id2");
		$this->db->where("comment_id", $comment_id);
		$this->db->join("users u1", "u1.user_id = comments.user_id");
		$this->db->join("dreams", "dreams.dream_id = comments.dream_id");
		$this->db->join("users u2", "u2.user_id = dreams.user_id");
		$query = $this->db->get("comments");
		$comment = $query->row();
		
		//if ($comment->user_id = $this->notification->user_id) $comment->fullname = "You";
		
		if ($comment->user_id2 == $this->notification->user_id) {
			$notification->type = "comment/dreamer";
			$notification->text = "$comment->fullname commented on your dream";
		} elseif ($this->notification->data->at_mention) {
			$notification->type = "comment/at_mention";
			$notification->text = "$comment->fullname mentioned you in a comment";
		} else {
			$notification->type = "comment/sibling_comments";
			$notification->text = "$comment->fullname also commented on $comment->fullname2's dream";
		}
		$notification->user->twitter = $comment->twitter;
		$notification->direct_link = "dream/$comment->dream_id#comment_$comment->comment_id";
				
		return $notification;
	}
	
	private function _build_notification__follow() {
		$user_id = $this->notification->item_id;
		
		$this->db->select("users.fullname, users.username, users.twitter");
		$this->db->where("user_id", $user_id);
		$query = $this->db->get("users");
		$user = $query->row();
		
		$notification->type = "follow";
		$notification->text = "$user->fullname is now following you";
		$notification->user->twitter = $user->twitter;
		
		$notification->direct_link = "user/$user->username";
		
		return $notification;
	}
	
	private function _build_notification__like() {
		$like_id = $this->notification->item_id;
		
		$this->db->select("likes.dream_id, users.fullname, users.twitter, users.username");
		$this->db->where("like_id", $like_id);
		$this->db->join("users", "users.user_id = likes.user_id");
		$query = $this->db->get("likes");
		$like = $query->row();
		
		$notification->type = "like";
		$notification->text = "$like->fullname liked your dream";
		$notification->user->twitter = $like->twitter;
		
		$notification->direct_link = "dream/$like->dream_id";
		
		return $notification;
	}
	
}

?>