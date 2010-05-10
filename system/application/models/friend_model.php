<?php
/*****************************************************************************
* friend_model.php
*
* Contains methods which are used by controllers to access information regarding
* friendships. This class inherits from a Query class, which contains SQL queries
* which are necessary for friend functions:
*
* Friend_model - constructor that calls the constructor for the Query class
* requestFriend - lets user make a friend request
* acceptFriendRequest - lets user accept a friend request
* denyFriendRequest - lets user deny a friend request
* numFriends - returns how many friends a user has
* areFriends - says whether or not two users are friends 
****************************************************************************/
class Friend_model extends Query
{
	/*******************************************************************
	 * Friend_model -- constructor for the Friend_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function Friend_model()
	{
		parent::Query();
	}
	
	/*******************************************************************
	 * getFriends -- retrieves all user_id for freinds of $user_id
						and those who have requested friendship
						with $user_id from database
	 * @pre - $user_id must be a valid user in the database
	 * @post - returns an array with two elements that are also arrays:
					requests: array of user_ids who have requested
						friendship with $user_id
					friends: array of user_ids who are friends
						with $user_id
	*******************************************************************/
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
	
	/*******************************************************************
	 * requestFriend -- adds a friend request from $uid1 to $uid2
	 * @pre - there should not be a friendship or request between
				the two ids in the database
	 * @post - a friendship is added to the database between $uid1
				and $uid2 with status 'pending'
	*******************************************************************/
	function requestFriend($uid1, $uid2)
	{
		return $this->query->requestFriendship($uid1, $uid2);
	}
	
	/*******************************************************************
	 * acceptFriendRequest -- turns a 'pending' friendship to 'active'
	 * @pre - $uid1 should have requested friendship from $uid2 already
	 * @post - the friendship between $uid1 and $uid2 has been changed
				from 'pending' to 'active'
	*******************************************************************/
	function acceptFriendRequest($uid1, $uid2)
	{
		return $this->query->acceptFriendRequest($uid1, $uid2);
	}
	
	/*******************************************************************
	 * denyFriendRequest -- deletes the $uid1 & $uid2 friendship
							from the database
	 * @pre - there should be an existing friendship between
				$uid1 & $uid2
	 * @post - the friendship between $uid1 & $uid2 has been deleted
	*******************************************************************/
	function denyFriendRequest($uid1, $uid2)
	{
		return $this->query->deleteFriend($uid1, $uid2);
	}
	
	/*******************************************************************
	 * numFriends -- retrieves the number of friends for a given user
	 * @pre - $uid must be a valid ID in the database
	 * @post - returns the number of friends $uid has
	*******************************************************************/
	function numFriends($uid)
	{
		return $this->query->getNumberOfFriends($uid);
	}
	
	/*******************************************************************
	 * areFriends -- checks if two users have an active friendship
	 * @pre - $uid1 and $uid2 must be an valid IDs in the database
	 * @post - returns true if $uid1 and $uid2 share an active
				friendship in the database, false otherwise
	*******************************************************************/
	function areFriends($uid1, $uid2)
	{
		return $this->query->areFriends($uid1, $uid2);
	}
}

?>