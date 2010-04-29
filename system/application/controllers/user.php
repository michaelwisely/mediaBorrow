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
	
	function profile()
	{
		if ($this->uri->segment(3))
		{
			$data['user_id']=$this->uri->segment(3);
		}
		else
		{
			$data['user_id'] = $this->user_model->currentUser();	
		}
		
		$data['userData'] = $this->user_model->userData($data['user_id']);
		
		if (empty($data['userData']))
		{
			$data['userData']['fname'] = "John Doe";
			$data['title'] = "No such person";
		}
		else
		{
			$data['title'] = $data['userData']['fname']." ".$data['userData']['lname']."'s Profile";
		}

		$this->load->view('profile', $data);
	}
	
	function friends()
	{
		$user_id = $this->user_model->currentUser();
		$userInfo = $this->user_model->userData($user_id);
		$friendArray = $this->user_model->getFriends($user_id);
		$data['friends'] = $friendArray['friends'];
		$data['requests'] = $friendArray['requests'];
		$data['title'] = $userInfo['fname'];
		$this->load->view('friends', $data);
	}
	
	function index()
	{	
		if(!$this->session->userdata('logged_in'))
			$this->load->view('welcome');
		else
		{			
			$data['user_id'] = $this->user_model->currentUser();
			$data['userData'] = $this->user_model->userData($data['user_id']);
			$data['title'] = "Hello, ".$data['userData']['fname'];
			
			$user_id = $data['user_id'];
			
			$friendInfo = $this->user_model->getFriends($user_id);
			$libInfo = $this->user_model->getLibraryInformation($user_id);
			
			//Each of these is an associative array in the form
			//   ['title'=>'bleh', 'type'=>'bleh'........]
			$data['books'] = $libInfo['books'];
			$data['movies'] = $libInfo['movies'];
			$data['cds'] = $libInfo['cds'];
			
			//This is an arsay with the form
			//  ['kyle', 'jared', 'mike'.....]
			$data['requests'] = $friendInfo['requests'];
			
			$this->load->view('home', $data);
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
				$this->load->view('signed_up', $data);
			}
		}
	}
}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */