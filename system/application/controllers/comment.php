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
}
	
?>