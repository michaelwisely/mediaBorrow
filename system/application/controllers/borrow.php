<?php

class Borrow extends MY_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('borrow_model');
		$this->load->model('media_model');
	}
	
	function request()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$mediaInfo = $this->media_model->mediaData($media_id);
			$title = $mediaInfo['title'];
			$data['message'] = "Are you sure you'd like to borrow $title?";
			$data['title'] = "Borrow $title";
			$data['function'] = '/borrow/request';
			$data['id'] = $media_id;
			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$media_id = $_POST['id'];
			$user_id = $this->session->userdata('user_id');
			$this->borrow_model->requestBorrow($user_id, $media_id);
			$data['message'] = "Successfully requested ";
			$data['title'] = "Success!";
			$this->load->view('confirmation', $data);
		}
	}
}