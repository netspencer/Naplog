<?php

class Test extends Controller {
	
	function Test() {
		parent::Controller();
		$this->user->set();
		$this->load->model("follow_model", "follow");
	}
	
	function index() {
		echo "test";
		if ($this->follow->does_follow(12)) {
			echo "yes";
		} else {
			echo "no";
		}
		
		$this->follow->follow(12);
	}
	
}

?>