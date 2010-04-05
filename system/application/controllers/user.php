<?php

class User extends Controller {

	function User()
	{
		parent::Controller();
		
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->view('welcome');
	}
	
	function signin()
	{
		
	}
	
	function signup()
	{
		if($_POST == NULL)
			$this->load->view('signup');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */