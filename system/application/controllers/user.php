<?php

class User extends Controller {

	function User()
	{
		parent::Controller();
		
		$this->load->model('user_model');
	}
	
	function index()
	{
		$this->load->view('welcome');
	}
	
	function login()
	{
		if($_POST == NULL)
			redirect('');
		else
		{
			if($this->user_model->login($_POST['user_id'], $_POST['password']))
				echo 'awesome';
			else
			{
				echo 'not awesome';
			}
		}
	}
	
	function logout()
	{
		$this->user_model->logout();
		
		redirect('');
	}
	
	function signup()
	{
		if($_POST == NULL)
			$this->load->view('signup');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */