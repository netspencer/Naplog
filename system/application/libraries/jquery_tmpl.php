<?php

class jquery_tmpl {
	
	function jquery_tmpl() {
		$this->CI =& get_instance();
	}
	
	private $templates = array();
	private $tmpl;
	private $tmpl_string;
	
	public function add($tmpl) {
		if (is_array($tmpl)) {
			$this->templates = array_merge($this->templates, $tmpl);
		} else {
			$this->templates[] = $tmpl;
		}
	}
	
	public function display($echo = true) {
		$this->_build_tmpl_loop();
		if ($echo) {
			echo $this->tmpl_string;
		} else {
			return $this->tmpl_string;
		}
	}
	
	private function _get($tmpl) {
		$this->tmpl = $this->CI->load->view("tmpl/".$tmpl, null, true);
		
		return $this->tmpl;
	}
	
	private function _build_tmpl_loop() {
		if ($this->templates) $return = "<!-- jquery tmpl -->\n";
		foreach($this->templates as $tmpl) {
			$return .= "<script id=\"tmpl_$tmpl\" type=\"text/x-jquery-tmpl\">";
			$return .= "\n";
			$return .= $this->_get($tmpl);
			$return .= "\n";
			$return .= "</script>";
			$return .= "\n";
		}
		if ($this->templates) $return .= "<!-- end jquery tmpl -->";
		
		$this->tmpl_string = $return;
	}
	
}

?>