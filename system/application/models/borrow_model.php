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
	
	function getBorrowRequests($user_id)
	{
	    $table = $this->query->getBorrowRequests($user_id);
	    return $table->result_array();
	}
}
