<?=$this->load->view('header')?>
<div id="container">
	<div id="sidebar">
		<h4><strong>Information about <?=$userData['fname']?></strong></h4>
		<p><strong>City</strong> - <?=$userData['city']?>, <?=$userData['state']?></p>
		<p><strong>Zip code</strong> - <?=$userData['zip']?></p>
		<p><strong>Birth date</strong> - <?=birthday($userData['dob'])?>
	</div>
	
	<div id="main">
		<h2><?=$userData['fname']?>'s media</h2><br /><br />
		<?=$this->load->view('media_list')?>
	</div>
</div>
</body>
</html>