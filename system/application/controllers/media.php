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
			$_POST['search'] = 'Sherlock Holmes';
		
		$data['title'] = 'Search Results';
		$data['results'] = $this->media_model->search($_POST['search']);
		$this->load->view('media_list', $data);
	}
	
	function add()
	{
		$this->load->view('media_add');
		
		
	}
}