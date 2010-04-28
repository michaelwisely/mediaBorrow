<?php

Class Media_model extends Query
{
	function Media_model()
	{
		parent::Model();
	}
	
	function search($search)
	{
		$query = $this->query->searchForTitle($search);
		
		
		
		return $query->result_array();
	}
}

?>