<?=$this->load->view('header', array('profile' => false))?>

<div id="container">
	<div id="sidebar">
		<?php if ( sizeof($borrow_requests) > 0 ): ?>
		<h3> Borrow Requests </h3>
			<ul>
				<?php foreach($borrow_requests as $b_request):
					$media_id = $b_request['media_id'];
					$b_id = $b_request['user_id'];
					$s_date = $b_request['start_date'];
					$title = $b_request['title'];?>
				<p> <strong><?=anchor("/profile/$b_id", $b_id)?></strong> wants to borrow <br><?=anchor("/media/view/$media_id", $title)?>
				<br><strong><?=anchor("borrow/confirmRequest/$media_id/$b_id/$s_date", "LEND!", 'style="color:green"')?></strong> or 
				<strong><?=anchor("borrow/denyRequest/$media_id/$b_id/$s_date", "DENY!", 'style="color:red"')?></strong><hr></p>
				<?php endforeach; ?>
			</ul>
			</br>
		<?php endif; ?>
		<h3> Stuff you have checked out </h3>
		<?php if ( sizeof($borrowed_items['confirmed']) > 0 ): ?>
			<h4>Confirmed:</h4>
			<ul>
				<?php foreach($borrowed_items['confirmed'] as $b):
					$title= $b['title'];
					$media_id = $b['media_id'];
					$type = $b['type'];
					$s_date = $b['start_date'];
					$status = $b['title'];
					$owner = $b['user_id'];?>
				<p> <strong><?=anchor("/profile/$owner", $owner)?>'s</strong> <?=anchor("/media/view/$media_id", "$title ($type)")?>
				<br>started <strong><?=date("F j, Y", $s_date)?></strong><hr></p>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( sizeof($borrowed_items['active']) > 0 ): ?>
			<h4>Active:</h4>
			<ul>
				<?php foreach($borrowed_items['active'] as $b):
					$title= $b['title'];
					$media_id = $b['media_id'];
					$type = $b['type'];
					$s_date = $b['start_date'];
					$status = $b['title'];
					$owner = $b['user_id'];?>
				<p> <strong><?=anchor("/profile/$owner", $owner)?>'s</strong> <?=anchor("/media/view/$media_id", "$title ($type)")?>
				<br>started <strong><?=date("F j, Y", $s_date)?></strong><hr></p>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php if ( sizeof($borrowed_items['confirmed']) == 0 && sizeof($borrowed_items['active']) == 0 ): ?>
			<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nothing new here. </p>
		<?php endif; ?>
		<br>
		<h3> Stuff you're lending </h3>
		<h4> Confirmed:</h4>
		<?php $confirmed = $lends['confirmed'] ?>
		<?php if ( sizeof($confirmed) > 0 ): ?>
			<ul>
				<?php foreach($confirmed as $l):
					$media_id = $l['media_id'];
					$b_id = $l['user_id'];
					$s_date = $l['start_date'];
					$title = $l['title'];?>
				<p> <strong><?=anchor("/profile/$b_id", $b_id)?></strong> is ready to pick up  <?=anchor("/media/view/$media_id", $title)?>
				<br><strong><?=anchor("borrow/handItOver/$media_id/$b_id/$s_date", "Hand it over!", 'style="color:red"')?></strong><hr></p>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No future pick-ups!</p>
		<?php endif; ?>
		<h4> Active:</h4>
		<?php $active = $lends['active'] ?>
		<?php if ( sizeof($active) > 0 ): ?>
			<ul>
				<?php foreach($active as $l):
					$media_id = $l['media_id'];
					$b_id = $l['user_id'];
					$s_date = $l['start_date'];
					$title = $l['title'];?>
				<p><strong><?=anchor("/profile/$b_id", $b_id)?></strong> is borrowing <?=anchor("borrow/returnItem/$media_id", "$title")?>
				<br><strong><?=anchor("borrow/returnItem/$media_id/$b_id/$s_date", "Got it back?", 'style="color:red"')?></strong><hr></p>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No active lends! </p>
		<?php endif; ?>
	</div>
	
	<div id="main">
		<h1>Hello, <?=$userData['fname']?></h1>
		<h2>Your Media</h2>
		<h4><?=anchor('add/media', 'Add media')?></h4><br />
		<?=$this->load->view('media_list')?>

	</div>
</div>
<?$this->load->view('footer')?>