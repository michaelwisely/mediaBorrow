<?php /*****************************************************************************
 *  friends.php
 *  
 *  Displays a list of friend requests as well as current friends. Called by
 *  Friend controller and accessed by Friends link in the page header.
 *
 ****************************************************************************/ ?>
<?=$this->load->view('header')?>
<?=$this->load->helper('friendship')?>
<div id="container">
	<?php if (sizeof($requests)>0): ?>
		<h2>Friend Requests:</h2>
		<?php foreach($requests as $req):?>
			<p>&nbsp;&nbsp;&nbsp;
			<strong><?=anchor("/profile/$req", $req)?> </strong>=>
			<?=anchor("friend/confirm/$req", "accept", 'style="color:green"')?>
			friend request or 
			<?=anchor("friend/reject/$req", "deny.", 'style="color:red"')?></p>
		<?php endforeach;?>
		<hr>
	<?php endif; ?>
	<h2>Friends:</h2>
	<?php if (sizeof($friends)>0): ?>
		<?php foreach($friends as $friend):?>
			<p>&nbsp;&nbsp;&nbsp;
			<?php $friendData = getFriendData($friend);?>
			<strong><?=anchor("/profile/$friend", $friend)?> (<?= $friendData['fname'].' '.$friendData['lname'] ?>)</strong>
		<?php endforeach;?>
		<br>
	<?php else: ?>
		<p>&nbsp;&nbsp;&nbsp;Oh no! No friends! :( Check out some user <?=anchor('search/media','libraries')?> and make some.</p>
	<?php endif; ?>
</div>
<?$this->load->view('footer')?>