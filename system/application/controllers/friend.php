<?php

class Friend extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('friend_model');
	}
	
	function friends()
	{
		$user_id = $this->user_model->currentUser();
		$userInfo = $this->user_model->userData($user_id);
		$friendArray = $this->user_model->getFriends($user_id);
		$data['friends'] = $friendArray['friends'];
		$data['requests'] = $friendArray['requests'];
		$data['title'] = $userInfo['fname'];
		$this->load->view('friends', $data);
	}
}
	
?>