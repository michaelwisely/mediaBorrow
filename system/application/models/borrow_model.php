<?php

class Borrow_model extends Query
{
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
