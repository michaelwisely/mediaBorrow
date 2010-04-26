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
			$this->db->simple_query("INSERT INTO ZIPS
						VALUES($zip, 'nonsense', 'nonsense')");
		
		$dob = mktime(0, 0, 0, $month, $day, $year);
		
		return $this->db->simple_query("INSERT INTO USERS
					VALUES(\"$user_id\", \"$email\",
					\"$password\", $zip,
					\"$fname\", \"$lname\", \"$dob\", NULL);");
	}

	function addMedia($media_id, $user, $genre, $title, $type,
			  $author, $publisher, $ISBN, $artist,
			  $writer, $director)
	{
		if($type == "book")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA 
					VALUES($media_id, \"$user\",
						\"$genre\", \"$title\",
						\"$type\", \"$author\",
						\"$publisher\", \"$ISBN\",
						NULL, NULL, NULL);");
		}
		else if($type == "cd")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA 
					VALUES($media_id, \"$user_id\",
						\"$genre\", \"$title\", \"$type\",
						NULL, NULL, NULL, \"$artist\", 
						NULL, NULL);");
		}
		else if($type == "movie")
		{
			$temp = $this->db->simple_query("INSERT INTO MEDIA 
				VALUES($media_id, \"$user_id\", \"$genre\",
					\"$title\", \"$type\", NULL, NULL,
					NULL, NULL, \"$writer\", \"$director\");");
		}
		return $temp;
	}

	function requestFrienship($user_id1, $user_id2)
	{
		return $this->db->simple_query("INSERT INTO FRIENDS
					VALUES(\"$user_id1\", \"$user_id2\", true);");
	}

	function acceptFriendRequest($userid1, $user_id2)
	{
		return $this->db->simple_query("UPDATE FRIENDS
				SET pending = false
				WHERE uid1 = \"$user_id1\"
					AND uid2 = \"$user_id2\";");
	}

	function getFriendRequests($userid)
	{
		$table = $this->db->query("SELECT userid2
					FROM FRIENDS
					WHERE userid1 = \"$userid\"
					UNION
					SELECT userid1
					FROM FRIENDS
					WHERE userid2 = \"$userid\";");
		return $table;
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
		return $this->db->simple_query("UPDATE USERS
					SET email = \"$email\",
					    password =\"$password\",
					    zip = $zip,
					    fname = \"$fname\",
					    lname = \"$lname\",
					    dob = \"$dob\",
					    area = \"$area\"
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

	function getFriendRequests($user_id)
	{
		return $this->db->query*"SELECT user_id2
					FROM FRIENDS
					WHERE pending = ‘true’
					  AND user_id1 = \"$user_id\"
					UNION
					SELECT user_id1
					FROM FRIENDS
					WHERE pending = ‘true’
					  AND user_id2 = \"$user_id\";");
	}

	function getBorrowRequests($user_id)
	{
		return $this->db->query("SELECT borrow.media_id, borrows.user_id
					FROM borrows
					WHERE status = 'pending'
					  AND borrows.user_id = \"$user_id\"; ");
	}

	function searchForTitle($title)
	{
		return $this->db->query("SELECT title, type
					FROM MEDIA
					WHERE title = \"$title\";");
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
					WHERE pending = ‘false’
					  AND user_id1 = \"$user_id\"
					UNION
					SELECT user_id1
					FROM FRIENDS
					WHERE pending = ‘false’
					  AND uid2 = \"$user_id\";");
	}

	function bestRatedMedia()
	{
		$books = $this->db->query("SELECT title, author
					FROM MEDIA m, COMMENTS c
					WHERE type = 'book' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							 FROM comments );");

		$cds = $this ->db->query("SELECT title, artist
					FROM MEDIA m, COMMENTS c
					WHERE type = 'CD' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							 FROM comments );");

		$movies = $this->db->query("SELECT title, writer, director
					FROM MEDIA m, COMMENTS c
					WHERE type = 'movie' 
					  AND m.media_id = c.media_id
					  AND rating = ( SELECT MAX(rating)
							FROM comments );");
		return array("books"=>$books, "cds"=>$cds, "movies"=>$movies)
	}

 
	function getAverageRating($media_id)
	{
		return $this->db->query("SELECT AVG(rating)
					FROM Comments
					WHERE media_id = $media_id;");
	}

	function getPastBorrows($user_id)
	{
		return $this->db->query("SELECT start_date, return_date, title
					FROM borrows, media
					WHERE borrows.media_id = media.media_id 
					  AND status = 'returned' 
					  AND user_id = \"$user_id\";");
	}
}