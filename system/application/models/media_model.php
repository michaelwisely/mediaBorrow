<?php

Class Media_model extends Query
{
	function Media_model()
	{
		parent::Query();
	}
	
	function add($attr)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->addMedia($user_id, $attr['genre'], $attr['title'], $attr['type'], $attr['author'], $attr['publisher'], $attr['ISBN'], $attr['writer'], $attr['writer'], $attr['director']);
	}
	
	function search($search)
	{
		$query = $this->query->searchForTitle($search);
		
		return $query->result_array();
	}
	
	function mediaData($media_id)
	{
		$query = $this->query->mediaData($media_id);
		return $query->result_array();
	}
	
}

?>