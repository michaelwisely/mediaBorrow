<?php

class Friend extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('friend_model');
	}
	
	function index()
	{
		$user_id = $this->user_model->currentUser();
		$userInfo = $this->user_model->userData($user_id);
		$friendArray = $this->friend_model->getFriends($user_id);
		$data['friends'] = $friendArray['friends'];
		$data['requests'] = $friendArray['requests'];
		$data['title'] = $userInfo['fname'];
		$this->load->view('friends', $data);
	}
	
	function request()
	{
		if($_POST == NULL)
		{
			$friendee = $this->uri->segment(3);
			$friender = $this->session->userdata('user_id');
			if($friender == $friendee)
				redirect('');
				
			$friendee = $this->user_model->userData($friendee);
			$data['title'] = 'Confirm Friend Request';
			$data['message'] = 'Are you sure you want to be friends with '.$friendee['fname'].' '.$friendee['lname'].'?';
			$data['id'] = $friendee['user_id'];
			$data['function'] = 'friend/request';
			
			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$this->friend_model->requestFriend($this->session->userdata('user_id'), $_POST['id']);
			
			$data['title'] = 'Request Sent';
			$data['message'] = 'Your friend request has been sent';
			
			$this->load->view('confirmation', $data);
		}
	}
}
	
?>