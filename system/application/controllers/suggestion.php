<?php
/*****************************************************************************
 *  suggestion.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding user site suggestions. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, loads suggestion model
 *  Index -- prepares the site reccomendation page.
 *
 ****************************************************************************/
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
