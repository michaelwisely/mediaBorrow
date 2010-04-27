<?php

class MY_Controller extends Controller
{
	function __construct()
	{
		parent::Controller();
		
		//check to see if databse is set up
		$query = $this->db->query('SHOW TABLES');
		if($query->num_rows() == 0)
			redirect('install');
		
		//check if user is logged in
		if(!$this->session->userdata('logged_in'))
			redirect('');
	}
}
