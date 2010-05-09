<?php
/*****************************************************************************
 *  media.php
 *  
 *  Contains methods which correspond to webpages that are responsible for
 *  modifying information regarding user media. This class inherits
 *  from MY_Controller, which verifies that mediaBorrow is installed and
 *  the user is logged in. The following pages are included:
 *
 *  __construct -- constructor, loads media model
 *  index -- redirects user to their home page.
 *  search -- prepares the page which is loaded when users do a search for media
 *  add -- prepares the page which users use to add media to their libraries
 *  edit -- prepares the page which users use to edit media in their libraries
 *  delete -- prepares the page which users use to delete media from their libraries
 *  view -- prepares the page which users use to view any media and make comments (loads comment model)
 *
 ****************************************************************************/

class Media extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('media_model');
	}
	
	function index()
	{
		redirect('');
	}
	
	function search()
	{
		if($_POST == NULL)
			$_POST['search'] = NULL;
		
		$data['title'] = 'Search Results';
		$data['search'] = $_POST['search'];
		$results = $this->media_model->search($_POST['search']);
		
		
		
		//Figure out which media belongs to who and what type they are
		$currentUser = $this->session->userdata('user_id');
		$data['books'] = array();
		$data['movies'] = array();
		$data['cds'] = array();
		
		foreach($results as $media)
		{
			$media['rating'] = $this->query->getAverageRating($media['media_id']);
			
			if($media['user_id'] == $currentUser)
				$media['thisUser'] = true;
			else
				$media['thisUser'] = false;
			
			if($media['type'] == 'book')
				array_push($data['books'], $media);
			if($media['type'] == 'movie')
				array_push($data['movies'], $media);
			if($media['type'] == 'cd')
				array_push($data['cds'], $media);
		}
		
		
		$this->load->view('search_results', $data);
	}
	
	function add()
	{
		if($_POST == NULL)
		{
			$data['title'] = 'Add New Media';
			$this->load->view('media_add', $data);
		}
		else
		{
			$this->media_model->add($_POST);
			
			$data['title'] = $_POST['title'].' Successfully Added';
			$data['message'] = $_POST['title'].' has been added to your library';
			$this->load->view('confirmation', $data);
		}
	}
	
	function edit()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$data['media'] = $this->media_model->mediaData($media_id);
			$data['title'] = 'Edit '.$data['media']['title'];
			$this->load->view('media_edit', $data);
		}
		else
		{
			$this->media_model->modify_media($_POST);
			
			$data['title'] = $_POST['title'].' Successfully Edited';
			$data['message'] = $_POST['title'].' has been changed in your library';
			$this->load->view('confirmation', $data);
		}
	}
	
	function delete()
	{
		if($_POST == NULL)
		{
			$media_id = $this->uri->segment(3);
			$media = $this->media_model->mediaData($media_id);
			$data['title'] = 'Delete '.$media['title'];
			$data['id'] = $media_id;
			$data['message'] = 'Are you sure you want to delete '.$media['title'].'?';
			$data['function'] = 'media/delete';
			$this->load->view('are_you_sure', $data);
		}
		else
		{
			$this->media_model->delete($_POST['id']);
			
			$data['title'] = 'Media Deleted';
			$data['message'] = 'Your media has been deleted.';
			$this->load->view('confirmation', $data);
		}
	}
	
	function view()
	{
		$this->load->model('comment_model');
		
		$data['media'] = $this->media_model->mediaData($this->uri->segment(3));
		$data['title'] = $data['media']['title'];
		$data['comments'] = $this->comment_model->getComments($data['media']['media_id']);
		
		$this->load->view('media', $data);
	}
}