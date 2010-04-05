<?php

class Media extends Controller {

	function Media()
	{
		parent::Controller();
		
		$this->load->helper('form');
		$this->load->helper('url');
	}
	
	function index()
	{
		$this->load->view('welcome');
	}
	
	function show()
	{
		$this->load->view('media_list');
	}
}