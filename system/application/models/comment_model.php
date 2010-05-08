<?php

class Comment_model extends Query
{
	function Comment_model()
	{
		parent::Query();
	}
	
	function add($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->addComment($user_id, $post['media_id'], $post['comment'], $post['rating']);
	}
	
	function edit($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->editComment($user_id, $post['media_id'], $post['comment'], $post['rating']);
	}
	
	function delete($media_id)
	{
		$user_id = $this->session->userdata('user_id');
		
		$this->query->deleteComment($user_id, $media_id);
	}
	
	function getComments($media_id)
	{
		$commentsObject = $this->query->getComments($media_id);
		
		$comments = array();
		foreach($commentsObject->result_array() as $comment)
			array_push($comments, $comment);
		
		return $comments;
	}
}

?>