<?php

Class User_model extends Model
{
	function Show_model()
	{
		parent::Model();
	}
	
	function login($user_id, $password)
	{
		//check to see if the username and password are correct
		$openSesame = false;
		
		$query = $this->db->get_where('user', array('user_id' => $user_id));
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
	
}

?>