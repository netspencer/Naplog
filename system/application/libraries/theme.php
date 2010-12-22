<?php

class Theme {
	
	private $CI;
	private $page_title = "Naplog";
	private $current_page = "";
	public $inc_nav = TRUE;
	public $body_class = null;
	public $data = array();
	
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
		
		$this->data['page_title'] = $this->page_title;
		$this->data['current'] = $this->current_page;
		$this->data['body_class'] = $this->body_class;
		
		if ($this->CI->user->data->username) {
			$this->data['username'] = $this->CI->user->data->username;
		} else {
			$this->data['username'] = null;
		}
		$this->CI->load->view("inc/header", $this->data);
		
		if ($this->inc_nav) $this->CI->load->view("inc/nav", $data);
		
	}
	
	function add_data($new = null) {
		$old = $this->data;
	    $this->data = array_merge($new, $old); // add new data to data object
	}
	
	function load_page($page, $data = null) {
	    $this->add_data($data);
	
		$this->build_header();
		$this->CI->load->view("page/$page", $this->data);
		$this->CI->load->view("inc/footer");
	}
	
}

?>