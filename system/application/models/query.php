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
					WHERE media_id = $media_id;");
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

	function addcomment($user_id, $media_id, $comment_text, $rating)
	{
		$curr_time = getdate();
		$time = $curr_time['year']."-".$curr_time['mon']."-".
			$curr_time['mday']." ".$curr_time['hours'].":".
			$curr_time['minutes'].":".$curr_time['seconds'];
		return $this->db->simple_query("INSERT INTO COMMENTS
						VALUES(\"$user_id\", $media_id,
							\"$comment_text\", $rating, \"$time\");");
	}

	function requestBorrow($borrower_id, $media_id)
	{
		
		return $this->db->simple_query("INSERT INTO BORROWS
						 VALUES(\"$borrower_id\", $media_id,
							\"pending\", NULL, NULL);");
	}

	function approveBorrow($borrower_id, $media_id, $start_date, $return_date)
	{
		return $this->db->simple_query("UPDATE BORROWS
						SET status = 'confirmed', start_date = \"$start_date\", end_date = \"$end_date\"
						WHERE = \"$borrower_id\" AND media_id = $media_id AND status = 'pending';");
	}

	function lendItem($borower_id, $media_id)
	{
		return $this->db->simple_query("UPDATE BORROWS
						SET status = 'active'
						WHERE user_id = \"$borrower_id\"
						AND media_id = $media_id
						AND status = 'confirmed';");
	}

	function returnItem($user_id, $media_id)
	{
		return $this->db->simple_query("UPDATE borrows
						SET status = \"returned\"
						WHERE where user_id = \"$user_id\"
						AND media_id = $media_id
						AND status = \"active\";");
	}

	function deleteItem($media_id)
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

	function inviteNewUser($new_user_email, $new_user_name)
	{
		return $this->db->simple_query("INSERT INTO REFERS
						VALUES (current_user_ID,
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
		$curr_time = getdate();
		$time = $curr_time['year']."-".$curr_time['mon']."-".
			$curr_time['mday']." ".$curr_time['hours'].":".
			$curr_time['minutes'].":".$curr_time['seconds'];
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
		return $this->db->query("SELECT title, type
					FROM BORROWS b, MEDIA m
					WHERE b.user_id = \"$user_id\"
					  AND b.media_id = m.media_id;");
	}

	function getItemsLentOutBy($user_id)
	{
		return $this->db->query("SELECT b.user_id
					FROM MEDIA m, BORROWS b
					WHERE m.user_id = \"$user_id\"
					  AND m.media_id = b.media_id 
					  AND status = 'active';");
	}

	function getComments($media_id)
	{
		return $this->db->query("SELECT comment
					FROM COMMENTS
					WHERE media_id = $media_id;");
	}

	function getBorrowRequests($user_id)
	{
		return $this->db->query("SELECT b.media_id, b.user_id
					FROM BORROWS b
					WHERE status = 'pending'
					  AND borrows.user_id = \"$user_id\"; ");
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
		return $this->db->query("SELECT AVG(rating)
					FROM COMMENTS
					WHERE media_id = $media_id;");
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
						publish = \"$publisher\",
						ISBN = \"$ISBN\",
						artist = \"$artist\",
						writer = \"$writer\",
						director = \"$director\"
					WHERE MEDIA.media_id = $media_id
						AND MEDIA.user_id = \"$user_id\"");
	}

}



