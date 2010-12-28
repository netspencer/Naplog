<?php

class Users extends Controller {
	
	function Users() {
		parent::Controller();
		$this->load->model("Dream_Model", "dream");
		$this->load->model("Users_Model");
		$this->load->model("Follow_Model", "follow");
		$this->load->model("Comment_Model", "comment");
		
		$this->user->set();
	}
	
	function index() {
		$username = $this->user->data->username;
		redirect("user/$username");
	}
	
	function view($user, $subpage = null) {
		$user = $this->Users_Model->get_user($user);
		
		if (!$user) redirect("/");
				
		if ($subpage == "followers") {
			$data['people'] = $this->follow->get("followers", $user->user_id);
			
			$this->carabiner->css("people.css");
			
			$this->theme->set_title($user->fullname." / Followers");
			$this->theme->load_page("people", $data);
			
			
		} else if ($subpage == "following") {
			$data['people'] = $this->follow->get("following", $user->user_id);
			
			$this->carabiner->css("people.css");
			
			$this->theme->set_title($user->fullname." / Following");
			$this->theme->load_page("people", $data);
			
			
		} else {
			$this->dream->from_user = $user->username;

			$data['dreams'] = $this->dream->get_dreams();
			$data['user_id'] = $user->user_id;
			$data['does_follow'] = $this->follow->does_follow($user->user_id);
			$data['user'] = $user;
			$data['is_self'] = $user->is_self;
			$data['followers_num'] = $this->follow->get_num("followers", $user->user_id);
			$data['following_num'] = $this->follow->get_num("following", $user->user_id);

			$this->carabiner->css("dreams.css");
			$this->carabiner->css("user.css");
			
			$this->theme->set_title($user->fullname);
			if ($user == $this->user->data->username) $this->theme->set_current("account");
			$this->theme->load_page("user", $data);
			
		}
	}
	
	function notifications() {
		$data['notifications'] = $this->Notification_Model->get();
		
		$this->carabiner->css("notifications.css");
		
		$this->theme->set_title("Notifications");
		$this->theme->set_current("account");
		$this->theme->load_page("notifications", $data);
	}
	
	function load_notification($id) {
		$notification = $this->Notification_Model->_get_notification($id);
		
		$user_id = $notification->obj->user_id;
		
		if ($user_id == $this->user->data->user_id) {
			$this->Notification_Model->mark($id);
			redirect($notification->direct_link);
		} else {
			redirect("notifications");
		}
	}
	
	function settings() {
		$this->load->library("form_validation");
		$this->load->helper("form");
		$this->carabiner->css("settings.css");
		
		$this->form_validation->set_rules("fullname", "fullname", "required");
		$this->form_validation->set_rules("nickname", "nickname", "required");
		$this->form_validation->set_rules("username", "username", "required");
		$this->form_validation->set_rules("email", "email", "required|valid_email");
		
		$data['user'] = $this->user->data;
		
		if ($this->form_validation->run()) {
			$modify['fullname'] = $_POST['fullname'];
			$modify['nickname'] = $_POST['nickname'];
			$modify['username'] = $_POST['username'];
			$modify['email'] = $_POST['email'];
			$modify['twitter'] = strip_twitter($_POST['twitter']);
			
			$this->user->modify_user(null, $modify);
			if ($_POST['password']) {
				$this->user->change_password(null, $_POST['password']);
			}
			redirect('/settings');
		} else {
			$this->theme->set_title("Settings");
			$this->theme->set_current("account");
			$this->theme->load_page("user_settings", $data);
		}
		
	}
	
		
}

?>