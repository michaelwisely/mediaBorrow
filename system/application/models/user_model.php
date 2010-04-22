<?php

Class User_model extends Model
{
	function Show_model()
	{
		parent::Model();
	}
	
	function login($user_id, $password)
	{
	    //open up a conenction to the server and pick the correct
	    //  database
		$con = mysql_connect("localhost","cs238","databases");
		mysql_select_db("mediaBorrow", $con);

		//check to see if the username and password are correct
		$openSesame = false;
		
		$table = mysql_query("SELECT *
				     FROM USERS u
				     WHERE u.user_id='".$user_id."'");
		$row = mysql_fetch_array($table);
		if (count($row) > 0)
			if($row['password'] == $password)
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
		
		mysql_close($con);
		
		return $openSesame;
	    
	}
	
	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->set_userdata('logged_in', false);
	}
	
}

?>
