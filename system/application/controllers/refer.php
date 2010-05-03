<?php

class Refer extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		if($_POST == NULL)
		{
			$data['user_id'] = $this->user_model->currentUser();
			$data['title'] = 'Refer someone to MediaBorrow';
			
			$this->load->view('refer', $data);
		}
		else
		{
			$data['title'] = 'Invitation Sent';
			
			if($this->query->inviteNewUser($_POST['user_id'], $_POST['email'], $_POST['name']))
			{
				//send an email to the invitee
				$sender = $this->user_model->userData($_POST['user_id']);
				$sender = $sender['fname'].' '.$sender['lname'];
				$email = 'You have been invited to <a href="http://r03mwwcp2.device.mst.edu">MediaBorrow</a> by'.$sender.'.<br />It will be fun.';
				
				$this->load->helper('email');
				send_email($_POST['email'], 'You\'ve been invited to MediaBorrow!', $email);
				
				$data['message'] = 'An invitation has been sent to '.$_POST['name'].'.';
			}
			else
			{
				$data['message'] = 'An invitation has already been sent to '.$_POST['name'].'.';
			}
			$this->load->view('confirmation', $data);
		}
	}
}