<?php

class Auth extends Controller {
	
	function Auth() {
		parent::Controller();
		$this->load->helper("form");
		$this->load->library("form_validation");
		$this->load->library("input");
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
			
		$this->carabiner->css("login.css");

		$this->theme->set_title("Login");
		$this->theme->load_page("login", $data);
	}
	
	function logout() {
		$this->user->logout();
		redirect();
	}
	
}


?>