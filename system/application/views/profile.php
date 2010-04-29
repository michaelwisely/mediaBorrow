<?=$this->load->view('header')?>
<div id="container">
	<div id="sidebar">
		sdf
		sdf
	</div>
	
	<div id="main">
		<h1><?=$userData['fname']?> <?=$userData['lname']?></h1>
		<h2>Books:</h2>
		<?php foreach($books as $book):?>
			<li><?=$book['title']?></li>
		<?php endforeach;?>
		<h2>Friend Requests:</h2>
		<?php foreach($requests as $req):?>
			<li><?=$req?></li>
		<?php endforeach;?>
	</div>
</div>
</body>
</html>