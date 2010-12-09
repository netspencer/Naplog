<?php

class People extends Controller {
	
	function People() {
		parent::Controller();
		$this->load->model("Users_Model");
		$this->load->model("Follow_Model");
		$this->user->set();
		$this->user->require_login();
		
	}
	
	function index() {
		$this->Users_Model->list_users();
		$this->Users_Model->find_does_follow();
		
		$data['people'] = $this->Users_Model->users;
		
		$this->carabiner->css("people.css");
		
		$this->theme->set_title("People");
		$this->theme->set_current("people");
		$this->theme->load_page("people", $data);
		
	}
	
	function follow($id) {
		$this->Users_Model->follow($id);
	}
	
}


?>