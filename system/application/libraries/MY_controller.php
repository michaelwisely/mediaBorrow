<?php
/*****************************************************************************
 *  MY_controller.php
 *  
 *  A mixin for controllers which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, calls Controller constructor and checks to make
 *  	sure that the database isn't empty. Also verifies user is logged in.
 *
 ****************************************************************************/
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
