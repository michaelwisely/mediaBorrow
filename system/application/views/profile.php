<?=$this->load->view('header')?>
<div id="container">
	<h1><?=$userData?>'s Profile Info</h1>
	<?php foreach($userData as $key => $value):?>
		<li><?=$key?> = <?=$value?></li>
	<?php endforeach;?>
</div>
</body>
</html>