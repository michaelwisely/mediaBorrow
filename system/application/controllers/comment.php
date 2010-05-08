<?php

class comment extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('comment_model');
	}
	
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