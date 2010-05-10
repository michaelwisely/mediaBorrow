<?php
/*****************************************************************************
 *  refer.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying referrals users make to potential users. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, calls parent constructor
 *  Index -- prepares the page to make referrals and prepares an email to be sent
 *
 ****************************************************************************/
class Refer extends MY_Controller
{
	/*******************************************************************
	 * __construct -- constructor for the Refer class
	 * @pre - none
	 * @post - calls the parent constructor.
	*******************************************************************/
	function __construct()
	{
		parent::__construct();
	}
	/*******************************************************************
	 * index -- prepares the page for making referrals to the site.
	 * @pre - user is logged in
	 * @post - initially users are taken to the refer view, then after
	 * 	submitting, their information is prepared to be sent by email
	 * 	(which doesn't work) and a confirmation view is loaded.
	*******************************************************************/
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
				$email = 'You have been invited to <a href="http://www.mediaBorrow.com">MediaBorrow</a> by'.$sender.'.<br />It will be fun.';
				
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