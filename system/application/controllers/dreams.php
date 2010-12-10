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
		echo $this->comment->num_comments($id);
	}
	
	function like($id) {
		$this->comment->dream_id = $id;
		$this->comment->like();
		
		redirect("dreams");
	}
	
	function sample_comment() {
		$this->comment->dream_id = 59;
		$this->comment->content = "Oh hello!";
		$this->comment->insert_comment();
		
		echo "it worked";
	}
}

?>