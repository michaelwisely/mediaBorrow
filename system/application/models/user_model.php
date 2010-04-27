<?php

Class User_model extends Model
{
	function User_model()
	{
		parent::Model();
	}
	
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
	
	function logout()
	{
		$this->session->unset_userdata('user_id');
		$this->session->set_userdata('logged_in', false);
	}
	
	function user_exists($user_id)
	{
		$user_id = strtolower($user_id);
		$users = $this->db->query("SELECT \"$user_id\" FROM USERS WHERE user_id = \"$user_id\"");
		
		if($users->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	function email_exists($email)
	{
		$email = strtolower($email);
		$users = $this->db->query("SELECT \"$email\" FROM USERS WHERE email = \"$email\"");
		
		if($users->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	function currentUser()
	{
		return $this->session->userdata('user_id');
	}
	
	function userData($user_id)
	{
		$CI =& get_instance();
		$CI->load->model('query');
		$query = $CI->query->userData($user_id);
		
		foreach($query->result_array() as $user)
			foreach($user as $attribute => $value)
				$userData[$attribute] = $value;
		
		return $userData;
	}
	
}

?>