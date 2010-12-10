<?php

class Users extends Controller {
	
	function Users() {
		parent::Controller();
		$this->load->model("Dream_Model", "dream");
		$this->load->model("Users_Model");
		$this->load->model("Follow_Model", "follow");
		$this->user->set();
	}
	
	function index() {
		$username = $this->user->data->username;
		redirect("user/$username");
	}
	
	function view($user) {
		$user = $this->Users_Model->get_user($user);
		
		if (!$user) redirect("/");
		
		$this->dream->from_user = $user->username;
		
		$data['dreams'] = $this->dream->get_dreams();
		$data['user_id'] = $user->user_id;
		$data['does_follow'] = $this->follow->does_follow($user->user_id);
		$data['is_self'] = $user->is_self;
							
		$this->carabiner->css("dreams.css");
		$this->carabiner->css("user.css");
		
		$this->theme->set_title($user->fullname);
		if ($user == $this->user->data->username) $this->theme->set_current("account");
		$this->theme->load_page("user", $data);
	}
	
	function settings() {
		$this->load->library("form_validation");
		$this->load->helper("form");
		$this->carabiner->css("settings.css");
		
		$this->form_validation->set_rules("username", "Username", "required");
		$this->form_validation->set_rules("password", "Password", "required");
				
		$this->theme->set_title("Settings");
		$this->theme->set_current("account");
		$this->theme->load_page("user_settings", $data);
	}
	
		
}

?>