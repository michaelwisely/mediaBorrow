<?php
/*****************************************************************************
 *  user.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding users. The following pages are included:
 *
 *  User -- constructor, loads user model
 *  Profile -- prepares the user profile
 *  Index -- prepares the user homepage to show borrow status
 *  Login -- prepares the page which users use to log in
 *  Logout -- logs the user out of the system and sends them home
 *  Signup -- sends the user to a sign-up page and adds them to the database when they're done
 *  Edit -- allows users to edit their account information
 *
 ****************************************************************************/
class User extends Controller {
	/*******************************************************************
	 * User -- constructor for the User class
	 * @pre - none
	 * @post - if mediaBorrow isn't installed, redirects to install page
	 * 	otherwise, loads user model.
	*******************************************************************/
	function User()
	{
		parent::Controller();
		
		//check to see if databse is set up
		$query = $this->db->query('SHOW TABLES');
		if($query->num_rows() == 0)
			redirect('install');
		
		$this->load->model('user_model');
	}
	/*******************************************************************
	 * profile -- user profile page
	 * @pre - user is logged in.
	 * 	segment 3 of the url is the user_id of the person whose
	 * 	profile is being viewed. otherwise load the current user's profile
	 * @post - the 'profile' view is loaded with the data correstponding
	 * 	to the userid in segment 3
	*******************************************************************/
	function profile()
	{
		if(!$this->session->userdata('logged_in'))
			redirect('');
		else
		{
			if ($this->uri->segment(3))
			{
				$data['user_id']=$this->uri->segment(3);
			}
			else
			{
				if($this->uri->segment(2) != 'profile')
					$data['user_id'] = $this->uri->segment(2);
				if($this->uri->segment(2) == '')
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
				$libInfo = $this->user_model->getLibraryInformation($data['user_id']);
			
				//Each of these is an associative array in the form
				//   ['title'=>'bleh', 'type'=>'bleh'........]
				$data['books'] = $libInfo['books'];
				$data['movies'] = $libInfo['movies'];
				$data['cds'] = $libInfo['cds'];
			}
	
			$this->load->view('profile', $data);
		}
	}
	/*******************************************************************
	 * index -- user home page
	 * @pre - none.
	 * @post - if user isn't logged in, the welcome view is loaded
	 * 	if the user is logged in, information on their library and
	 * 	borrow requests is pulled from friend and borrow model
	 * 	and sent to be displayed in the home view
	*******************************************************************/
	function index()
	{	
		if(!$this->session->userdata('logged_in'))
			$this->load->view('welcome');
		else
		{
			$this->load->model('friend_model');
			$this->load->model('borrow_model');
			
			$data['user_id'] = $this->user_model->currentUser();
			$data['userData'] = $this->user_model->userData($data['user_id']);
			$data['title'] = "Hello, ".$data['userData']['fname'];
			
			$user_id = $data['user_id'];
						
			$friendInfo = $this->friend_model->getFriends($user_id);
			$libInfo = $this->user_model->getLibraryInformation($user_id);
			
			$borrowInfo = $this->borrow_model->getBorrowRequests($user_id);
			$borredItems = $this->borrow_model->getBorrowItemsBorrowedBy($user_id);
			$lendInfo = $this->borrow_model->getLends($user_id);
			
			//Each of these is an associative array in the form
			//   ['title'=>'bleh', 'type'=>'bleh'........]
			$data['books'] = $libInfo['books'];
			$data['movies'] = $libInfo['movies'];
			$data['cds'] = $libInfo['cds'];
			
			//This is an arsay with the form
			//  ['kyle', 'jared', 'mike'.....]
			$data['friend_requests'] = $friendInfo['requests'];
			$data['borrowed_items'] = $borredItems;
			
			$data['borrow_requests'] = array();
			foreach($borrowInfo as $b)
			{
				if (! $this->borrow_model->isCheckedOut($b['media_id']))
				{
					array_push($data['borrow_requests'], $b);
				}
			}
			
			$data['lends'] = $lendInfo;
			
			$this->load->view('home', $data);
		}
	}
	/*******************************************************************
	 * login -- login page
	 * @pre - none
	 * @post - if user login credentials are correct, the user is logged in
	 * 	and send to the index. Otherwise, an error message is presented
	 * 	and this page is loaded again.
	*******************************************************************/
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
	/*******************************************************************
	 * logout -- logs out a user
	 * @pre - none
	 * @post - logs out the user and redirects them to the welcome screen.
	*******************************************************************/
	function logout()
	{
		$this->user_model->logout();
		
		redirect('');
	}
	/*******************************************************************
	 * signup -- the page used for new user signup
	 * @pre - none
	 * @post - if the user inserts correct data, they are added to the database
	 * 	otherwise they are asked to reenter information.
	*******************************************************************/
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
	/*******************************************************************
	 * edit -- account page
	 * @pre - the user is logged in
	 * @post - account view is loaded and information entered is modified
	 * 	in the database, then the confirmation view is loaded.
	*******************************************************************/
	function edit()
	{
		if($_POST == NULL)
		{
			$data['title'] = 'Edit Accout Details';
			$data['userData']  = $this->user_model->userData($this->session->userdata('user_id'));
			
			$this->load->view('account', $data);
		}
		else
		{
			$this->user_model->edit($_POST);
			
			$data['title'] = 'Information Updated';
			$data['message'] = 'Your Information has been updated';
			$this->load->view('confirmation', $data);
		}
	}
}


/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */