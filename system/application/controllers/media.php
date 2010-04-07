<?php

class Media extends MY_controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
	}
	
	function index()
	{
		$this->load->view('welcome');
	}
	
	function show()
	{
		$this->load->view('media_list');
	}
	
	function add()
	{
		$this->load->view('media_add');
	}
}