<?php

class Dashboard extends Controller {
	
	function Dashboard() {
		parent::Controller();
		$this->load->helper("form");
		$this->load->library("input");
		$this->load->library("Notify");
		$this->load->model("dream_model", "dream");
		$this->load->model("comment_model", "comment");
		
		$this->user->set();
	}
	
	function cool($person = "spencer") {
	    $person = ucfirst($person);
	    echo "$person is cool";
	}
	
	function index() {
		$this->load->library("form_validation");
		$this->form_validation->set_message('required', "Nice try, but you can't dream about nothing, now can you?");
		$this->form_validation->set_rules('content', 'dream', 'required');
		
		if ($this->form_validation->run()) {
			/* form submitted */
			$this->user->require_login();
			$this->dream->content = $this->input->post('content');
			$this->dream->sleep_hours = $this->input->post('sleep');

			$this->dream->insert_dream();

			redirect("/dashboard");
		} else {
			/* form not submitted */
			if ($this->user->logged_in) {
				$this->carabiner->css("dashboard.css");

				$data['nickname'] = $this->user->data->nickname;

				$this->theme->set_title("Dashboard");
				$this->theme->set_current("dashboard");
				$this->theme->load_page("dashboard", $data);
			} else {
				/*
				$this->carabiner->css("welcome.css");
				
				$this->theme->set_title("Welcome");
				$this->theme->inc_nav = FALSE;
				$this->theme->body_class = "landing_page";
				$this->theme->load_page("welcome");
				*/
				$this->theme->body_class = "landing_page";
				$this->carabiner->css("login.css");

				$this->theme->set_title("Login");
				$this->theme->load_page("login", $data);
				
			}
		}
	}
	
}


?>