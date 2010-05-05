<?=$this->load->view('header', array('profile' => false))?>

<div id="container">
	<div id="sidebar">
		<h3> Borrow Requests </h3>
		<?php if ( sizeof($borrow_requests) > 0 ): ?>
			<ul>
				<?php foreach($borrow_requests as $b_request): ?>
				<li> <?=$b_request['user_id']?> wants to borrow <?= $b_request['title']?></li>
				<?php endforeach; ?>
			</ul>
		<?php else: ?>
			<p> No new borrow requests! </p>
		<?php endif; ?>
	</div>
	
	<div id="main">
		<h1>Hello, <?=$userData['fname']?></h1>
		<h2>Your Media</h2>
		<h4><?=anchor('add/media', 'Add media')?></h4><br />
		<?=$this->load->view('media_list')?>

	</div>
</div>
</body>
</html>