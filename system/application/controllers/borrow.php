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
	
}
