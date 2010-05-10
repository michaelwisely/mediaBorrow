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
	
	function requestBorrow($user_id, $media_id)
	{
		$this->query->requestBorrow($user_id, $media_id);
	}
	
	function isRequested($user_id, $media_id)
	{
		return $this->query->isRequested($user_id, $media_id);
	}
	
	function getBorrowItemsBorrowedBy($user_id)
	{
		return $this->query->getBorrowItemsBorrowedBy($user_id);
	}
	
	function getBorrowRequests($user_id)
	{
	    $table = $this->query->getBorrowRequests($user_id);
	    return $table->result_array();
	}
	
	function getLends($user_id)
	{
		return $this->query->getItemsLentOutBy($user_id);
	}
	
	function isCheckedOut($media_id)
	{
		return $this->query->isCheckedOut($media_id);
	}
	
	function lendItem($borower_id, $media_id)
	{
		return $this->query->lendItem($borower_id, $media_id);
	}
	
	function returnItem($user_id, $media_id, $start_date)
	{
		return $this->query->returnItem($user_id, $media_id, $start_date);
	}
	function approveBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->query->approveBorrow($borrower_id, $media_id, $start_date);
	}
	
	function refuseBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->query->refuseBorrow($borrower_id, $media_id, $start_date);
	}
}
