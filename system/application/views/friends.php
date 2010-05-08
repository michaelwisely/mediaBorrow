<?=$this->load->view('header')?>
<div id="container">
	<h2>Friend Requests:</h2>
	<?php foreach($requests as $req):?>
		<li><?=$req?></li>
	<?php endforeach;?>
	<h2>Friends:</h2>
	<?php foreach($friends as $friend):?>
		<li><?=$friend ?></li>
	<?php endforeach;?>
	<br>
</div>
<?$this->load->view('footer')?>