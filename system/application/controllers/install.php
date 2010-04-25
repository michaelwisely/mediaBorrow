<?php

class Install extends Controller {

	function Install()
	{
		parent::Controller();
	}
	
	function index()
	{
		$query = 'SHOW TABLES';
		$query = $this->db->query($query);
		
		if($query->num_rows() > 0)
			echo 'Your Database is already set up. If you want to reinstall MediaBorrow, please delete everything in your database and run this script again.';
		else
			$this->load->view('install');
		
	}
	
	function do_install()
	{
		if($_POST == NULL)
			redirect('');
		else
		{
			//create all the tables in the database
			$zips = 'CREATE TABLE ZIPS( zip char(5) NOT NULL, city varchar(30) NOT NULL, state varchar(20) NOT NULL, PRIMARY KEY (zip) )ENGINE = InnoDB;';
			$this->db->query($zips);
			
			$users = 'CREATE TABLE USERS( user_id varchar(20) NOT NULL, email varchar(50) NOT NULL UNIQUE, password varchar(50) NOT NULL, zip char(5) NOT NULL, fname varchar(30) NOT NULL, lname varchar(30) NOT NULL, dob integer, area varchar(20), PRIMARY KEY (user_id), FOREIGN KEY (zip) REFERENCES ZIPS(zip) )ENGINE = InnoDB;';
			$this->db->query($users);
			
			$suggestions = 'CREATE TABLE SUGGESTIONS( user_id varchar(20) NOT NULL, topic varchar(100) NOT NULL, stamp timestamp NOT NULL, suggestion text, PRIMARY KEY (user_id, stamp), FOREIGN KEY (user_id) REFERENCES USERS(user_id) )ENGINE = InnoDB;';
			$this->db->query($suggestions);
			
			$refers = 'CREATE TABLE REFERS( user_id varchar(20) NOT NULL, email varchar(50) NOT NULL, name varchar(60), PRIMARY KEY (user_id, email), FOREIGN KEY (user_id) REFERENCES USERS(user_id) )ENGINE = InnoDB;';
			$this->db->query($refers);
			
			$friends = 'CREATE TABLE FRIENDS( user_id1 varchar(20) NOT NULL, user_id2 varchar(20) NOT NULL, pending boolean NOT NULL, PRIMARY KEY (user_id1, user_id2), FOREIGN KEY (user_id1) REFERENCES USERS(user_id), FOREIGN KEY (user_id2) REFERENCES USERS(user_id), CHECK (user_id1 != user_id2) )ENGINE = InnoDB;';
			$this->db->query($friends);
			
			$media = 'CREATE TABLE MEDIA( media_id integer NOT NULL AUTO_INCREMENT, user_id varchar(20) NOT NULL, genre varchar(20) NOT NULL, title varchar(20) NOT NULL, type varchar(20) NOT NULL, author varchar(60), publisher varchar(40), ISBN varchar(40), artist varchar(60), writer varchar(60), director varchar(60), PRIMARY KEY (media_id), FOREIGN KEY (user_id) REFERENCES USERS(user_id) )ENGINE = InnoDB;';
			$this->db->query($media);
			
			$borrows = 'CREATE TABLE BORROWS( user_id varchar(20) NOT NULL, media_id integer NOT NULL, status varchar(15) NOT NULL, start_date timestamp NOT NULL, return_date timestamp, PRIMARY KEY (user_id, media_id, start_date), FOREIGN KEY (user_id) REFERENCES USERS(user_id), FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) )ENGINE = InnoDB;';
			$this->db->query($borrows);
			
			$comments = 'CREATE TABLE COMMENTS( user_id varchar(20) NOT NULL, media_id integer NOT NULL, comment text, rating integer, stamp timestamp NOT NULL, PRIMARY KEY (user_id, media_id), FOREIGN KEY (user_id) REFERENCES USERS(user_id), FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) )ENGINE = InnoDB;';
			$this->db->query($comments);
			
			//insert the first user into the database
			$this->query->addNewUser($_POST['user_id'], $_POST['email'], $_POST['password'], $_POST['zip'], $_POST['fname'], $_POST['lname'], $_POST['day'], $_POST['month'], $_POST['year']);
			
			//show confirmation
			$data['user_id'] = $_POST['user_id'];
			$this->load->view('installed', $data);
		}
	}

}