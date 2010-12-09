<?php

class Notify {
	
	var $subject = "";
	var $content = "";
	var $response_to_content = null;
		
	function Notify() {
		$this->CI =& get_instance();
		$this->CI->load->library("postmark");
		$this->CI->load->model("Dream_Model", "dream");
	}
	
	function to_user($id) {
		$user = $this->CI->user->get_user($id);
		$this->to_user_id = $user->user_id;
		$this->to_user_name = $user->fullname;
		$this->to_user_email = $user->email;
	}
	
	function from_user($id) {
		$user = $this->CI->user->get_user($id);
		$this->from_user_id = $user->user_id;
		$this->from_user_name = $user->fullname;
		$this->from_user_avatar = "http://img.tweetimag.es/i/".$user->twitter."_b";
	}
	
	function response_to_dream($id, $set_user=false) {
		$dream = $this->CI->dream->get_dream($id);
		$this->response_to_content = $dream->content;
		if ($set_user) $this->to_user($dream->user_id);
	}
	
	function build_subject($action, $and_body=false) {
		switch ($action) {
			case "liked":
				$this->subject = $this->from_user_name." liked your dream";
				if ($and_body) $this->content = "Congrats! Someone likes your dream...";
				break;
			case "commented":
				$this->subject = $this->from_user_name." commented on your dream";
				break;
		}
	}
	
	function send() {
		$this->CI->postmark->to($this->to_user_email, $this->to_user_name);
		$this->CI->postmark->subject($this->subject);
		
		$data['subject'] = $this->subject;
		$data['avatar'] = $this->from_user_avatar;
		$data['content'] = $this->content;
		$data['response_to_content'] = $this->response_to_content;
		$html = $this->CI->load->view("email/activity", $data, true);		
		$this->CI->postmark->message_html($html);
		$this->CI->postmark->send();		
	}
	
}

?>