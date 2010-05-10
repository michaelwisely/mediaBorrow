<?php
/*****************************************************************************
* user_model.php
*
* Contains methods which are used by controllers to access information regarding
* users. This class inherits from a Query class, which contains SQL queries
* which are necessary for user functions:
* 
* User_model - constructor, calls Query constructor
* login - logs a user into the system using code igniter's session functions
* logout - logs a user out using code igniter's functions
* user_exists - checks to see if a user exists in the system
* email_exists - checks to see if an email exists in the system
* currentUser - gets the userID of the user currently logged in
* userData - gets user information based on the given user_id
* getLibraryInformation - gets a user's library
* edit - changes a user's account information
****************************************************************************/
class User_model extends Query
{
	/*******************************************************************
	 * User_model -- constructor for the User_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function User_model()
	{
		parent::Query();
	}
	/*******************************************************************
	 * login -- logs a user into the system
	 * @pre - to be logged in, user must exist in the system
	 * @param - $user_id = string, user's entered id
	 * 	$password = string, user's entered password
	 * @post - if username and password are correct, user is logged in
	 * 	using Code Igniter sessions
	*******************************************************************/
	function login($user_id, $password)
	{
		//check to see if the username and password are correct
		$openSesame = false;
		
		$query = $this->db->get_where('USERS', array('user_id' => $user_id));
		if ($query->num_rows() != 0)
			if($query->row()->password == $password)
				$openSesame = true;
		
		//if login is correct
		if ($openSesame)
		{
			//is logged in
			$this->session->set_userdata('logged_in', true);
			//username
			$this->session->set_userdata('user_id', $user_id);
		}
		else
		{
			$this->session->sess_destroy();
		}
		
		return $openSesame;
	}
	/*******************************************************************
	 * logout -- logs a user out of the system
	 * @pre - user must be logged in
	 * @post - user is logged out by code igniter sessions
	*******************************************************************/
	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->set_userdata('logged_in', false);
	}
	/*******************************************************************
	 * user_exists -- checks to see if a user exists
	 * @pre - none
	 * @param - $user_id = string, user id
	 * @post - retrns true if a user exists, and false otherwise.
	*******************************************************************/
	function user_exists($user_id)
	{
		$user_id = strtolower($user_id);
		$users = $this->db->query("SELECT \"$user_id\" FROM USERS WHERE user_id = \"$user_id\"");
		
		if($users->num_rows() > 0)
			return true;
		else
			return false;
	}
	/*******************************************************************
	 * email_exists -- checks to see if an email exists
	 * @pre - none
	 * @param - $email = string, an email address
	 * @post - returns true if the email exists, otherwise false
	*******************************************************************/
	function email_exists($email)
	{
		$email = strtolower($email);
		$users = $this->db->query("SELECT \"$email\" FROM USERS WHERE email = \"$email\"");
		
		if($users->num_rows() > 0)
			return true;
		else
			return false;
	}
	/*******************************************************************
	 * currentUser -- gets the current user
	 * @pre - user is logged in.
	 * @post - uses a Code Igniter function call and returns the currently
	 * 	logged-in user's id.
	*******************************************************************/
	function currentUser()
	{
		return $this->session->userdata('user_id');
	}
	/*******************************************************************
	 * userData -- returns the data for a user
	 * @pre - user exists
	 * @param - $user_id = string, user id
	 * @post - returns an array containing user information. array keys
	 * 	are the names of the columns in the user database.
	*******************************************************************/
	function userData($user_id)
	{
		$query = $this->query->userData($user_id);
		
		$userData = array();
		
		foreach($query->result_array() as $user)
			foreach($user as $attribute => $value)
				$userData[$attribute] = $value;
        $cityState = $this->getCityStateForZip($userData['zip']);
		$userData['city'] = $cityState['city'];
		$userData['state'] = $cityState['state'];
		
		return $userData;
	}
	/*******************************************************************
	 * getLibraryInformation -- gets a user's media library
	 * @pre - user exists
	 * @param - $user_id = string, user id
	 * @post - retrns an array of arrays {'books':[], 'cds':[], 'movies':[]}
	*******************************************************************/
	function getLibraryInformation($user_id)
	{
		$query = $this->query->getUserLibrary($user_id);

		$books = $query['books'];
		$cds = $query['cds'];
		$movies = $query['movies'];
		
		$bookData = $books->result_array();
		$cdData = $cds->result_array();
		$movieData = $movies->result_array();
		
		$books = array();
		$movies = array();
		$cds = array();
		
		//instert ratings
		foreach($bookData as $book)
		{
			foreach($book as $attr => $value)
			{
				$temp[$attr] = $value;
			}
			$temp['rating'] = $this->query->getAverageRating($temp['media_id']);
			array_push($books, $temp);
		}
		foreach($movieData as $movie)
		{
			foreach($movie as $attr => $value)
			{
				$temp[$attr] = $value;
			}
			$temp['rating'] = $this->query->getAverageRating($temp['media_id']);
			array_push($movies, $temp);
		}
		foreach($cdData as $cd)
		{
			foreach($cd as $attr => $value)
			{
				$temp[$attr] = $value;
			}
			$temp['rating'] = $this->query->getAverageRating($temp['media_id']);
			array_push($cds, $temp);
		}
		
		return array("books"=>$books, "movies"=>$movies, "cds"=>$cds);
	}
	/*******************************************************************
	 * edit -- changes a user's profile info
	 * @pre - user exists
	 * @param - $new is an array with keys corresponding to the column names
	 * 	in the user table in the database.
	 * @post - user information is updated.
	*******************************************************************/
	function edit($new)
	{
		$new['user_id'] = $this->currentUser();
		$current = $this->userData($new['user_id']);
		if($new['password'] == '')
			$new['password'] = $current['password'];
		$this->query->updateUserProfile($new['user_id'], $new['email'], $new['password'], $new['zip'], $new['fname'], $new['lname'], $new['year'], $new['month'], $new['day']);
	}
}

?>