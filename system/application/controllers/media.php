<?php

class Media extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('media_model');
	}
	
	function index()
	{
		redirect('');
	}
	
	function search()
	{
		if($_POST == NULL)
			$_POST['search'] = NULL;
		
		$data['title'] = 'Search Results';
		$data['results'] = $this->media_model->search($_POST['search']);
		$this->load->view('media_list', $data);
	}
	
	function add()
	{
		if($_POST == NULL)
		{
			$data['title'] = 'Add New Media';
			$this->load->view('media_add', $data);
		}
		else
		{
			$this->media_model->add($_POST);
			
			$data['title'] = $_POST['title'].' Successfully Added';
			$data['message'] = $_POST['title'].' has been added to your library';
			$this->load->view('confirmation', $data);
		}
	}
}