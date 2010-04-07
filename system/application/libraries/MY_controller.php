<?php

class MY_Controller extends Controller
{
	function __construct()
	{
		parent::Controller();
		
		//check if user is logged in
		if(!$this->session->userdata('logged_in'))
			redirect('');
	}
}
