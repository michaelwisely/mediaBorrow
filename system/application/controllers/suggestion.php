<?php

class Suggestion extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('suggestion_model');
	}
	
	function index()
	{
		if($_POST == NULL)
		{
			$data['title'] = 'Make a suggestion';
			$this->load->view('suggestion', $data);
		}
		else
		{
			$this->suggestion_model->suggest($_POST);
			
			$data['title'] = 'Thank you';
			$data['message'] = 'Thank you, your suggestion has been recorded';
			$this->load->view('confirmation', $data);
		}
	}
}
