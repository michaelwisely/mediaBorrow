<?php

function areFriends($user1, $user2)
{
	$CI =& get_instance();
	$CI->load->model('friend_model');
	return $CI->friend_model->areFriends($user1, $user2);
}

function getFriendData($user_id)
{
	$CI =& get_instance();
	$CI->load->model('user_model');
	return $CI->user_model->userData($user_id);
}

?>