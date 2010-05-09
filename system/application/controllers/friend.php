<?php
/*****************************************************************************
 *  friend.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding friendships. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, loads friend model
 *  index -- prepares a page to list all friends of a user pending and current
 *  request -- prepares a page allowing a user to request another user to be friends. adds pending friendship to database
 *  confirm -- prepares a page which allows a user to confirm a friendship, and changes pending friendship to non-pending
 *  reject -- prepares a page which allows a user to refuse a friendship, and removes the friendship from the db on confirmation
 *  delete -- prepares a page allowing users to delete existing non-pending friendships from the database
 *
 ****************************************************************************/

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

	function confirm()
	{
		if($_POST == NULL)
		{
			$requestor = $this->uri->segment(3);
			$requestor = $this->user_model->userData($requestor);
			$acceptor = $this->session->userdata('user_id');

			$data['function'] = 'friend/confirm';
			$data['title'] = 'Confirm Friend Request';
			$data['message'] = 'Are you sure you want to be friends with ' .$requestor['fname']. ' ' .$requestor['lname'].'?';
			$data['id'] = $requestor['user_id'];

			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$requestor = $this->user_model->userData($_POST['id']);
			$acceptor = $this->session->userdata('user_id');
			$this->friend_model->acceptFriendRequest($_POST['id'], $acceptor);

			$data['title'] = 'Friendship Confirmed';
			$data['message'] = 'Your friendship with ' .$requestor['fname']. ' ' .$requestor['lname']. ' is confirmed';

			$this->load->view('confirmation', $data);
		}
	}

	function reject()
	{
		if($_POST == NULL)
		{
			$requestor = $this->uri->segment(3);
			$requestor = $this->user_model->userData($requestor);

			$data['function'] = 'friend/reject';
			$data['title'] = 'Confirm Rejected Friendship';
			$data['message'] = 'Are you sure you want to reject '.$requestor['fname']. ' ' .$requestor['lname']."'s frienship?";
			$data['id'] = $requestor['user_id'];

			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$acceptor = $this->session->userdata('user_id');
			$requestor = $this->user_model->userData($_POST['id']);
			$this->friend_model->denyFriendRequest($_POST['id'], $acceptor);
			$data['title'] = 'Friendship Rejected';
			$data['message'] = 'Your friendship with '.$requestor['fname']. ' '.$requestor['lname']. 'has been rejected';
			
			$this->load->view('confirmation', $data);
		}
	}
	
	function delete()
	{
		if($_POST == NULL)
		{
			$victim = $this->uri->segment(3);
			$victim = $this->user_model->userData($victim);

			$data['function'] = 'friend/delete';
			$data['title'] = 'Delete Friend';
			$data['message'] = 'Are you sure you want to delete your friendship with '.$victim['fname']. ' ' .$victim['lname']."?";
			$data['id'] = $victim['user_id'];

			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$acceptor = $this->session->userdata('user_id');
			$requestor = $this->user_model->userData($_POST['id']);
			$this->friend_model->denyFriendRequest($_POST['id'], $acceptor);
			$data['title'] = 'Friendship Rejected';
			$data['message'] = 'Your friendship with '.$requestor['fname']. ' '.$requestor['lname']. 'has been rejected';
			
			$this->load->view('confirmation', $data);
		}
	}
}
?>