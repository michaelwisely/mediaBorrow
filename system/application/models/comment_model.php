<?php
/*****************************************************************************
* comment_model.php
*
* Contains methods which are used by controllers to access information regarding
* user comments. This class inherits from a Query class, which contains SQL queries
* which are necessary for commenting functions:
*
* Comment model - constructor that calls the constructor for the Query class
* add - adds the comment to the specified media
* edit - edits the user's comment for the specified media
* delete - deletes the user's comment for the specified media
* getComments = gets the comments for a specified media.
****************************************************************************/
class Comment_model extends Query
{
	/*******************************************************************
	 * Comment_model -- constructor for the Comment_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function Comment_model()
	{
		parent::Query();
	}
	
	/*******************************************************************
	 * add -- adds a comment to the database for a media
	 * @pre - $post must have 3 elements:
					media_id must be a valid ID in the database
					comment must be a string
					rating must be an integer 1-5
				also, user should not have commented on the media yet
	 * @post - a new comment is added to the database
	*******************************************************************/
	function add($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->addComment($user_id, $post['media_id'], $post['comment'], $post['rating']);
	}
	
	/*******************************************************************
	 * edit -- eidts an existing comment in the database
	 * @pre - $post must have 3 elements:
					media_id must be a valid ID in the database
					comment must be a string
					rating must be an integer 1-5
				also, user should have commented on the media already
	 * @post - the apropriate comment is updated in the database
	*******************************************************************/
	function edit($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->editComment($user_id, $post['media_id'], $post['comment'], $post['rating']);
	}
	
	/*******************************************************************
	 * delete -- deletes a comment from the database
	 * @pre - $media_id must be a valid ID in the database
				use should have commented on the media already
	 * @post - the appropriate comment is deleted from the databse
	*******************************************************************/
	function delete($media_id)
	{
		$user_id = $this->session->userdata('user_id');
		
		$this->query->deleteComment($user_id, $media_id);
	}
	
	/*******************************************************************
	 * getComments -- retrives all comments associated with a media
	 * @pre - $media_id must be a valid ID in the database
	 * @post - returns an array of comments for this specific media
	*******************************************************************/
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