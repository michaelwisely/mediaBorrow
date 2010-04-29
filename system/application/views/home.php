<?=$this->load->view('header')?>

<div id="container">
	<div id="sidebar">
		This is where friend requests and borrow requests will be viewed.
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