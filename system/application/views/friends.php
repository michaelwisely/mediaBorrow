<?=$this->load->view('header')?>
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
	<?php if (sizeof($friends)>0): ?>
		<h2>Friends:</h2>
		<?php foreach($friends as $friend):?>
			<p>&nbsp;&nbsp;&nbsp;
			<strong><?=anchor("/profile/$friend", $friend)?> </strong>
		<?php endforeach;?>
		<br>
	<?php else: ?>
		Oh no! No friends! :( Check out some user <?=anchor('search/media','libraries')?> and make some.
	<?php endif; ?>
</div>
<?$this->load->view('footer')?>