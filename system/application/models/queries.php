<?php

class Queries extends Model
{
	function Queries()
	{
		parent::Model();
	}

	function addNewUser($user_id, $email, $password, $zip, $fname, $lname, $dob)
	{
		$this->db->query("INSERT INTO USERS
				VALUES($user_id, $email,
				$password, $zip,
				$fname, $lname, $dob, NULL);");
		return true;
	}

	function addMedia($media_id, $user, $genre, $title, $type,
			  $author, $publisher, $ISBN, $artist,
			  $writer, $director)
	{
		if($type == "book")
		{
		$this->db->query("INSERT INTO MEDIA 
				VALUES($media_id, $user,
					$genre, $title,
					$type, $author,
					$publisher, $ISBN,
					NULL, NULL, NULL);");
		}
		else if($type == "cd")
		{
			$this->db->query("INSERT INTO MEDIA 
					VALUES($media_id, $user_id,
						$genre, $title, $type,
						NULL, NULL, NULL, $artist, 
						NULL, NULL);");
		}
		else if($type == "movie")
		{
			$this->db->query("INSERT INTO MEDIA 
				VALUES($media_id, $user_id, $genre,
					$title, $type, NULL, NULL,
					NULL, NULL, $writer, $director);");
		}
		return true;
	}

	function requestFrienship($user_id1, $user_id2)
	{
		$this->db->query("INSERT INTO FRIENDS
			VALUES($user_id1, $user_id2, true);");
		return true;
	}

	function acceptFriendRequest($userid1, $user_id2)
	{
		$this->db->query("UPDATE FRIENDS
			SET pending = false
			WHERE uid1 = $user_id1 AND uid2 = $user_id2;");
		return true;
	}

	function getFriendRequests($userid)
	{
		$table = $this->db->query("SELECT userid2
					FROM FRIENDS
					WHERE userid1 = $userid
					UNION
					SELECT userid1
					FROM FRIENDS
					WHERE userid2 = $userid;");
		return $table;
	}

	function addcomment($user_id, $media_id, $comment_text, $rating)
	{
		$curr_time = getdate();
		$time = $curr_time['year']."-".$curr_time['mon']."-".
			$curr_time['mday']." ".$curr_time['hours'].":".
			$curr_time['minutes'].":".$curr_time['seconds'];
		$this->db->query("INSERT INTO COMMENTS
				 VALUES($user_id, $media_id,
					$comment_text, $rating, $time);");
	}

	function requestBorrow($borrower_id, $media_id)
	{
		
		$this->db->query("INSERT INTO BORROWS
				 VALUES($borrower_id, $media_id,
					\"pending\", NULL, NULL);");
	}

 
//approveBorrow
//
//UPDATE borrows
//SET status = 'confirmed', start_date = $start_date, end_date = $end_date
//WHERE = $borrower_id AND media_id = $media_id;
// 
//lendItem
//
//UPDATE borrows
//SET status = 'active'
//WHERE user_id = $borrower_id AND media_id = $media_id;
// 
//deleteItem
//
//DELETE FROM friend
//WHERE uid1 = $user_id1 AND uid2 = $user_id2;
// 
//deleteComment
//
//DELETE FROM comments
//WHERE user_id = $user_id 
//    AND media_id = $media_id 
//    AND time_stamp = $time_stamp;
// 
//returnItem
//
//UPDATE borrows
//SET status = "returned"
//WHERE where user_id = $user_id AND media_id = $media_id;
// 
//inviteNewUser
//
//INSERT INTO reference values (current_user_ID, $new_user_email, $new_user_name);
// 
//updateUserProfile
//
//UPDATE user
//SET email = $email, password = $password, zip = $zip, city = $city, state = $state, f
//name = $fname, lname = $lname, dob = $dob, site_mod = $site_mod, area = $area
//WHERE user_id = $user_id;
// 
// 
//makeSiteSuggestion
//
//INSERT INTO suggestions VALUES($user_id, $topic, $todayAndNow, $suggestion);
// 
//profileInformation
//
//SELECT *
//FROM user
//WHERE user = $user_id;
// 
//getBorrowItemsBorrowedBy
//
//SELECT title, type
//FROM borrows, media
//WHERE borrows.user_id = $user_id AND borrows.media_id = media.media_id 
// 
//getItemsLentOutBy
//
//SELECT borrows.user_id
//FROM media, borrows
//WHERE media.user_id = $user_id AND media.media_id = borrows.media_id 
//AND status = 'active';
// 
//getComments
//
//SELECT comment
//FROM comments
//WHERE comments.media_id = $media_id;
// 
//getFriendRequests
//
//SELECT uid2
//FROM friend
//WHERE pending = ‘true’, uid1 = $user_id
//UNION
//SELECT uid1
//FROM friend
//WHERE pending = ‘true’, uid2 = $user_id;
// 
//getBorrowRequests
//
//SELECT borrow.media_id, borrows.user_id
//FROM borrows
//WHERE status = 'pending' AND borrows.user_id = $user_id; 
//searchForTitle
//
//if book....
//SELECT title, type, author
//FROM media
//WHERE title = $title 
//AND type = 'book';
// 
//else if movie....
//SELECT title, type, director
//FROM media
//WHERE title = $title 
//AND type = 'movie';
// 
//else if cd...
//SELECT title, type, artist
//FROM media
//WHERE title = $title 
//AND type = 'CD';
// 
//logIn
//
//SELECT password
//FROM user
//WHERE user = $user_id
// 
//numberOfFriends
//
//SELECT COUNT(uid1)
//FROM friend
//WHERE pending = false;
// 
//listFriends
//
//SELECT uid2
//FROM friend
//WHERE pending = ‘false’ AND uid1 = $user_id
//UNION
//SELECT uid1
//FROM friend
//WHERE pending = ‘false’ AND uid2 = $user_id;
// 
//bestRatedMedia
//
//for book...
//SELECT title, author
//FROM media, comments
//WHERE type = 'book' 
//	AND media.media_id = comments.media_id
//AND rating = ( SELECT MAX(rating)
//                            	  FROM comments );
// 
//for C.D...
//SELECT title, artist
//FROM media, comments
//WHERE type = 'CD' 
//AND media.media_id = comments.media_id
//AND rating = ( SELECT MAX(rating)
//                                  FROM comments );
//for movie...
//SELECT title, writer, director
//FROM media, comments
//WHERE type = 'movie' 
//AND media.media_id = comments.media_id
//AND rating = ( SELECT MAX(rating)
//                                   FROM comments );
// 
//getAverageRating
//
//SELECT AVG(rating)
//FROM Comments
//WHERE media_id = $media_id;
//
//getPastBorrows
//
//SELECT start_date, return_date, title
//FROM borrows, media
//WHERE borrows.media_id = media.media_id 
//AND status = 'returned' 
//AND user_id = $user_id;
//
}