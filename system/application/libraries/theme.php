<?php

class Theme {
	
	private $CI;
	private $page_title = "Naplog";
	private $current_page = "";
	public $inc_nav = TRUE;
	public $body_class = null;
	
	function Theme() {
		$this->CI =& get_instance();
	}
	
	function set_current($page) {
		$this->current_page = $page;
	}
	
	function set_title($title) {
		$this->page_title .= " | ".$title;
	}
	
	function load_base_css() {
		$this->CI->carabiner->css("reset.css");
		$this->CI->carabiner->css("960.css");
		//$this->CI->carabiner->css("tipsy.css");
		$this->CI->carabiner->css("base.css");
	}
	
	function load_base_js() {
		$this->CI->carabiner->js("https://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js");
		$this->CI->carabiner->js("jquery.autogrow-textarea.js");
		//$this->CI->carabiner->js("jquery.tipsy.js");
		$this->CI->carabiner->js("main.js");
	}
	
	function build_header() {
		$this->load_base_css();
		$this->load_base_js();
		
		$data['page_title'] = $this->page_title;
		$data['current'] = $this->current_page;
		$data['body_class'] = $this->body_class;
		
		if ($this->CI->user->data->username) {
			$data['username'] = $this->CI->user->data->username;
		} else {
			$data['username'] = null;
		}
		$this->CI->load->view("inc/header", $data);
	/*	if ($this->inc_nav) {
			$this->CI->load->view("inc/nav", $data);
		}*/
		
		$this->CI->load->view("inc/nav2", $data);
	}
	
	function load_page($page, $data = null) {
		$this->build_header();
		$this->CI->load->view("page/$page", $data);
		$this->CI->load->view("inc/footer");
	}
	
}

?>