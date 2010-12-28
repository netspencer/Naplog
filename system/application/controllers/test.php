<?php

class Test extends Controller {
	
	function Test() {
		parent::Controller();
		$this->user->set();
		$this->load->model("follow_model", "follow");
		$this->load->model("notification_model", "notification");
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
	
	function cool($person) {
	  $cool_people[] = "spencer";
	  $cool_people[] = "kfir";
	  
	  if (in_array($person, $cool_people)) {
	    echo "Yeah, $person is cool!";
	  } else {
	    echo "Sadly, $person isn't so cool.";
	  }
	}
	
	function create_notification() {
		$this->notification->user_id = 1;
		$this->notification->type = "commented";
		$this->notification->data = array("comment_id"=>57, "your_dream"=>true);
		$this->notification->_create();
	}
	
	function notification($id) {
		$notification = $this->notification->_get_notification($id);
		
		echo $notification->text;
		echo "<hr>";
		echo $notification->link;
	}
	
	function notify_like($id) {
		$this->notification->user_id = 23;
		$this->notification->item_id = 504;
		$this->notification->type = "like";
		
		$this->notification->_delete();
	}
	
	function preg() {
		$users = list_at_user("hello @spencer and @kfir");
		
		foreach($users as $user) {
			$user = $this->Users_Model->get_user($user);
			print_r($user);
			echo "<hr>";
		}
	}
	
	function send_notif() {
		$this->load->library("notifo_api");
		$data['to'] = "spencer";
		$data['msg'] = "test";
		$result = $this->notifo_api->send_notification($data);
		print_r($result);
		echo "test";
	}
	
}

?>