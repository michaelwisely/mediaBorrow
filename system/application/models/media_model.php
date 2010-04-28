<?php

Class Media_model extends Model
{
	function Media_model()
	{
		parent::Model();
		
		$CI =& get_instance();
		$CI->load->model('query');
	}
	
	function search($search)
	{
		$query = $this->query->searchForTitle($search);
		
		
		
		return $query->result_array();
	}
}

?>