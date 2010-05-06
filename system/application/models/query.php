<?php

class Query extends Model
{
	function Query()
	{
		parent::Model();
	}

	function addNewUser($user_id, $email, $password, $zip, $fname, $lname, $day, $month, $year)
	{
		$zips = "SELECT zip FROM ZIPS WHERE zip = $zip";
		$zips = $this->db->query($zips);
		if($zips->num_rows() == 0)
		{
			$CI =& get_instance();
			$CI->load->helper('location');
			$cityState = zipCodeLookup($zip);
			
			$this->db->simple_query("INSERT INTO ZIPS
						VALUES($zip, '".$cityState['city']."', '".$cityState['state']."')");
		}
		
		$user_id = strtolower($user_id);
		$email = strtolower($email);
		$dob = "$year-$month-$day";
		
		return $this->db->simple_query("INSERT INTO USERS
					VALUES(\"$user_id\", \"$email\",
					\"$password\", $zip,
					\"$fname\", \"$lname\", \"$dob\", NULL);");
	}
	
	function userData($user_id)
	{
		$userData = "SELECT * FROM USERS WHERE user_id = \"$user_id\"";
		
		return $this->db->query($userData);
	}
	
	function mediaData($media_id)
	{
		return $this->db->query("SELECT *
					FROM MEDIA
					WHERE media_id = \"$media_id\";");
	}

	function addMedia($user_id, $genre, $title, $type,
			  $author, $publisher, $ISBN, $artist,
			  $writer, $director)
	{
		if($type == "book")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA (`user_id`, `genre`, `title`, `type`, `author`, `publisher`, `ISBN`)
					VALUES(\"$user_id\",
						\"$genre\", \"$title\",
						\"$type\", \"$author\",
						\"$publisher\", \"$ISBN\");");
		}
		else if($type == "cd")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA (`user_id`, `genre`, `title`, `type`, `artist`)
					VALUES(\"$user_id\",
						\"$genre\", \"$title\", \"$type\", \"$artist\");");
		}
		else if($type == "movie")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA (`user_id`, `genre`, `title`, `type`, `writer`, `director`)
				VALUES(\"$user_id\", \"$genre\",
					\"$title\", \"$type\", \"$writer\", \"$director\");");
		}
		return $temp;
	}

	function requestFrienship($user_id1, $user_id2)
	{
		return $this->db->simple_query("INSERT INTO FRIENDS
					VALUES(\"$user_id1\", \"$user_id2\", true);");
	}

	function acceptFriendRequest($user_id1, $user_id2)
	{
		return $this->db->simple_query("UPDATE FRIENDS
				SET pending = false
				WHERE uid1 = \"$user_id1\"
					AND uid2 = \"$user_id2\";");
	}

	function getFriendRequests($user_id)
	{
		return $this->db->query("SELECT user_id1
					FROM FRIENDS
					WHERE pending = \"true\"
					  AND user_id2 = \"$user_id\";");
	}

	function addComment($user_id, $media_id, $comment_text, $rating)
	{
		$time = mktime();
		
		return $this->db->simple_query("INSERT INTO COMMENTS
						VALUES(\"$user_id\", $media_id,
							\"$comment_text\", $rating, \"$time\");");
	}
	
	function editComment($user_id, $media_id, $comment_text, $rating)
	{
		$time = mktime();
		
		return $this->db->simple_query("UPDATE COMMENTS
						SET comment = \"$comment_text\", rating = \"$rating\", time_stamp = \"$time\"
						WHERE user_id = \"$user_id\"
						AND media_id = \"$media_id\";");
	}
	
	function getCityStateForZip($zip)
	{
	   $cityState = $this->db->query("SELECT city, state
	                                   FROM ZIPS
	                                   WHERE zip = \"$zip\";");
	   $array = $cityState->result_array();
	   return $array[0];
	}

	function requestBorrow($borrower_id, $media_id)
	{
		$start_date = mktime();
		return $this->db->simple_query("INSERT INTO BORROWS
						 VALUES(\"$borrower_id\", $media_id,
							\"pending\", $start_date, NULL);");
	}
	
	function isRequested($borrower_id, $media_id)
	{
		$table = $this->db->query("SELECT *
					  FROM BORROWS
					  WHERE user_id = \"$borrower_id\"
					    AND media_id = $media_id
					    AND status = 'pending';");
		if ($table->num_rows() > 0 )
		{
			return "pending";
		}
		$table = $this->db->query("SELECT *
					  FROM BORROWS
					  WHERE user_id = \"$borrower_id\"
					    AND media_id = $media_id
					    AND status = 'active';");
		if ($table->num_rows() > 0 )
		{
			return "active";
		}
		$table = $this->db->query("SELECT *
					  FROM BORROWS
					  WHERE user_id = \"$borrower_id\"
					    AND media_id = $media_id
					    AND status = 'confirmed';");
		if ($table->num_rows() > 0 )
		{
			return "confirmed";
		}

		else
		{
			return false;
		}
	}
	
	function isCheckedOut($media_id)
	{
		$table = $this->db->query("SELECT user_id
					  FROM BORROWS
					  WHERE media_id = $media_id
					    AND (status = 'active'
						OR status = 'confirmed'); ");
		if ($table->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function approveBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->db->simple_query("UPDATE BORROWS
						SET status = 'confirmed'
						WHERE user_id= \"$borrower_id\"
						  AND media_id = $media_id
						  AND start_date = $start_date
						  AND status = 'pending';");
	}
	
	function refuseBorrow($borrower_id, $media_id, $start_date)
	{
		return $this->db->simple_query("DELETE FROM BORROWS
						WHERE user_id= \"$borrower_id\"
						  AND media_id = $media_id
						  AND start_date = $start_date
						  AND status = 'pending';");
	}

	function lendItem($borrower_id, $media_id)
	{
		return $this->db->simple_query("UPDATE BORROWS
						SET status = 'active'
						WHERE user_id = \"$borrower_id\"
						AND media_id = $media_id
						AND status = 'confirmed';");
	}

	function returnItem($user_id, $media_id, $start_date)
	{
		$return_date = mktime();
		
		return $this->db->simple_query("UPDATE BORROWS
						SET status = 'returned', return_date = $return_date
						WHERE user_id = \"$user_id\"
						AND media_id = $media_id
						AND start_date = $start_date
						AND status = 'active';");
		
	}

	function deleteMedia($media_id)
	{
		return $this->db->simple_query("DELETE FROM MEDIA
					WHERE media_id = $media_id;");
	}

	function deleteFriend($user_id1, $user_id2)
	{
		return $this->db->simple_query("DELETE FROM FRIENDS
					WHERE uid1 = \"$user_id1\" AND uid2 = \"$user_id2\";");
	}

	function deleteComment($user_id1, $media_id, $time_stamp)
	{
		return $this->db->simple_query("DELETE FROM COMMENTS
						WHERE user_id = \"$user_id\" 
						AND media_id = \"$media_id\" 
						AND time_stamp = \"$time_stamp\";");
	} 

	function inviteNewUser($user_id, $new_user_email, $new_user_name)
	{
		return $this->db->simple_query("INSERT INTO REFERS
						VALUES (\"$user_id\",
							\"$new_user_email\",
							\"$new_user_name\");");
	}
	
	function updateUserProfile($email, $password, $zip, $fname, $lname, $dob, $area)
	{
		if ($area != "NULL")
		{
			$area = "\"$area\"";
		}
		return $this->db->simple_query("UPDATE USERS
					SET email = \"$email\",
					    password =\"$password\",
					    zip = $zip,
					    fname = \"$fname\",
					    lname = \"$lname\",
					    dob = \"$dob\",
					    area = $area
					WHERE user_id = \"$user_id\";");
	} 
 
	function makeSiteSuggestion($user_id, $topic, $suggestion)
	{
		$time = mktime();
		$topic = strtolower($topic);
		
		return $this->db->simple_query("INSERT INTO SUGGESTIONS
						VALUES(\"$user_id\", \"$topic\",
							\"$time\", \"$suggestion\");");
	}

	function getProfileInformation($user_id)
	{
		return $this->db->query("SELECT *
					FROM USERS
					WHERE user_id = \"$user_id\";");
	}

	function getBorrowItemsBorrowedBy($user_id)
	{
		$table = $this->db->query("SELECT m.title, m.type, b.status, b.start_date, m.user_id, m.media_id
					FROM BORROWS b, MEDIA m
					WHERE b.user_id = \"$user_id\"
					  AND b.media_id = m.media_id;");
		return $table->result_array();
	}

	function getItemsLentOutBy($user_id)
	{
		$table = $this->db->query("SELECT b.user_id, b.media_id, b.start_date, m.title
					FROM MEDIA m, BORROWS b
					WHERE m.user_id = \"$user_id\"
					  AND m.media_id = b.media_id 
					  AND status = 'active'; ");
		$data['active'] = $table->result_array();
		$table = $this->db->query("SELECT b.user_id, b.media_id, b.start_date, m.title
					FROM MEDIA m, BORROWS b
					WHERE m.user_id = \"$user_id\"
					  AND m.media_id = b.media_id 
					  AND status = 'confirmed';");
		$data['confirmed'] = $table->result_array();
		return $data;
	}

	function getComments($media_id)
	{
		return $this->db->query("SELECT *
					FROM COMMENTS
					WHERE media_id = \"$media_id\"
					ORDER BY time_stamp DESC;");
	}

	function getBorrowRequests($user_id)
	{
		return $this->db->query("SELECT m.media_id, m.title, m.media_id, b.user_id, b.start_date
					FROM BORROWS b, MEDIA m
					WHERE b.status = 'pending'
					  AND m.user_id = \"$user_id\"
					  AND b.media_id = m.media_id; ");
	}

	function searchForTitle($title = NULL)
	{
		if($title == NULL)
			return $this->db->query("SELECT *
						FROM MEDIA;");
		
		return $this->db->query("SELECT *
					FROM MEDIA
					WHERE title LIKE \"%$title%\";");
	}

	function getPassword($user_id)
	{
		return $this->db->query("SELECT password
					FROM USERS
					WHERE user = \"$user_id\";");
	}

	function getNumberOfFriends($user_id)
	{
		return $this->db->query("SELECT COUNT(user_id1)
					FROM friend
					WHERE pending = false;");
	}

	function listFriends($user_id)
	{
		return $this->db->query("SELECT user_id2
					FROM FRIENDS
					WHERE pending = \"false\"
					  AND user_id1 = \"$user_id\"
					UNION
					SELECT user_id1
					FROM FRIENDS
					WHERE pending = \"false\"
					  AND user_id2 = \"$user_id\";");
	}

	function bestRatedMedia()
	{
		$books = $this->db->query("SELECT title, author
					FROM MEDIA m, COMMENTS c
					WHERE type = 'book' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							 FROM COMMENTS );");

		$cds = $this ->db->query("SELECT title, artist
					FROM MEDIA m, COMMENTS c
					WHERE type = 'CD' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							 FROM COMMENTS );");

		$movies = $this->db->query("SELECT title, writer, director
					FROM MEDIA m, COMMENTS c
					WHERE type = 'movie' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							FROM COMMENTS );");
		return array("books"=>$books, "cds"=>$cds, "movies"=>$movies);
	}

 
	function getAverageRating($media_id)
	{
		$query = $this->db->query("SELECT AVG(rating)
					FROM COMMENTS
					WHERE media_id = $media_id;");
		foreach($query->result_array() as $array)
			$result = $array['AVG(rating)'];
		return substr($result, 0, 3);
	}

	function getPastBorrows($user_id)
	{
		return $this->db->query("SELECT start_date, return_date, title
					FROM BORROWS b, MEDIA m
					WHERE b.media_id = m.media_id 
					  AND status = 'returned' 
					  AND b.user_id = \"$user_id\";");
	}
	function getUserLibrary($user_id)
	{
		$cds =  $this->db->query("SELECT *
					FROM MEDIA
					WHERE user_id = \"$user_id\"
					AND type = 'cd';");
		$books = $this->db->query("SELECT *
					  FROM MEDIA
					  WHERE user_id = \"$user_id\"
					  AND type = 'book';");
		$movies = $this->db->query("SELECT *
					  FROM MEDIA
					  WHERE user_id = \"$user_id\"
					  AND type = 'movie';");
		return array("books"=>$books, "movies"=>$movies, "cds"=>$cds);

	}
	
	function modify_media($media_id, $user_id, $genre, $title,
			      $author, $publisher, $ISBN, $artist, $writer,
			      $director)
			      
	{			
		return $this->db->query("UPDATE MEDIA
					SET genre = \"$genre\",
						title = \"$title\",
						author = \"$author\",
						publisher = \"$publisher\",
						ISBN = \"$ISBN\",
						artist = \"$artist\",
						writer = \"$writer\",
						director = \"$director\"
					WHERE MEDIA.media_id = $media_id
						AND MEDIA.user_id = \"$user_id\"");
	}
	
	function install($post)
	{
		//create all the tables in the database
		$zips = 'CREATE TABLE ZIPS( zip char(5) NOT NULL, city varchar(50) NOT NULL, state varchar(20) NOT NULL, PRIMARY KEY (zip) )ENGINE = InnoDB;';
		$this->db->query($zips);
		
		$users = 'CREATE TABLE USERS( user_id varchar(50) NOT NULL, email varchar(100) NOT NULL UNIQUE, password varchar(50) NOT NULL, zip char(5) NOT NULL, fname varchar(50) NOT NULL, lname varchar(50) NOT NULL, dob varchar(10), area varchar(20), PRIMARY KEY (user_id), FOREIGN KEY (zip) REFERENCES ZIPS(zip) )ENGINE = InnoDB;';
		$this->db->query($users);
		
		$suggestions = 'CREATE TABLE SUGGESTIONS( user_id varchar(50) NOT NULL, topic varchar(100) NOT NULL, time_stamp integer NOT NULL, suggestion text, PRIMARY KEY (user_id, time_stamp), FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE)ENGINE = InnoDB;';
		$this->db->query($suggestions);
		
		$refers = 'CREATE TABLE REFERS( user_id varchar(50) NOT NULL, email varchar(50) NOT NULL, name varchar(100), PRIMARY KEY (user_id, email), FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE )ENGINE = InnoDB;';
		$this->db->query($refers);
		
		$friends = 'CREATE TABLE FRIENDS( user_id1 varchar(50) NOT NULL, user_id2 varchar(50) NOT NULL, pending varchar(5) NOT NULL, PRIMARY KEY (user_id1, user_id2), FOREIGN KEY (user_id1) REFERENCES USERS(user_id) ON DELETE CASCADE, FOREIGN KEY (user_id2) REFERENCES USERS(user_id) ON DELETE CASCADE, CHECK (user_id1 != user_id2) )ENGINE = InnoDB;';
		$this->db->query($friends);
		
		$media = 'CREATE TABLE MEDIA( media_id integer NOT NULL AUTO_INCREMENT, user_id varchar(50) NOT NULL, genre varchar(50) NOT NULL, title varchar(200) NOT NULL, type varchar(20) NOT NULL, author varchar(100), publisher varchar(100), ISBN varchar(40), artist varchar(100), writer varchar(100), director varchar(100), PRIMARY KEY (media_id), FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE)ENGINE = InnoDB;';
		$this->db->query($media);
		
		$borrows = 'CREATE TABLE BORROWS( user_id varchar(50) NOT NULL, media_id integer NOT NULL, status varchar(15) NOT NULL, start_date integer NOT NULL, return_date integer, PRIMARY KEY (user_id, media_id, start_date), FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE, FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) ON DELETE CASCADE )ENGINE = InnoDB;';
		$this->db->query($borrows);
		
		$comments = 'CREATE TABLE COMMENTS( user_id varchar(50) NOT NULL, media_id integer NOT NULL, comment text, rating integer, time_stamp integer NOT NULL, PRIMARY KEY (user_id, media_id), FOREIGN KEY (user_id) REFERENCES USERS(user_id) ON DELETE CASCADE, FOREIGN KEY (media_id) REFERENCES MEDIA(media_id) ON DELETE CASCADE )ENGINE = InnoDB;';
		$this->db->query($comments);
		
		//insert the first user into the database
		$this->addNewUser($post['user_id'], $post['email'], $post['password'], $post['zip'], $post['fname'], $post['lname'], $post['day'], $post['month'], $post['year']);
	}

}



