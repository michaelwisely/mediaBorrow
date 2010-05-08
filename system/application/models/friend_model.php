<?php

class Friend_model extends Query
{
	function Friend_model()
	{
		parent::Query();
	}
	
	function getFriends($user_id)
	{
		$query = $this->query->getFriendRequests($user_id);
		$query2 = $this->query->listFriends($user_id);
		
		$reqFriends = array();
		$curFriends = array();
		
		foreach($query->result_array() as $friend)
			foreach($friend as $attribute => $value)
				array_push($reqFriends, $value);
				
		foreach($query2->result_array() as $friend)
			foreach($friend as $attribute => $value)
				array_push($curFriends, $value);
		
		return array("requests"=>$reqFriends, "friends"=>$curFriends);
	}
	
	function requestFriend($uid1, $uid2)
	{
		return $this->query->requestFriendship($uid1, $uid2);
	}
	
	function acceptFriendRequest($uid1, $uid2)
	{
		return $this->query->acceptFriendRequest($uid1, $uid2);
	}
	
	function denyFriendRequest($uid1, $uid2)
	{
		return $this->query->deleteFriend($uid1, $uid2);
	}
	
	function numFriends($uid)
	{
		return $this->query->getNumberOfFriends($uid);
	}
	
	function areFriends($uid1, $uid2)
	{
		return $this->query->areFriends($uid1, $uid2);
	}
}

?>