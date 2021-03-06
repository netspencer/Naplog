<?php

class Dreams extends Controller {
	
	function Dreams() {
		parent::Controller();
		$this->load->model("Dream_Model", "dream");
		$this->load->model("Comment_Model", "comment");
		$this->user->set();
		$this->user->require_login();
		$this->current_section = "everything";
	}
	
	function index() {
		$this->following();
	}	
	
	function everything() {
		$data['dreams'] = $this->dream->get_dreams();
		$data['current_section'] = $this->current_section;
		
		$this->carabiner->css("dreams.css");
		
		$this->theme->set_title("Dreams");
		$this->theme->set_title("Everything");
		$this->theme->set_current("dreams");
		$this->theme->load_page("dreams", $data);
	}
	
	function following() {
		$this->current_section = "following";
		$this->dream->follow_only = true;
		$this->everything();
	}
	
	function popular() {
		$this->current_section = "popular";
		$this->dream->popular = true;
		$this->everything();
	}
	
	function view($id) {
		$this->jquery_tmpl->add("comment");
		$this->jquery_tmpl->add("like");
		
		$data['username'] = "pizza";
		$data['dreams'] = $this->Dream_Model->get_dreams($id);
		$data['likes'] = $this->Comment_Model->get_likes($id, false);
		$this->Comment_Model->order = "desc";
		$data['comments'] = $this->Comment_Model->get_comments($id);
		if (!$data['dreams']) redirect('/');
				
		$this->carabiner->css("dreams.css");
		
		$this->theme->set_title("Dream ".$id);
		$this->theme->load_page("dream", $data);
	}
	
}

?>