<?php
/*****************************************************************************
* borrow_model.php
*
* Contains methods which are used by controllers to access information regarding
* user borrows. This class inherits from a Query class, which contains SQL queries
* which are necessary for borrowing functions:
*
* borrow model - constructor that calls the constructor for the Query class
* requestBorrow - requests to borrow the specified media
* isRequested - confirms that the media has been requested
* getBorrowItemsBorrowedBy - gets the items that are borrowed by the specified
* user
* getBorrowRequests - gets the users items that are being requested of to 
* borrow
* getLends - gets the items that the user has lent out
* isCheckedOut - says whether or not a specified item is currently being
* borrowed by a user
* lendItem - "lends" the item to the person requesting to borrow that item
* returnItem - Returns the media back to the owner
* approveBorrow - confirms that the owner of an item is going to let the 
* person requesting to borrow the item borrow the item.
* refuseBorrow - confirms that the owner of an item is NOT going to let the 
* person requesting to borrow the item borrow the item.
* 
****************************************************************************/
class Borrow_model extends Query
{
	/*******************************************************************
	 * Borrow_model -- constructor for the Borrow_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function Borrow_model()
	{
		parent::Query();
	}
	/*******************************************************************
	 * requestBorrow -- adds a borrow request to the table with status 'pending'
	 * @pre - user id is an existing user and media id exists also
	 * @param - $user_id = string, user id  $media_id = string, media id
	 * @post - request is added to the database
	*******************************************************************/
	function requestBorrow($user_id, $media_id)
	{
		$this->query->requestBorrow($user_id, $media_id);
	}
	/*******************************************************************
	 * isRequested -- checks to see if a borrow request has been made
	 * @pre - user id is an existing user and media id exists also
	 * @param - $user_id = string, user id  $media_id = string, media id
	 * @post - returns true if it has been requested by $user_id, otherwise false
	*******************************************************************/
	function isRequested($user_id, $media_id)
	{
		return $this->query->isRequested($user_id, $media_id);
	}
	/*******************************************************************
	 * getBorrowItemsBorrowedBy -- gets items borrowed by $user_id
	 * @pre - user id exists
	 * @param - $user_id = string, user id 
	 * @post - returns an array of media items being borrowed by $user_id
	*******************************************************************/
	function getBorrowItemsBorrowedBy($user_id)
	{
		return $this->query->getBorrowItemsBorrowedBy($user_id);
	}
	/*******************************************************************
	 * getBorrowRequests -- gets borrow requests by $user_id
	 * @pre - user id exists
	 * @param - $user_id = string, user id 
	 * @post - returns an array of requests made on items owned by $user_id
	*******************************************************************/
	function getBorrowRequests($user_id)
	{
	    $table = $this->query->getBorrowRequests($user_id);
	    return $table->result_array();
	}
	/*******************************************************************
	 * getLends -- gets items lent out by $user_id, both confirmed and active
	 * @pre - user id exists
	 * @param - $user_id = string, user id 
	 * @post - returns an array of media items being borrowed from $user_id
	 * 	{'confirmed':[], 'active':[]}
	*******************************************************************/
	function getLends($user_id)
	{
		return $this->query->getItemsLentOutBy($user_id);
	}
	/*******************************************************************
	 * isCheckedOut -- checks to see if an item is checked out
	 * @pre - media id exists
	 * @param - $media_id = string, media id
	 * @post - returns true if it is checked out, otherwise false
	*******************************************************************/
	function isCheckedOut($media_id)
	{
		return $this->query->isCheckedOut($media_id);
	}
	/*******************************************************************
	 * lendItem -- changes a borrow status to active
	 * @pre - borrower and media id exist
	 * @param - $borrower_id = string, user id  $media_id = string, media id
	 * @post - changes the borrow status corresponding to the parameters
	 * 	to 'active'
	*******************************************************************/
	function lendItem($borower_id, $media_id)
	{
		return $this->query->lendItem($borower_id, $media_id);
	}
	/*******************************************************************
	 * returnItem -- sets a borrow status to 'returned'
	 * @pre - user id and media id exist
	 * @param - $user_id = string, user id , $media_id = string, media id
	 * 	$start_date = integer, start date (time from linux epoch)
	 * @post - changes the borrow status corresponding to the parameters to
	 * 	'returned'
	*******************************************************************/
	function returnItem($user_id, $media_id, $start_date)
	{
		return $this->query->returnItem($user_id, $media_id, $start_date);
	}
	/*******************************************************************
	 * approveBorrow -- sets a borrow status to 'confirmed'
	 * @pre - user id and media id exist
	 * @param - $user_id = string, user id , $media_id = string, media id
	 * 	$start_date = integer, start date (time from linux epoch)
	 * @post - changes the borrow status corresponding to the parameters to
	 * 	'confirmed'
	*******************************************************************/
	function approveBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->query->approveBorrow($borrower_id, $media_id, $start_date);
	}
	/*******************************************************************
	 * refuseBorrow -- deletes a borrow request
	 * @pre - user id and media id exist
	 * @param - $user_id = string, user id , $media_id = string, media id
	 * 	$start_date = integer, start date (time from linux epoch)
	 * @post - removes the borrow from the BORROWS table
	*******************************************************************/
	function refuseBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->query->refuseBorrow($borrower_id, $media_id, $start_date);
	}
}
