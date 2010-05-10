<?php
/*****************************************************************************
 *  install.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  installing the mediaBorrow system. The following pages are included:
 *
 *  Install -- constructor, calls parent constructor
 *  do_install -- gathers user information necessary to perform system install
 *
 ****************************************************************************/
class Install extends Controller {
	/*******************************************************************
	 * Install -- constructor for the Install class
	 * @pre - none
	 * @post - calls parent constructor.
	*******************************************************************/
	function Install()
	{
		parent::Controller();
	}
	/*******************************************************************
	 * index -- loads install page
	 * @pre - none
	 * @post - if the database is installed, send an error message,
	 * 	otherwise redirect to install page.
	*******************************************************************/
	function index()
	{
		$query = 'SHOW TABLES';
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
			echo 'Your Database is already set up. If you want to reinstall MediaBorrow, please delete everything in your database and run this script again.';
		else
			$this->load->view('install');
		
	}
	/*******************************************************************
	 * do_install -- gets new user information and performs install
	 * @pre - database mediaborrow exists and is empty
	 * @post - takes user information and performs install, then loads
	 *	an install confirmation page.
	*******************************************************************/
	function do_install()
	{
		if($_POST == NULL)
		{
			redirect('install');
		}
		else
		{
			//install system and add new user
			$this->query->install($_POST);
			
			//show confirmation
			$data['user_id'] = $_POST['user_id'];
			$this->load->view('installed', $data);
		}
	}

}