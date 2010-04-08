<?php

class User extends Controller {

	function User()
	{
		parent::Controller();
		
		$this->load->model('user_model');
	}
	
	function index()
	{	
		if(!$this->session->userdata('logged_in'))
			$this->load->view('welcome');
		else
		{
			$this->load->view('home');
		}
	}
	
	function login()
	{
		if($_POST == NULL)
		{
			$data['error'] = '';
			$data['user_id'] = '';
			$this->load->view('login', $data);
		}
		else
		{
			if($this->user_model->login($_POST['user_id'], $_POST['password']))
				redirect('');
			else
			{
				$data['error'] = 'Your username or password are incorrect';
				$data['user_id'] = $_POST['user_id'];
				$this->load->view('login', $data);
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
		{
			$data['error'] = '';
			$this->load->view('signup');
		}
		else
		{
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */