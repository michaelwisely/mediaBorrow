<?=$this->load->view('header')?>
<div id="container">
	<div id="sidebar">
		<h4><strong>Information about <?=$userData['fname']?></strong></h4>
		<p><strong>City</strong> - <?=$userData['city']?>, <?=$userData['state']?></p>
		<p><strong>Zip code</strong> - <?=$userData['zip']?></p>
		<p><strong>Birth date</strong> - <?=birthday($userData['dob'])?>
	</div>
	
	<div id="main">
		<h1 style="margin-bottom:0"><?=$userData['fname']?> <?=$userData['lname']?></h1>
		<h3 style="margin-bottom:0"><?=$userData['user_id']?></h3>
		<?php if($this->session->userdata('user_id') == $userData['user_id']): ?>
			<p>This is you!</p>
		<?php else: ?>
			<p><?=anchor('friend/request/'.$userData['user_id'], 'Request friendship')?></p>
		<?php endif; ?>
		<br />
		<h2><?=$userData['fname']?>'s media</h2><br /><br />
		<?=$this->load->view('media_list', array('profile' => true))?>
	</div>
</div>
<?$this->load->view('footer')?>