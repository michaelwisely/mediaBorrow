<?php
/*****************************************************************************
* media_model.php
*
* Contains methods which are used by controllers to access information regarding
* media. This class inherits from a Query class, which contains SQL queries
* which are necessary for media functions:
*
* Media_model - constructor that calls the constructor for the Query class
* add - lets user add some media to his or her library
* search - lets user search for a piece of media
* modify_media - lets user modify one of their media
* delete - lets user delete a selected media
* mediaData - returns the data for the appropriate media
****************************************************************************/
Class Media_model extends Query
{
	/*******************************************************************
	 * Media_model -- constructor for the Media_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function Media_model()
	{
		parent::Query();
	}
	
	/*******************************************************************
	 * add -- adds a media to the database
	 * @pre - $attr is an array with 9 elements, one for each column
				in the media table (user_id is procured otherwise
				and media_id is auto-incremented)
	 * @post - a media is added to the database
	*******************************************************************/
	function add($attr)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$user_id = $CI->user_model->currentUser();
		
		$this->query->addMedia($user_id, $attr['genre'], $attr['title'],
				       $attr['type'], $attr['author'],
				       $attr['publisher'], $attr['ISBN'],
				       $attr['artist'], $attr['writer'], $attr['director']);
	}
	
	/*******************************************************************
	 * search -- searches the media table by title
	 * @pre - $search must be a string or NULL
	 * @post - returns an array of medias with titles similar to $search
	*******************************************************************/
	function search($search)
	{
		$query = $this->query->searchForTitle($search);
		
		return $query->result_array();
	}
	
	/*******************************************************************
	 * modify_media -- modifies a media in the media table
	 * @pre - $attr is an array that contins elements that correspond to
					columns in the media table. $attr['id'] must be a
					valid ID in the database
	 * @post - none
	*******************************************************************/
	function modify_media($attr)
	{	
		$this->query->modify_media($attr['media_id'], $this->session->userdata('user_id'), $attr['genre'], 
					   $attr['title'], $attr['author'], $attr['publisher'], 
					   $attr['ISBN'], $attr['artist'], $attr['writer'],
			      		   $attr['director']);
	}
	
	/*******************************************************************
	 * delete -- deletes a media from the database
	 * @pre - $media_id must be a valid ID in the database
	 * @post - the appropriate media has been deletedf from the database
	*******************************************************************/
	function delete($media_id)
	{
		$this->query->deleteMedia($media_id);
	}
	
	/*******************************************************************
	 * mediaData -- retrieves all data associated with a media
	 * @pre - $media_id must be a valid ID in the database
	 * @post - returns all data for the specified media
	*******************************************************************/
	function mediaData($media_id)
	{
		$query = $this->query->mediaData($media_id);
		$media = $query->result_array();
		return $media[0];
	}
}

?>
