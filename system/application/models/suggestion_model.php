<?php

class Suggestion_model extends Query
{
	function Suggestion_model()
	{
		parent::Query();
	}
	
	function suggest($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$this->query->makeSiteSuggestion($CI->user_model->currentUser(), $post['topic'], $post['suggestion']);
	}
}

?>