<?php
/*****************************************************************************
 *  borrow.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding user borrows. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, loads media model and borrow model
 *  request -- allows users to make a request to borrow an item. loads a confirmation page
 *  confirmRequest -- allows users to confirm a request to borrow an item. loads a confirmation page
 *  denyRequest -- allows users to refuse a request to borrow an item. loads a confirmation page
 *  request -- allows users to make a request to borrow an item. loads a confirmation page
 *  handItOver -- allows a user to transfer posession of an item to another user. loads a confirmation page
 *  returnItem -- allows a user to regain posession of an item from another user. loads a confirmation page
 *
 ****************************************************************************/
class Borrow extends MY_controller {
	/*******************************************************************
	 * __construct -- constructor for Borrow class
	 * @pre - none
	 * @post - parent constructor is called and borrow and user models
	 * 	are loaded.
	*******************************************************************/
	function __construct()
	{
		parent::__construct();
		$this->load->model('borrow_model');
		$this->load->model('media_model');
	}
	/*******************************************************************
	 * request -- make a request to borrow something.
	 * @pre - user is logged in, segment 3 of the URL has the media id
	 * 	which is to be borrowed
	 * @post - infirmation regarding the borrow are loaded, if the user
	 * 	already has a request on the item or is actively borrowing it
	 * 	an error is loaded, otherwise the request is recorded
	 * 	and a confirmation view is loaded.
	*******************************************************************/
	function request()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$title = $mediaInfo['title'];
			$owner = $mediaInfo['user_id'];
			$user_id = $this->session->userdata('user_id');
			$data['message'] = "Are you sure you'd like to borrow $title from $owner?";
			$data['title'] = "Borrow $title";
			$data['function'] = '/borrow/request';
			$data['borrower_id'] = $this->session->userdata('user_id');
			$data['id'] = $media_id;
			$data['start_date'] = "";
			$temp = $this->borrow_model->isRequested($user_id, $media_id);
			if ( $temp )
			{
				if ($temp == 'pending')
				{
					$data['message'] = "You've already requested that!";
				}
				if ($temp == 'confirmed')
				{
					$data['message'] = "You've requested that, and it's ready to check out!";
				}
				if ($temp == 'active')
				{
					$data['message'] = "You're borrowing it right now! Did you lose it??";
				}
				$data['title'] = "Whoah!";
				$this->load->view('failed', $data);
			}
			else
			{
				$this->load->view('borrow_confirm', $data);
			}
		}
		else
		{
			$media_id = $_POST['id'];
			$user_id = $this->session->userdata('user_id');
			//returns a reason for rejection if the user is unable to borrow it, false otherwise
			$this->borrow_model->requestBorrow($user_id, $media_id);
			$data['message'] = "Successfully requested ";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
	/*******************************************************************
	 * confirmRequest -- records a confirmation on a borrow request
	 * @pre - user is logged in, URL segment 3 is the media's id,
	 * 	URL segment 4 is the id of the borrower
	 * 	URL segment 5 is the starting date of the borrow
	 * @post - the user is presented with the borrow confirmation view, and
	 * 	if they choose to say yes, the borrow is changed to "confirmed"
	 * 	status, and a confirmation view is loaded.
	*******************************************************************/
	function confirmRequest()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$borrower_id = $this->uri->segment(4);
			$start_date = $this->uri->segment(5);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$current_user = $this->session->userdata('user_id');
			if ($mediaInfo['user_id'] != $current_user)
			{
				$this->load->view('');
			}
			if ($this->borrow_model->isCheckedOut($media_id))
			{
				$this->load->view('');
			}
			$title = $mediaInfo['title'];
			$data['message'] = "Are you sure you'd like to lend $title to $borrower_id?";
			$data['borrower_id'] = $borrower_id;
			$data['start_date'] = $start_date;
			$data['title'] = "Lend $title";
			$data['function'] = '/borrow/confirmRequest';
			$data['id'] = $media_id;
			$this->load->view('borrow_confirm', $data);
		}
		else
		{
			$media_id = $_POST['id'];
			$borrower_id = $_POST['borrower_id'];
			$media_id = $_POST['id'];
			$start_date = $_POST['start_date'];
			$user_id = $this->session->userdata('user_id');
			$this->borrow_model->approveBorrow($borrower_id, $media_id, $start_date);
			$data['message'] = "Successfully requested!";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
	/*******************************************************************
	 * denyRequest -- removes a borrow request
	 * @pre - user is logged in, URL segment 3 is the media's id,
	 * 	URL segment 4 is the id of the borrower
	 * 	URL segment 5 is the starting date of the borrow
	 * @post - the user is presented with the borrow confirmation view, and
	 * 	if they choose to say yes, the borrow deleted from the table.
	*******************************************************************/
	function denyRequest()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$borrower_id = $this->uri->segment(4);
			$start_date = $this->uri->segment(5);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$current_user = $this->session->userdata('user_id');
			if ($mediaInfo['user_id'] != $current_user)
			{
				$this->load->view('');
			}
			if ($this->borrow_model->isCheckedOut($media_id))
			{
				$data['message'] = "Oh no! You can't deny something that's been checked out!";
				$data['title'] = "Failed deny";
				$this->load->view('failed', $data);
			}
			$title = $mediaInfo['title'];
			$data['message'] = "Are you sure you'd like to <u>deny</u> lending $title to $borrower_id?";
			$data['borrower_id'] = $borrower_id;
			$data['start_date'] = $start_date;
			$data['title'] = "Lend $title";
			$data['function'] = '/borrow/denyRequest';
			$data['id'] = $media_id;
			$this->load->view('borrow_confirm', $data);
		}
		else
		{
			$media_id = $_POST['id'];
			$borrower_id = $_POST['borrower_id'];
			$media_id = $_POST['id'];
			$start_date = $_POST['start_date'];
			$user_id = $this->session->userdata('user_id');
			$this->borrow_model->refuseBorrow($borrower_id, $media_id, $start_date);
			$data['message'] = "Successfully denied!";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
	/*******************************************************************
	 * handItOver -- records an active state on a borrow request
	 * @pre - user is logged in, URL segment 3 is the media's id,
	 * 	URL segment 4 is the id of the borrower
	 * 	URL segment 5 is the starting date of the borrow
	 * @post - the user is presented with the borrow confirmation view, and
	 * 	if they choose to say yes, the borrow is changed to "active"
	 * 	status, and a confirmation view is loaded.
	*******************************************************************/
	function handItOver()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$borrower_id = $this->uri->segment(4);
			$start_date = $this->uri->segment(5);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$current_user = $this->session->userdata('user_id');
			if ($mediaInfo['user_id'] != $current_user)
			{
				$this->load->view('');
			}
			$title = $mediaInfo['title'];
			$data['message'] = "Ready to hand $title over to $borrower_id?";
			$data['borrower_id'] = $borrower_id;
			$data['start_date'] = $start_date;
			$data['title'] = "Hand over $title";
			$data['function'] = '/borrow/handItOver';
			$data['id'] = $media_id;
			$this->load->view('borrow_confirm', $data);
		}
		else
		{
			$media_id = $_POST['id'];
			$borrower_id = $_POST['borrower_id'];
			$media_id = $_POST['id'];
			$start_date = $_POST['start_date'];
			$user_id = $this->session->userdata('user_id');
			$this->borrow_model->lendItem($borrower_id, $media_id, $start_date);
			$data['message'] = "Successfully transfered!";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
	/*******************************************************************
	 * returnItem -- records a return on a borrow request
	 * @pre - user is logged in, URL segment 3 is the media's id,
	 * 	URL segment 4 is the id of the borrower
	 * 	URL segment 5 is the starting date of the borrow
	 * @post - the user is presented with the borrow confirmation view, and
	 * 	if they choose to say yes, the borrow is changed to "returned"
	 * 	status, and a confirmation view is loaded.
	*******************************************************************/
	function returnItem()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$borrower_id = $this->uri->segment(4);
			$start_date = $this->uri->segment(5);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$current_user = $this->session->userdata('user_id');
			if ($mediaInfo['user_id'] != $current_user)
			{
				$this->load->view('');				
			}
			$title = $mediaInfo['title'];
			$data['message'] = "Has $borrower_id given $title back to you?";
			$data['borrower_id'] = $borrower_id;
			$data['start_date'] = $start_date;
			$data['title'] = "Hand over $title";
			$data['function'] = '/borrow/returnItem';
			$data['id'] = $media_id;
			$this->load->view('borrow_confirm', $data);
		}
		else
		{
			$media_id = $_POST['id'];
			$borrower_id = $_POST['borrower_id'];
			$media_id = $_POST['id'];
			$start_date = $_POST['start_date'];
			$user_id = $this->session->userdata('user_id');
			$this->borrow_model->returnItem($borrower_id, $media_id, $start_date);
			$data['message'] = "Successfully transferred!";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
}