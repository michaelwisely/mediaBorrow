<?php
/*****************************************************************************
* suggestion_model.php
*
* Contains methods which are used by controllers to access information regarding
* site suggestions. This class inherits from a Query class, which contains SQL queries
* which are necessary for suggestion functions:
* 
* Suggestion_model - constructor which calls the constructor of the Query class
* suggest - lets user make a suggestion
****************************************************************************/
class Suggestion_model extends Query
{
	/*******************************************************************
	 * Suggestion_model -- constructor for the Suggestion_model class
	 * @pre - none
	 * @post - none
	*******************************************************************/
	function Suggestion_model()
	{
		parent::Query();
	}
	/*******************************************************************
	 * suggest-- adds a suggestion to the suggestions table
	 * @pre - none
	 * @param - $post is an array ($_POST) with keys 'topic' and 'suggestion'
	 * @post - a new suggestion has been added to the database
	*******************************************************************/
	function suggest($post)
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		
		$this->query->makeSiteSuggestion($CI->user_model->currentUser(), $post['topic'], $post['suggestion']);
	}
}

?>