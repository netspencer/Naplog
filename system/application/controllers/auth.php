<?php

class Auth extends Controller {
	
	function Auth() {
		parent::Controller();
		$this->load->helper("form");
		$this->load->library("form_validation");
		$this->load->library("input");
		$this->load->library("twitter");
		$this->load->library("session");
	}
		
	function login() {
		$this->form_validation->set_message("badpass", "The username or password are incorrect.");
		$this->form_validation->set_rules("username", "Username", "required|trim");
		$this->form_validation->set_rules("password", "Password", "required");
		
		if ($this->form_validation->run()) {
			$user = $this->input->post("username");
			$pass = $this->input->post("password");
			
			if ($this->user->login($user, $pass)) redirect();
		}
		
		$this->theme->body_class = "landing_page";
		$this->theme->inc_nav = false;
		$this->carabiner->css("login.css");

		$this->theme->set_title("Login");
		$this->theme->load_page("login", $data);
	}
	
	function logout() {
		$this->user->logout();
		redirect();
	}
	
	function twitter() {
		$consumer_key = $this->config->item('twitter_consumer_key');
		$consumer_key_secret = $this->config->item('twitter_consumer_key_secret');
			
		$auth = $this->twitter->oauth($consumer_key, $consumer_key_secret, NULL, NULL);
		$this->user->add_twitter_tokens((int)$this->user->data->user_id, $auth);
	}
	
}


?>