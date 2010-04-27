<?php

class User extends Controller {

	function User()
	{
		parent::Controller();
		
		//check to see if databse is set up
		$query = $this->db->query('SHOW TABLES');
		if($query->num_rows() == 0)
			redirect('install');
		
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
			$data['user_id'] = $data['fname'] = $data['lname'] = $data['email'] = $data['zip'] = '';
			$data['day'] = 1;
			$data['month'] = 1;
			$data['year'] = 1900;
			
			$this->load->view('signup', $data);
		}
		else
		{
			$data = $_POST;
			$data['error'] = '';
			
			//check to see if username is already taken
			if($this->user_model->user_exists($data['user_id']))
				$data['error'] = 'That username is already is use. Please specify a different one.';
			//check to see if email is already taken
			if($this->user_model->email_exists($data['email']))
			{
				if($data['error'] == '')
				{
					$data['error'] = 'That email is already is use. Please specify a different one.';
				}
				else
				{
					$data['error'] = 'Those username and email address are already in use. Please choose different ones.';
				}
			}
			
			//if there was an error, go back to signup page. Otherwise, add user to database
			if($data['error'] != '')
				$this->load->view('signup', $data);
			else
			{
				$this->query->addNewUser($data['user_id'], $data['email'], $data['password'], $data['zip'], $data['fname'], $data['lname'], $data['day'], $data['month'], $data['year']);
				echo 'awesome';
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */