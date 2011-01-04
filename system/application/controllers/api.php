<?php

class API extends REST_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model("Dream_Model", "dream");
		$this->load->model("Comment_Model", "comment");
		$this->load->model("Follow_Model", "follow");
		$this->user->set();		
	}
	
	function like_dream_post() {
		$this->comment->dream_id = $this->post("dream_id");
		$response = $this->comment->like();
		
		$likes = $this->comment->get_likes($this->post("dream_id"));
		
		$response['num_likes'] = $likes->num;
		$this->response($response);
	}	
	
	function comment_dream_post() {
		$this->comment->dream_id = $this->post("id");
		$this->comment->content = $this->post("content");
		$comment = $this->comment->insert_comment();
		$comment = $this->load->view("partial/comment", $comment[0], true);
		$this->response($comment);
	}
	
	function get_likes_post() {
		if ($this->post("like")) {
			$this->comment->dream_id = $this->post("dream_id");
			$echo = $this->comment->like();
		}
		
		$likes = $this->comment->get_likes($this->post("dream_id"));
		$data['likes'] = $likes->list;
		$data['num_likes'] = $likes->num;
		
		$response['html'] = $this->load->view("inc/list_likes", $data, true);
		$response['num_likes'] = $likes->num;
		
		$this->response($response);
	}
	
	function test_get() {
		$email = $this->get("email");
		$user = $this->user->get_user(null,$email);
		
		$this->response($user->user_id);
	}
	
	function post_via_email_post() {
		$this->dream->content = $this->post("plain");
		$email = $this->post("from");
		$user = $this->user->get_user(null,trim($email));
		$this->dream->user_id = $user->user_id;
		$this->dream->user_id = 1;
		$this->dream->content = $email." ".print_r($user, true);
		$dream = $this->dream->insert_dream();
		$this->response($dream);
	}
	
	function load_more_dreams_get() {
		if ($this->get("page")) {
			$this->dream->page = $this->get("page");
		}
		$section = $this->get("section");
		
		switch($section) {
			case "popular":
				$this->dream->popular = true;
				break;
			case "following":
				$this->dream->follow_only = true;
				break;
		}
		
		$data['dreams'] = $this->dream->get_dreams();
		
		$response['html'] = $this->load->view("inc/list_dreams", $data, true);
		//$response = $data['dreams'];
		$this->response($response);
	}
	
	function follow_user_post() {
		$action = $this->post("action");
		$follow_id = $this->post("follow_id");
		
		switch($action) {
			case "unfollow":
				$this->follow->unfollow($follow_id);
				$response['action'] = "unfollow";
				$response['user_id'] = $follow_id;
				break;
			case "toggle":
				$return = $this->follow->toggle($follow_id);
				$response['action'] = $return;
				$response['user_id'] = $follow_id;
				break;
			default:
				$this->follow->follow($follow_id);
				$response['action'] = "follow";
				$response['user_id'] = $follow_id;
				break;
		}
		
		$this->response($response);
	}
}

?>