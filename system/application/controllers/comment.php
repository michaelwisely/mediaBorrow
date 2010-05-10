<?php
/*****************************************************************************
 *  comment.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding comments on user media. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, loads comment model
 *  index -- allows users to make a comment
 *  edit -- allows users to edit their comment on a piece of media
 *  delete -- allows users to delete their comment from a piece of media
 *
 ****************************************************************************/
class comment extends MY_controller {
	/*******************************************************************
	 * __constructor -- constructor for the comment class
	 * @pre - none
	 * @post - calls parent constructor and loads comment model
	*******************************************************************/
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('comment_model');
	}
	/*******************************************************************
	 * index -- prepares page to view media and add comments
	 * @pre - user is logged in
	 * @post - redirects to media view after comment is added
	*******************************************************************/
	function index()
	{
		if($_POST == NULL)
			redirect('');
		else
		{
			$this->comment_model->add($_POST);
			
			redirect('media/view/'.$_POST['media_id']);
		}
	}
	/*******************************************************************
	 * edit -- prepares page to view media and edit comments
	 * @pre - user is logged in
	 * @post - redirects to media view after comment is edited
	*******************************************************************/
	function edit()
	{
		if($_POST == NULL)
			redirect('');
		else
		{
			$this->comment_model->edit($_POST);
			
			redirect('media/view/'.$_POST['media_id']);
		}
	}
	/*******************************************************************
	 * index -- prepares page to delete comments
	 * @pre - user is logged in, URL segment 3 is the media_id which
	 * 	the comment is tied to
	 * @post - if the user clicks yes on the are_you_sure page, the
	 * 	comment is removed from the database and a confirmation
	 * 	view is loaded.
	*******************************************************************/
	function delete()
	{
		if($_POST == NULL)
		{
			$this->load->model('media_model');
			
			$media_id = $this->uri->segment(3);
			$media = $this->media_model->mediaData($media_id);
			$data['title'] = 'Delete '.$media['title'];
			$data['id'] = $media_id;
			$data['message'] = 'Are you sure you want to delete your comment on '.$media['title'].'?';
			$data['function'] = 'comment/delete';
			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$this->comment_model->delete($_POST['id']);

			$data['title'] = 'Comment Deleted';
			$data['message'] = 'Your comment has been deleted.';
			$this->load->view('confirmation', $data);
		}
	}
}
	
?>